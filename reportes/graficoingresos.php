<?php
// Inicia o recupera la sesión para validar el acceso antes de mostrar el reporte.
session_start();

// Solo los usuarios con rol de administrador o vendedor pueden consultar esta página.
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    // Si el usuario no tiene un rol autorizado, se redirige al registro y se detiene la ejecución.
    header("Location: ../usuario/09.register.php");
    exit();
}

// Conserva el rol para decidir más adelante qué menú incluir.
$rol = $_SESSION['rol'];

// Carga la conexión a la base de datos utilizada por las consultas del reporte.
require("../ajax/php/conexion.php");

// El periodo se recibe por la URL; por defecto se muestran los ingresos agrupados por día.
$periodo = $_GET['periodo'] ?? 'dia';

// Estos arreglos mantienen las etiquetas y los importes en posiciones correspondientes.
$periodos = [];
$ingresos = [];
// El título se reutiliza en el encabezado, el resumen y las etiquetas del gráfico.
$titulo = "";

// Consulta y organiza los ingresos por fecha.
if ($periodo == "dia") {
    $titulo = "Ingresos por día";

    $sql = "SELECT p.fecha, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY p.fecha
            ORDER BY p.fecha ASC";

    // Ejecuta la consulta diaria y transforma las fechas para que sean legibles en pantalla.
    $resultado = $conn->query($sql);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $periodos[] = date("d/m/Y", strtotime($fila["fecha"]));
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }

// Para la vista semanal se agrupa usando el año y la semana ISO (la semana comienza el lunes).
} elseif ($periodo == "semana") {
    $titulo = "Ingresos por semana";

    $sql = "SELECT YEAR(p.fecha) AS anio, WEEK(p.fecha, 1) AS semana, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha), WEEK(p.fecha, 1)
            ORDER BY anio ASC, semana ASC";

    $resultado = $conn->query($sql);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $periodos[] = "Semana " . $fila["semana"] . " - " . $fila["anio"];
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }

// Para la vista mensual se agrupan los registros por año y número de mes.
} elseif ($periodo == "mes") {
    $titulo = "Ingresos por mes";

    $sql = "SELECT YEAR(p.fecha) AS anio, MONTH(p.fecha) AS mes, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha), MONTH(p.fecha)
            ORDER BY anio ASC, mes ASC";

    $resultado = $conn->query($sql);

    // Traduce los números de mes devueltos por SQL a nombres en español.
    $meses = [
        1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
        5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
        9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
    ];

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $periodos[] = $meses[(int)$fila["mes"]] . " " . $fila["anio"];
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }

// Para la vista anual se suman los importes de cada año.
} elseif ($periodo == "anio") {
    $titulo = "Ingresos por año";

    $sql = "SELECT YEAR(p.fecha) AS anio, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha)
            ORDER BY anio ASC";

    $resultado = $conn->query($sql);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $periodos[] = $fila["anio"];
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }

// Si llega un valor no reconocido por la URL, se vuelve a la vista diaria predeterminada.
} else {
    $periodo = "dia";
    $titulo = "Ingresos por día";
}

// Obtiene el total general de ventas con una fecha asociada, sin depender del periodo elegido.
$sqlTotal = "SELECT SUM(v.costo) AS total
             FROM ventas v
             INNER JOIN pedidos p ON v.pedidos_id = p.id
             WHERE p.fecha IS NOT NULL";

// Si no hay resultados, el total queda en cero para poder mostrarlo sin errores.
$resultadoTotal = $conn->query($sqlTotal);
$totalIngresos = 0;

if ($resultadoTotal) {
    $filaTotal = $resultadoTotal->fetch_assoc();
    $totalIngresos = (float)($filaTotal["total"] ?? 0);
}

// Calcula por separado la suma de ingresos correspondiente a cada método de pago.
$sqlMetodos = "SELECT v.metodo, SUM(v.costo) AS total
               FROM ventas v
               INNER JOIN pedidos p ON v.pedidos_id = p.id
               WHERE p.fecha IS NOT NULL
               GROUP BY v.metodo
               ORDER BY total DESC";

$resultadoMetodos = $conn->query($sqlMetodos);

// Estos arreglos alimentan las etiquetas y los segmentos del gráfico circular.
$metodos = [];
$totalesMetodos = [];

if ($resultadoMetodos) {
    while ($fila = $resultadoMetodos->fetch_assoc()) {
        $metodos[] = $fila["metodo"];
        $totalesMetodos[] = (float)$fila["total"];
    }
}
?>
// Comienza la estructura HTML de la página del reporte.
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de ingresos</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

/* Estilos del diseño general, las tarjetas de resumen, los gráficos y la tabla. */

