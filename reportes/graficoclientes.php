<?php
// Inicia o recupera la sesión para comprobar los permisos del usuario.
session_start();
// Carga la conexión a la base de datos compartida por el proyecto.
require("../ajax/php/conexion.php");
// Solo los administradores y vendedores pueden consultar este reporte.
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    // Si el usuario no tiene un rol permitido, se le envía al registro y se detiene la página.
    header("Location: ../usuario/09.register.php");
    exit();
}

// Conserva el rol para elegir el menú que se mostrará en la página.
$rol = $_SESSION['rol'];
// Cuenta los pedidos agrupados por nombre de cliente; excluye nombres vacíos o nulos.
// Ordena primero los clientes con más pedidos y, en caso de empate, alfabéticamente.
$sql = "SELECT nombre, COUNT(*) AS cantidad_pedidos FROM pedidos WHERE nombre IS NOT NULL AND nombre != '' GROUP BY nombre ORDER BY cantidad_pedidos DESC, nombre ASC";
// Ejecuta la consulta que alimenta el resumen y los datos del gráfico.
$resultado = $conn->query($sql);

// Valores predeterminados para el caso en que la consulta no devuelva clientes.
$clienteMasFrecuente = "Sin datos";
$cantidadMayor = 0;

// Si existen resultados, la primera fila es el cliente con más pedidos por el orden de la consulta.
if ($resultado && $resultado->num_rows > 0) {
    $primero = $resultado->fetch_assoc();
    $clienteMasFrecuente = $primero['nombre'];
    $cantidadMayor = $primero['cantidad_pedidos'];
    // Vuelve al inicio para recorrer también la primera fila al preparar los datos del gráfico.
    $resultado->data_seek(0);
}

// Estos arreglos se convierten más adelante en las etiquetas y valores de Chart.js.
$nombres = [];
$cantidades = [];

