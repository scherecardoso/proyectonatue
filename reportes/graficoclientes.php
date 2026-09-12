<?php
session_start();
require("../ajax/php/conexion.php");
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

$rol = $_SESSION['rol'];
$sql = "SELECT nombre, COUNT(*) AS cantidad_pedidos FROM pedidos WHERE nombre IS NOT NULL AND nombre != '' GROUP BY nombre ORDER BY cantidad_pedidos DESC, nombre ASC";
$resultado = $conn->query($sql);

$clienteMasFrecuente = "Sin datos";
$cantidadMayor = 0;

if ($resultado && $resultado->num_rows > 0) {
    $primero = $resultado->fetch_assoc();
    $clienteMasFrecuente = $primero['nombre'];
    $cantidadMayor = $primero['cantidad_pedidos'];
    $resultado->data_seek(0);
}

$nombres = [];
$cantidades = [];

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
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cliente más frecuente</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 198px 1fr 260px;
    grid-template-rows: 70px 1fr;
    grid-template-areas:
        "barra barra barra"
        "menu contenido contenido";
    gap: 10px;
    min-height: 100vh;
    background: #ffffff;
}

.contenido {
    grid-area: contenido;
    padding: 30px;
    box-sizing: border-box;
    width: 80%;
    min-width: 0;
    margin-left: 10%;
}

.titulo {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    margin-bottom: 10px;
}

.descripcion {
    color: #777;
    margin-bottom: 30px;
}

.tarjeta-principal {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

.tarjeta-principal h2 {
    margin: 0 0 15px 0;
    font-family: 'Playfair Display', serif;
}

.cliente {
    font-size: 28px;
    font-weight: bold;
    color: #ff5ca8;
}

.pedidos {
    color: #777;
    margin-top: 5px;
}

.grafico {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    margin-bottom: 30px;
}

.grafico h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
}

.grafico-contenedor {
    height: 450px;
}

.tabla {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}

.tabla h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    padding: 13px;
    background: #fff0f7;
}

td {
    padding: 13px;
    border-bottom: 1px solid #eeeeee;
}

tr:hover {
    background: #fafafa;
}

.sin-datos {
    text-align: center;
    padding: 30px;
    color: #888;
}

@media (max-width: 900px) {
    .contenido {
        margin-left: 0;
        padding: 20px;
    }
}
</style>
</head>
<body>

<?php
if ($rol == "administrador") {
    include("../includes/includeadmin.php");
} else {
    include("../includes/includevendedor.php");
}
?>

<div class="contenido">

    <div class="titulo">Cliente más frecuente</div>
    <div class="descripcion">Clientes con mayor cantidad de pedidos registrados.</div>

    <div class="tarjeta-principal">
        <h2>Cliente más frecuente</h2>

        <?php if ($cantidadMayor > 0) { ?>
            <div class="cliente"><?php echo htmlspecialchars($clienteMasFrecuente); ?></div>
            <div class="pedidos"><?php echo $cantidadMayor; ?> pedidos registrados</div>
        <?php } else { ?>
            <div class="sin-datos">No hay pedidos registrados.</div>
        <?php } ?>
    </div>

    <div class="grafico">
        <h2>Pedidos por cliente</h2>
        <div class="grafico-contenedor">
            <canvas id="graficoClientes"></canvas>
        </div>
    </div>

    <div class="tabla">
        <h2>Lista de clientes</h2>

        <?php $resultadoTabla = $conn->query($sql); ?>

        <?php if ($resultadoTabla && $resultadoTabla->num_rows > 0) { ?>
        <table>
            <tr>
                <th>Cliente</th>
                <th>Cantidad de pedidos</th>
            </tr>
            <?php while ($cliente = $resultadoTabla->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                <td><?php echo $cliente['cantidad_pedidos']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } else { ?>
            <div class="sin-datos">No hay clientes registrados.</div>
        <?php } ?>

    </div>

</div>

<script>
const nombres = <?php echo json_encode($nombres); ?>;
const cantidades = <?php echo json_encode($cantidades); ?>;
const ctx = document.getElementById('graficoClientes');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: nombres,
        datasets: [{
            label: 'Cantidad de pedidos',
            data: cantidades,
            backgroundColor: '#ff9bc5',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
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