html {
    overflow-x: hidden;
}

/* El grid reserva espacio para la barra superior, el menú y el contenido principal. */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #ffffff;
    min-height: 100vh;
    max-width: 100%;
    overflow-x: hidden;
    display: grid;
    grid-template-columns: 330px minmax(0, 1fr);
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "barra barra"
        "menu  contenido";
    gap: 0;
}

/* En pantallas estrechas, las regiones se apilan en una sola columna. */
@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto auto 1fr;
        grid-template-areas:
            "barra"
            "menu"
            "contenido";
    }
}



/* Área principal: evita desbordamientos y adapta el espacio interior al ancho disponible. */
.contenido {
    grid-area: contenido;
    box-sizing: border-box;
    width: 100%;
    min-width: 0;
    padding: clamp(15px, 3vw, 30px);
}

/* Centra y limita el ancho del contenido para facilitar su lectura en pantallas grandes. */
.contenedor {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Encabezado flexible con el título del reporte y su distintivo. */
.encabezado {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.titulo h1 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: clamp(26px, 4vw, 32px);
    font-weight: 600;
    color: #ff5ca8;
}

.titulo p {
    margin: 7px 0 0;
    color: #777;
    font-family: "Quicksand", sans-serif;
    font-size: 15px;
}

.badge {
    background: #fff1f7;
    color: #ff5ca8;
    padding: 10px 18px;
    border-radius: 20px;
    font-family: "Quicksand", sans-serif;
    font-size: 14px;
    font-weight: 600;
}



/* Distribuye las tarjetas de resumen en columnas que se ajustan al espacio disponible. */
.resumen {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
    gap: 22px;
    margin-bottom: 25px;
}

/* Apariencia común de las tarjetas con indicadores principales. */
.tarjeta {
    min-width: 0;
    box-sizing: border-box;
    background: white;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: clamp(20px, 3vw, 30px);
    min-height: 140px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.tarjeta-titulo {
    color: #777;
    font-family: "Quicksand", sans-serif;
    font-size: 15px;
    margin-bottom: 10px;
}

.tarjeta-valor {
    font-family: "Playfair Display", serif;
    font-size: clamp(24px, 4vw, 32px);
    font-weight: 600;
    color: #292929;
    word-break: break-word;
}

.tarjeta-sub {
    margin-top: 7px;
    color: #ff5ca8;
    font-size: 14px;
    font-weight: 600;
}



/* Selector de periodo: los enlaces actualizan el parámetro de la URL. */
.botones {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 25px;
    flex-wrap: wrap;
}

.botones a {
    text-decoration: none;
    color: #555;
    background: #ffffff;
    border: 1px solid #dddddd;
    padding: 11px 25px;
    border-radius: 25px;
    font-family: "Quicksand", sans-serif;
    font-size: 14px;
    font-weight: 600;
    transition: 0.2s;
}

.botones a:hover {
    background: #f8e5ee;
    color: #d94f87;
    border-color: #ff90ba;
}

/* Diferencia visualmente el periodo actualmente seleccionado. */
.botones a.activo {
    background: #ff5ca8;
    color: white;
    border-color: #ff65a2;
}


/* Apariencia compartida por los paneles de gráficos, resumen y tabla. */
.grafico-principal,
.grafico-metodo,
.informacion,
.tabla-contenedor {
    background: white;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: clamp(18px, 3vw, 30px);
    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
    min-width: 0;
    box-sizing: border-box;
}

.grafico-principal {
    margin-bottom: 25px;
}

.grafico-titulo {
    margin-bottom: 20px;
}

.grafico-titulo h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: clamp(20px, 3vw, 24px);
    font-weight: 600;
    color: #292929;
}

.grafico-titulo p {
    margin: 6px 0 0;
    color: #888;
    font-size: 14px;
}

/* La altura fija del contenedor permite que Chart.js ajuste el canvas correctamente. */
.grafico {
    position: relative;
    height: 390px;
    width: 100%;
}

/* Coloca el gráfico de métodos y el resumen uno junto al otro cuando hay espacio. */
.graficos-secundarios {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 380px), 1fr));
    gap: 25px;
    margin-bottom: 25px;
}

.grafico-metodo h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: clamp(19px, 3vw, 23px);
    font-weight: 600;
    color: #ff5ca8;
}

.grafico-metodo p {
    color: #888;
    font-size: 14px;
    margin: 7px 0 20px;
}

/* Contenedor del gráfico circular de métodos de pago. */
.grafico-dona {
    position: relative;
    height: 330px;
    width: 100%;
}

.informacion h2 {
    margin: 0 0 15px;
    font-family: "Playfair Display", serif;
    font-size: clamp(19px, 3vw, 22px);
    color: #ff5ca8;
}

