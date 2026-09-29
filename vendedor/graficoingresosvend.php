<?php
session_start();

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../pagina/login.php");
    exit();
}

$rol = $_SESSION['rol'];

require("../ajax/php/conexion.php");

$periodo = $_GET['periodo'] ?? 'dia';

if (!in_array($periodo, ['dia', 'semana', 'mes', 'anio'])) {
    $periodo = 'dia';
}

$meses = [
    1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
    5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
    9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
];

$periodos = [];
$ingresos = [];

if ($periodo == "dia") {
    $titulo = "Ingresos por día";
    $sql = "SELECT p.fecha, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY p.fecha
            ORDER BY p.fecha ASC";
} elseif ($periodo == "semana") {
    $titulo = "Ingresos por semana";
    $sql = "SELECT YEAR(p.fecha) AS anio, WEEK(p.fecha, 1) AS semana, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha), WEEK(p.fecha, 1)
            ORDER BY anio ASC, semana ASC";
} elseif ($periodo == "mes") {
    $titulo = "Ingresos por mes";
    $sql = "SELECT YEAR(p.fecha) AS anio, MONTH(p.fecha) AS mes, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha), MONTH(p.fecha)
            ORDER BY anio ASC, mes ASC";
} else {
    $titulo = "Ingresos por año";
    $sql = "SELECT YEAR(p.fecha) AS anio, SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha)
            ORDER BY anio ASC";
}

$resultado = $conn->query($sql);

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($periodo == "dia") {
            $periodos[] = date("d/m/Y", strtotime($fila["fecha"]));
        } elseif ($periodo == "semana") {
            $periodos[] = "Semana " . $fila["semana"] . " - " . $fila["anio"];
        } elseif ($periodo == "mes") {
            $periodos[] = $meses[(int)$fila["mes"]] . " " . $fila["anio"];
        } else {
            $periodos[] = (string)$fila["anio"];
        }
        $ingresos[] = (float)$fila["total_ingresos"];
    }
}

$resultadoTotal = $conn->query(
    "SELECT SUM(v.costo) AS total
     FROM ventas v
     INNER JOIN pedidos p ON v.pedidos_id = p.id
     WHERE p.fecha IS NOT NULL"
);
$totalIngresos = 0;

if ($resultadoTotal) {
    $filaTotal = $resultadoTotal->fetch_assoc();
    $totalIngresos = (float)($filaTotal["total"] ?? 0);
}

$resultadoMetodos = $conn->query(
    "SELECT v.metodo, SUM(v.costo) AS total
     FROM ventas v
     INNER JOIN pedidos p ON v.pedidos_id = p.id
     WHERE p.fecha IS NOT NULL
     GROUP BY v.metodo
     ORDER BY total DESC"
);

$metodos = [];
$totalesMetodos = [];

if ($resultadoMetodos) {
    while ($fila = $resultadoMetodos->fetch_assoc()) {
        $metodos[] = $fila["metodo"];
        $totalesMetodos[] = (float)$fila["total"];
    }
}

$mayorIngreso = 0;
$periodoMayor = "Sin datos";

if (count($ingresos) > 0) {
    $mayorIngreso = max($ingresos);
    $periodoMayor = $periodos[array_search($mayorIngreso, $ingresos)];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reporte de ingresos</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>


body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 320px minmax(0, 1fr);
    grid-template-rows: 88px 1fr;
    grid-template-areas:
        "barra barra"
        "menu-lateral contenido";
    gap: 5px;
    min-height: 100vh;
    background: #ffffff;
}

.contenido {
    grid-area: contenido;
    padding: 30px;
    min-width: 0;
}

