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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>


html {
    overflow-x: hidden;
}

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


.contenido {
    grid-area: contenido;
    box-sizing: border-box;
    width: 100%;
    max-width: 1100px;
    min-width: 0;
    justify-self: center;
    padding: clamp(15px, 3vw, 30px);
}

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

.tarjeta-principal h2 {
    margin: 0 0 15px 0;
    font-family: 'Playfair Display', serif;
    color: #ff5ca8;
}

.cliente {
    font-size: clamp(22px, 3.5vw, 28px);
    font-weight: bold;
    font-family: 'Playfair Display', serif;
    word-break: break-word;
}

.pedidos {
    color: #777;
    margin-top: 5px;
}

.grafico h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
}

.grafico-contenedor {
    position: relative;
    height: 450px;
}

.tabla h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
    color: #ff5ca8;
}

.tabla-scroll {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    color: #ff5ca8;
    padding: 13px;
    background: #fff1f7;
}

td {
    background: #ffffff;
    padding: 13px;
    border-top: 1px solid #f3f3f3;
    border-bottom: 1px solid #f3f3f3;
    word-break: break-word;
}

tr:hover td {
    background: #fafafa;
}

.sin-datos {
    text-align: center;
    padding: 30px;
    color: #888;
}



@media (max-width: 900px) {
    .grafico-contenedor {
        height: 380px;
    }
}


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

<?php include("../includes/header.php"); ?>

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
        <div class="tabla-scroll">
        <table>
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Cantidad de pedidos</th>
            </tr>
            </thead>
            <tbody>
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
            backgroundColor: '#ff89c0',
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