.dato {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 13px 0;
    border-bottom: 1px solid #e8e8e8;
    font-size: 14px;
}

.dato:last-child {
    border-bottom: none;
}

.dato strong {
    color: #ff5ca8;
    text-align: right;
}



.tabla-titulo {
    margin-bottom: 20px;
}

.tabla-titulo h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: clamp(20px, 3vw, 24px);
    font-weight: 600;
    color: #ff5ca8;
}

.tabla-titulo p {
    margin: 6px 0 0;
    color: #888;
    font-size: 14px;
}

/* Permite desplazar la tabla horizontalmente si no cabe en pantallas pequeñas. */
.tabla-scroll {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #fff1f7;
    padding: 15px;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
    color: #ff5ca8;
}

td {
    background: #ffffff;
    padding: 15px;
    text-align: center;
    border-top: 1px solid #f3f3f3;
    border-bottom: 1px solid #f3f3f3;
    font-size: 14px;
}

tr:hover td {
    background: #fff8fb;
}

.ingreso {
    color: #ff5ca8;
    font-weight: 700;
}

/* Reduce la altura del gráfico en dispositivos de tamaño mediano. */
@media (max-width: 900px) {
    .grafico {
        height: 350px;
    }
}



/* Ajustes de espaciado y altura específicos para teléfonos. */
@media (max-width: 600px) {
    .contenido {
        padding: 15px 12px;
    }

    .encabezado {
        margin-bottom: 18px;
    }

    .resumen,
    .graficos-secundarios {
        gap: 15px;
    }

    .botones {
        gap: 8px;
    }

    .botones a {
        flex: 1 1 40%;              
        text-align: center;
        padding: 10px 12px;
    }

    .grafico {
        height: 300px;
    }

    .grafico-dona {
        height: 300px;
    }

    .grafico-principal,
    .grafico-metodo,
    .informacion,
    .tabla-contenedor {
        border-radius: 14px;
    }

    th,
    td {
        padding: 10px 8px;
    }
}
</style>
</head>
<body>

<!-- La cabecera compartida del sitio se muestra sobre el área de navegación. -->
<?php include("../includes/header.php"); ?>

<?php
// El menú lateral cambia según el rol autorizado que inició sesión.
if ($rol == "administrador") {
    include("../includes/includeadmin.php");
} else {
    include("../includes/includevendedor.php");
}
?>

<!-- Contenido propio del reporte de ingresos. -->
<main class="contenido">
<div class="contenedor">

<div class="encabezado">
    <div class="titulo">
        <h1>Reporte de ingresos</h1>
        <p>Consulta los ingresos obtenidos por las ventas registradas</p>
    </div>
    <div class="badge">Reporte de ventas</div>
</div>

<!-- Indicadores generales: total histórico de ingresos y cantidad de periodos consultados. -->
<div class="resumen">

    <div class="tarjeta">
        <div class="tarjeta-titulo">Ingresos totales</div>
        <div class="tarjeta-valor">Bs <?php echo number_format($totalIngresos, 2); ?></div>
        <div class="tarjeta-sub">Total registrado en ventas</div>
    </div>

    <div class="tarjeta">
        <div class="tarjeta-titulo">Periodo seleccionado</div>
        <div class="tarjeta-valor"><?php echo $titulo; ?></div>
        <div class="tarjeta-sub"><?php echo count($periodos); ?> registros encontrados</div>
    </div>

</div>

<!-- Cada enlace solicita nuevamente la página usando el periodo correspondiente. -->
<div class="botones">
    <a href="?periodo=dia" class="<?php echo ($periodo == 'dia') ? 'activo' : ''; ?>">Día</a>
    <a href="?periodo=semana" class="<?php echo ($periodo == 'semana') ? 'activo' : ''; ?>">Semana</a>
    <a href="?periodo=mes" class="<?php echo ($periodo == 'mes') ? 'activo' : ''; ?>">Mes</a>
    <a href="?periodo=anio" class="<?php echo ($periodo == 'anio') ? 'activo' : ''; ?>">Año</a>
</div>

<!-- Gráfico de línea que muestra la evolución de ingresos para el periodo elegido. -->
<div class="grafico-principal">
    <div class="grafico-titulo">
        <h2><?php echo $titulo; ?></h2>
        <p>Evolución de los ingresos según las ventas registradas</p>
    </div>
    <div class="grafico">
        <canvas id="graficoIngresos"></canvas>
    </div>
</div>