.contenedor {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.encabezado {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.titulo h1 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: 32px;
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
    white-space: nowrap;
}

.resumen {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 22px;
    margin-bottom: 25px;
}

.tarjeta {
    background: white;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 30px;
    min-height: 155px;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
}

.tarjeta-titulo {
    color: #777;
    font-family: "Quicksand", sans-serif;
    font-size: 15px;
    margin-bottom: 10px;
}

.tarjeta-valor {
    font-family: "Playfair Display", serif;
    font-size: 32px;
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

.botones a.activo {
    background: #ff5ca8;
    color: white;
    border-color: #ff65a2;
}

.grafico-principal,
.grafico-metodo,
.informacion,
.tabla-contenedor {
    background: white;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
    min-width: 0;
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
    font-size: 24px;
    font-weight: 600;
    color: #292929;
}

.grafico-titulo p {
    margin: 6px 0 0;
    color: #888;
    font-size: 14px;
}

.grafico {
    position: relative;
    height: 390px;
    width: 100%;
}

.graficos-secundarios {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 25px;
    margin-bottom: 25px;
}

.grafico-metodo h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: 23px;
    font-weight: 600;
    color: #ff5ca8;
}

.grafico-metodo p {
    color: #888;
    font-size: 14px;
    margin: 7px 0 20px;
}

.grafico-dona {
    position: relative;
    height: 330px;
    width: 100%;
}

.sin-datos {
    text-align: center;
    padding: 40px 10px;
    color: #999;
}

.informacion h2 {
    margin: 0 0 15px;
    font-family: "Playfair Display", serif;
    font-size: 22px;
    color: #ff5ca8;
}

.dato {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
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
    font-size: 24px;
    font-weight: 600;
    color: #ff5ca8;
}

.tabla-titulo p {
    margin: 6px 0 0;
    color: #888;
    font-size: 14px;
}

.tabla-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
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
    word-break: break-word;
}

tbody tr:hover td {
    background: #fff8fb;
}

.ingreso {
    color: #ff5ca8;
    font-weight: 700;
}

@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto;
        grid-template-areas:
            "barra"
            "menu-lateral"
            "contenido";
        gap: 0;
    }

    .contenido {
        padding: 25px;
    }

    .graficos-secundarios {
        grid-template-columns: minmax(0, 1fr);
    }
}