// Copia cada cliente y su cantidad de pedidos desde el resultado SQL a arreglos de PHP.
if ($resultado) {
    while ($cliente = $resultado->fetch_assoc()) {
        $nombres[] = $cliente['nombre'];
        $cantidades[] = $cliente['cantidad_pedidos'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<!-- Metadatos básicos: codificación de caracteres y ajuste para pantallas móviles. -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cliente más frecuente</title>
<!-- Recursos externos para tipografías, iconos y la biblioteca de gráficos. -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

/* Evita que elementos anchos generen desplazamiento horizontal en la página. */
html {
    overflow-x: hidden;
}

/* Distribución general: encabezado arriba, menú lateral y contenido debajo. */
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

/* En pantallas medianas o pequeñas, apila el encabezado, el menú y el contenido. */
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

/* Área principal del reporte, centrada y limitada para facilitar su lectura. */
.contenido {
    grid-area: contenido;
    box-sizing: border-box;
    width: 100%;
    max-width: 1100px;
    min-width: 0;
    justify-self: center;
    padding: clamp(15px, 3vw, 30px);
}

/* Título principal y texto descriptivo del reporte. */
.titulo {
    font-family: 'Playfair Display', serif;
    font-size: clamp(26px, 4vw, 32px);
    margin-bottom: 10px;
    color: #ff5ca8;
}

.descripcion {
    color: #777;
    margin-bottom: 30px;
}

/* Estilo compartido por las tarjetas del resumen, gráfico y tabla. */
.tarjeta-principal,
.grafico,
.tabla {
    background: white;
    padding: clamp(18px, 3vw, 25px);
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    margin-bottom: 30px;
    min-width: 0;
    box-sizing: border-box;
}

/* Destaca el encabezado de la tarjeta del cliente más frecuente. */
.tarjeta-principal h2 {
    margin: 0 0 15px 0;
    font-family: 'Playfair Display', serif;
    color: #ff5ca8;
}

/* Nombre destacado del cliente con más pedidos. */
.cliente {
    font-size: clamp(22px, 3.5vw, 28px);
    font-weight: bold;
    font-family: 'Playfair Display', serif;
    word-break: break-word;
}

/* Texto secundario que indica cuántos pedidos tiene el cliente destacado. */
.pedidos {
    color: #777;
    margin-top: 5px;
}

/* Tipografía y separación del título que acompaña al gráfico. */
.grafico h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
}

/* Reserva una altura para que Chart.js dibuje el gráfico de forma adaptable. */
.grafico-contenedor {
    position: relative;
    height: 450px;
}

/* Presentación del título de la tabla de clientes. */
.tabla h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
    color: #ff5ca8;
}

/* Permite desplazarse horizontalmente si la tabla supera el ancho disponible. */
.tabla-scroll {
    width: 100%;
    overflow-x: auto;
}

/* Reglas visuales básicas para la tabla y sus celdas. */
table {
    width: 100%;
    border-collapse: collapse;
}

/* Encabezados con fondo rosado claro y texto alineado a la izquierda. */
th {
    text-align: left;
    color: #ff5ca8;
    padding: 13px;
    background: #fff1f7;
}

/* Celdas de datos con separadores discretos y ajuste de palabras largas. */
td {
    background: #ffffff;
    padding: 13px;
    border-top: 1px solid #f3f3f3;
    border-bottom: 1px solid #f3f3f3;
    word-break: break-word;
}

/* Resalta suavemente la fila de la tabla cuando el cursor pasa sobre ella. */
tr:hover td {
    background: #fafafa;
}

/* Mensaje centrado que se utiliza cuando no hay información que mostrar. */
.sin-datos {
    text-align: center;
    padding: 30px;
    color: #888;
}


/* Reduce la altura del gráfico en tabletas y ventanas de menor ancho. */
@media (max-width: 900px) {
    .grafico-contenedor {
        height: 380px;
    }
}


/* Ajustes adicionales para teléfonos: márgenes, títulos, gráfico y celdas. */
@media (max-width: 600px) {
    .contenido {
        padding: 15px 12px;
    }

    .descripcion {
        margin-bottom: 20px;
    }

    .tarjeta-principal,
    .grafico,
    .tabla {
        margin-bottom: 20px;
    }

    .grafico h2,
    .tabla h2,
    .tarjeta-principal h2 {
        font-size: 20px;
    }

    .grafico-contenedor {
        height: 300px;
    }

    th,
    td {
        padding: 10px 8px;
        font-size: 14px;
    }
}
</style>
</head>
<body>

<!-- Encabezado general compartido por las páginas del sitio. -->
<?php include("../includes/header.php"); ?>

<?php
// Muestra el menú correspondiente al rol que inició sesión.
if ($rol == "administrador") {
    include("../includes/includeadmin.php");
} else {
    include("../includes/includevendedor.php");
}
?>

<!-- Contenido principal del reporte de clientes. -->
<div class="contenido">

    <!-- Título y descripción que explican qué datos presenta el reporte. -->
    <div class="titulo">Cliente más frecuente</div>
    <div class="descripcion">Clientes con mayor cantidad de pedidos registrados.</div>

    <!-- Tarjeta de resumen: muestra el cliente con más pedidos o un mensaje vacío. -->
    <div class="tarjeta-principal">
        <h2>Cliente más frecuente</h2>

        <?php if ($cantidadMayor > 0) { ?>
            <div class="cliente"><?php echo htmlspecialchars($clienteMasFrecuente); ?></div>
            <div class="pedidos"><?php echo $cantidadMayor; ?> pedidos registrados</div>
        <?php } else { ?>
            <div class="sin-datos">No hay pedidos registrados.</div>
        <?php } ?>
    </div>

    <!-- Contenedor donde JavaScript dibuja el gráfico de pedidos por cliente. -->
    <div class="grafico">
        <h2>Pedidos por cliente</h2>
        <div class="grafico-contenedor">
            <canvas id="graficoClientes"></canvas>
        </div>
    </div>

    <!-- Tabla con el detalle completo de clientes y sus cantidades de pedidos. -->
    <div class="tabla">
        <h2>Lista de clientes</h2>

        <!-- Se ejecuta nuevamente la consulta para recorrer las filas de la tabla. -->
        <?php $resultadoTabla = $conn->query($sql); ?>

        <!-- Si hay filas, se muestran en una tabla; si no, se presenta un aviso. -->
        <?php if ($resultadoTabla && $resultadoTabla->num_rows > 0) { ?>
        <div class="tabla-scroll">
        <table>
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Cantidad de pedidos</th>
            </tr>
            </thead>
            <tbody>
            <!-- Cada fila contiene el nombre del cliente y el total de sus pedidos. -->
            <?php while ($cliente = $resultadoTabla->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                <td><?php echo $cliente['cantidad_pedidos']; ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
        <?php } else { ?>
            <div class="sin-datos">No hay clientes registrados.</div>
        <?php } ?>

    </div>

</div>

<script>
// PHP entrega al navegador los nombres y cantidades en formato JSON válido para JavaScript.
const nombres = <?php echo json_encode($nombres); ?>;
const cantidades = <?php echo json_encode($cantidades); ?>;
// Obtiene el elemento canvas donde se representarán los datos.
const ctx = document.getElementById('graficoClientes');

// Configura y dibuja un gráfico de barras con la cantidad de pedidos de cada cliente.
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: nombres,
        datasets: [{
            label: 'Cantidad de pedidos',
            data: cantidades,
            backgroundColor: '#ff89c0',
            borderWidth: 1
        }]
    },
    options: {
        // Hace que el gráfico se adapte al ancho disponible y use la altura del contenedor.
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                // El eje vertical comienza en cero y muestra valores enteros.
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

</body>
</html>