<!-- Sección secundaria con la distribución por método de pago y un resumen estadístico. -->
<div class="graficos-secundarios">

    <!-- Gráfico circular: cada segmento representa los ingresos de un método de pago. -->
    <div class="grafico-metodo">
        <h2>Ingresos por método de pago</h2>
        <p>Distribución de los ingresos según el método utilizado</p>
        <div class="grafico-dona">
            <canvas id="graficoMetodos"></canvas>
        </div>
    </div>

    <!-- Calcula el mayor ingreso y su posición solo cuando existen datos para mostrar. -->
    <div class="informacion">
        <h2>Resumen del reporte</h2>

        <?php
        if (count($periodos) > 0) {
            $mayorIngreso = max($ingresos);
            $posicionMayor = array_search($mayorIngreso, $ingresos);
        } else {
            $mayorIngreso = 0;
            $posicionMayor = false;
        }
        ?>

        <div class="dato">
            <span>Total de registros</span>
            <strong><?php echo count($periodos); ?></strong>
        </div>

        <div class="dato">
            <span>Mayor ingreso</span>
            <strong>Bs <?php echo number_format($mayorIngreso, 2); ?></strong>
        </div>

        <div class="dato">
            <span>Periodo con mayor ingreso</span>
            <strong>
                <?php
                if ($posicionMayor !== false) {
                    echo htmlspecialchars($periodos[$posicionMayor]);
                } else {
                    echo "Sin datos";
                }
                ?>
            </strong>
        </div>

        <div class="dato">
            <span>Total general</span>
            <strong>Bs <?php echo number_format($totalIngresos, 2); ?></strong>
        </div>

    </div>
</div>

<!-- Tabla accesible con el detalle numérico que acompaña al gráfico principal. -->
<div class="tabla-contenedor">
    <div class="tabla-titulo">
        <h2>Detalle de ingresos</h2>
        <p>Ingresos agrupados según el periodo seleccionado</p>
    </div>

    <div class="tabla-scroll">
    <table>
        <thead>
        <tr>
            <th>Periodo</th>
            <th>Ingresos</th>
        </tr>
        </thead>

        <tbody>
        <?php // Muestra una fila por cada periodo; si no hay datos, presenta un mensaje informativo.
        if (count($periodos) > 0) { ?>
            <?php for ($i = 0; $i < count($periodos); $i++) { ?>
            <tr>
                <td><?php echo htmlspecialchars($periodos[$i]); ?></td>
                <td class="ingreso">Bs <?php echo number_format($ingresos[$i], 2); ?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="2">No hay ingresos registrados.</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>
</div>

</div>
</main>

<script>
// Los datos preparados en PHP se transfieren a JavaScript para construir los gráficos.
const periodos = <?php echo json_encode($periodos); ?>;
const ingresos = <?php echo json_encode($ingresos); ?>;
const metodos = <?php echo json_encode($metodos); ?>;
const totalesMetodos = <?php echo json_encode($totalesMetodos); ?>;
const tituloPeriodo = <?php echo json_encode($titulo); ?>;

// Obtiene el canvas del gráfico principal y configura una línea con relleno y marcadores.
const contextoIngresos = document.getElementById("graficoIngresos");

new Chart(contextoIngresos, {
    type: "line",
    data: {
        labels: periodos,
        datasets: [{
            label: "Ingresos (Bs)",
            data: ingresos,
            borderColor: "#ff5ca8",
            backgroundColor: "rgba(217, 79, 135, 0.12)",
            borderWidth: 3,
            pointBackgroundColor: "#ff5ca8",
            pointBorderColor: "#ffffff",
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: "index"
        },
        // Configura la leyenda y el formato monetario de las ayudas emergentes.
        plugins: {
            legend: {
                display: true
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return " Bs " + Number(context.raw).toFixed(2);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: "Ingresos en Bs"
                }
            },
            x: {
                title: {
                    display: true,
                    text: tituloPeriodo
                }
            }
        }
    }
});

// Obtiene el canvas secundario para comparar visualmente los métodos de pago.
const contextoMetodos = document.getElementById("graficoMetodos");

new Chart(contextoMetodos, {
    type: "doughnut",
    data: {
        labels: metodos,
        datasets: [{
            data: totalesMetodos,
            backgroundColor: ["#ff5ca8", "#f28eb4", "#f7c4d7", "#bdbdbd", "#777777", "#444444"],
            borderColor: "#ffffff",
            borderWidth: 3,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: "58%",
        // La leyenda se ubica debajo de la dona y el tooltip muestra el importe en bolivianos.
        plugins: {
            legend: {
                position: "bottom",
                labels: {
                    padding: 18,
                    usePointStyle: true,
                    font: {
                        size: 13
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return " " + context.label + ": Bs " + Number(context.raw).toFixed(2);
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>