@media (max-width: 768px) {
    .contenido {
        padding: 12px;
    }

    .encabezado {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .titulo h1 {
        font-size: 24px;
    }

    .resumen {
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .tarjeta {
        min-height: 0;
        padding: 20px;
    }

    .tarjeta-valor {
        font-size: 24px;
    }

    .botones {
        gap: 8px;
        margin-bottom: 20px;
    }

    .botones a {
        flex: 1 1 40%;
        text-align: center;
        padding: 10px 12px;
    }

    .grafico-principal,
    .grafico-metodo,
    .informacion,
    .tabla-contenedor {
        padding: 16px;
    }

    .grafico-principal,
    .graficos-secundarios {
        margin-bottom: 20px;
    }

    .graficos-secundarios {
        gap: 20px;
    }

    .grafico-titulo h2,
    .tabla-titulo h2 {
        font-size: 20px;
    }

    .grafico-metodo h2 {
        font-size: 19px;
    }

    .informacion h2 {
        font-size: 19px;
    }

    .grafico {
        height: 300px;
    }

    .grafico-dona {
        height: 300px;
    }

    th, td {
        padding: 12px 8px;
        font-size: 13px;
    }
}
</style>
</head>
<body>

<?php
include("../includes/header.php");

if ($rol == "administrador") {
    include("../includes/includeadmin.php");
} else {
    include("../includes/includeVendedor.php");
}
?>

<main class="contenido">
    <div class="contenedor">

        <div class="encabezado">
            <div class="titulo">
                <h1>Reporte de ingresos</h1>
                <p>Consulta los ingresos obtenidos por las ventas registradas</p>
            </div>
            <div class="badge">Reporte de ventas</div>
        </div>

        <div class="resumen">
            <div class="tarjeta">
                <div class="tarjeta-titulo">Ingresos totales</div>
                <div class="tarjeta-valor">Bs <?php echo number_format($totalIngresos, 2); ?></div>
                <div class="tarjeta-sub">Total registrado en ventas</div>
            </div>

            <div class="tarjeta">
                <div class="tarjeta-titulo">Periodo seleccionado</div>
                <div class="tarjeta-valor"><?php echo htmlspecialchars($titulo); ?></div>
                <div class="tarjeta-sub"><?php echo count($periodos); ?> registros encontrados</div>
            </div>
        </div>

        <div class="botones">
            <a href="?periodo=dia" class="<?php echo ($periodo == 'dia') ? 'activo' : ''; ?>">Día</a>
            <a href="?periodo=semana" class="<?php echo ($periodo == 'semana') ? 'activo' : ''; ?>">Semana</a>
            <a href="?periodo=mes" class="<?php echo ($periodo == 'mes') ? 'activo' : ''; ?>">Mes</a>
            <a href="?periodo=anio" class="<?php echo ($periodo == 'anio') ? 'activo' : ''; ?>">Año</a>
        </div>

        <div class="grafico-principal">
            <div class="grafico-titulo">
                <h2><?php echo htmlspecialchars($titulo); ?></h2>
                <p>Evolución de los ingresos según las ventas registradas</p>
            </div>

<?php if (count($ingresos) > 0) { ?>
            <div class="grafico">
                <canvas id="graficoIngresos"></canvas>
            </div>
<?php } else { ?>
            <div class="sin-datos">No hay ingresos registrados.</div>
<?php } ?>
        </div>

        <div class="graficos-secundarios">
            <div class="grafico-metodo">
                <h2>Ingresos por método de pago</h2>
                <p>Distribución de los ingresos según el método utilizado</p>

<?php if (count($totalesMetodos) > 0) { ?>
                <div class="grafico-dona">
                    <canvas id="graficoMetodos"></canvas>
                </div>
<?php } else { ?>
                <div class="sin-datos">No hay datos de métodos de pago.</div>
<?php } ?>
            </div>

            <div class="informacion">
                <h2>Resumen del reporte</h2>

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
                    <strong><?php echo htmlspecialchars($periodoMayor); ?></strong>
                </div>

                <div class="dato">
                    <span>Total general</span>
                    <strong>Bs <?php echo number_format($totalIngresos, 2); ?></strong>
                </div>
            </div>
        </div>

        <div class="tabla-contenedor">
            <div class="tabla-titulo">
                <h2>Detalle de ingresos</h2>
                <p>Ingresos agrupados según el periodo seleccionado</p>
            </div>

<?php if (count($periodos) > 0) { ?>
            <div class="tabla-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Periodo</th>
                            <th>Ingresos</th>
                        </tr>
                    </thead>
                    <tbody>
<?php for ($i = 0; $i < count($periodos); $i++) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($periodos[$i]); ?></td>
                            <td class="ingreso">Bs <?php echo number_format($ingresos[$i], 2); ?></td>
                        </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
<?php } else { ?>
            <div class="sin-datos">No hay ingresos registrados.</div>
<?php } ?>
        </div>

    </div>
</main>

<script>
const periodos = <?php echo json_encode($periodos); ?>;
const ingresos = <?php echo json_encode($ingresos); ?>;
const metodos = <?php echo json_encode($metodos); ?>;
const totalesMetodos = <?php echo json_encode($totalesMetodos); ?>;
const tituloPeriodo = <?php echo json_encode($titulo); ?>;

const esMovil = window.innerWidth <= 768;

const canvasIngresos = document.getElementById("graficoIngresos");

if (canvasIngresos) {
    new Chart(canvasIngresos, {
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
                pointRadius: esMovil ? 3 : 5,
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
            plugins: {
                legend: {
                    display: !esMovil
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
                        display: !esMovil,
                        text: "Ingresos en Bs"
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 60,
                        autoSkip: true,
                        maxTicksLimit: esMovil ? 5 : 12,
                        font: {
                            size: esMovil ? 10 : 12
                        }
                    },
                    title: {
                        display: !esMovil,
                        text: tituloPeriodo
                    }
                }
            }
        }
    });
}

const canvasMetodos = document.getElementById("graficoMetodos");

if (canvasMetodos) {
    const paleta = ["#ff5ca8", "#f28eb4", "#f7c4d7", "#bdbdbd", "#777777", "#444444"];

    const colores = metodos.map(function(_, i) {
        return i < paleta.length ? paleta[i] : "hsl(" + ((i * 47) % 360) + ", 60%, 72%)";
    });

    new Chart(canvasMetodos, {
        type: "doughnut",
        data: {
            labels: metodos,
            datasets: [{
                data: totalesMetodos,
                backgroundColor: colores,
                borderColor: "#ffffff",
                borderWidth: 3,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "58%",
            plugins: {
                legend: {
                    position: "bottom",
                    labels: {
                        padding: esMovil ? 10 : 18,
                        usePointStyle: true,
                        font: {
                            size: esMovil ? 11 : 13
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
}
</script>

</body>
</html>
<?php
$conn->close();
?>