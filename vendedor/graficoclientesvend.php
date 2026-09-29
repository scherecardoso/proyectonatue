<?php
session_start();

require("../ajax/php/conexion.php");

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../pagina/login.php");
    exit();
}

$rol = $_SESSION['rol'];

$sql = "SELECT nombre, COUNT(*) AS cantidad_pedidos
        FROM pedidos
        WHERE nombre IS NOT NULL AND nombre != ''
        GROUP BY nombre
        ORDER BY cantidad_pedidos DESC, nombre ASC";

$resultado = $conn->query($sql);

$clientes = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $clientes[] = [
            'nombre' => $fila['nombre'],
            'cantidad' => (int) $fila['cantidad_pedidos']
        ];
    }
}

$clienteMasFrecuente = "Sin datos";
$cantidadMayor = 0;

if (count($clientes) > 0) {
    $clienteMasFrecuente = $clientes[0]['nombre'];
    $cantidadMayor = $clientes[0]['cantidad'];
}

$graficoClientes = array_slice($clientes, 0, 10);
$nombres = array_column($graficoClientes, 'nombre');
$cantidades = array_column($graficoClientes, 'cantidad');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cliente más frecuente</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
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

.titulo {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    margin: 0 0 10px;
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
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    margin-bottom: 30px;
    min-width: 0;
}

.tarjeta-principal h2 {
    margin: 0 0 15px;
    font-family: 'Playfair Display', serif;
    color: #ff5ca8;
}

.cliente {
    font-size: 28px;
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
    width: 100%;
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
    -webkit-overflow-scrolling: touch;
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

tbody tr:hover td {
    background: #fff8fb;
}

.sin-datos {
    text-align: center;
    padding: 30px;
    color: #888;
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
}

@media (max-width: 768px) {
    .contenido {
        padding: 12px;
    }

    .titulo {
        font-size: 24px;
    }

    .descripcion {
        margin-bottom: 20px;
    }

    .tarjeta-principal,
    .grafico,
    .tabla {
        padding: 16px;
        margin-bottom: 20px;
    }

    .cliente {
        font-size: 22px;
    }

    .grafico-contenedor {
        height: 320px;
    }

    th, td {
        padding: 10px 8px;
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

        <h1 class="titulo">Cliente más frecuente</h1>
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

<?php if (count($graficoClientes) > 0) { ?>
            <div class="grafico-contenedor">
                <canvas id="graficoClientes"></canvas>
            </div>
<?php } else { ?>
            <div class="sin-datos">No hay datos para mostrar.</div>
<?php } ?>
        </div>

        <div class="tabla">
            <h2>Lista de clientes</h2>

<?php if (count($clientes) > 0) { ?>
            <div class="tabla-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Cantidad de pedidos</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($clientes as $cliente) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                            <td><?php echo $cliente['cantidad']; ?></td>
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
</main>

<?php if (count($graficoClientes) > 0) { ?>
<script>
const nombres = <?php echo json_encode($nombres); ?>;
const cantidades = <?php echo json_encode($cantidades); ?>;
const esMovil = window.innerWidth <= 768;

new Chart(document.getElementById('graficoClientes'), {
    type: 'bar',
    data: {
        labels: nombres,
        datasets: [{
            label: 'Cantidad de pedidos',
            data: cantidades,
            backgroundColor: '#ff9bc5',
            borderRadius: 6,
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: esMovil ? 'y' : 'x',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    stepSize: esMovil ? 1 : undefined,
                    autoSkip: false,
                    maxRotation: 60,
                    font: { size: esMovil ? 10 : 12 }
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: esMovil ? undefined : 1,
                    font: { size: esMovil ? 10 : 12 }
                }
            }
        }
    }
});
</script>
<?php } ?>

</body>
</html>
<?php
$conn->close();
?>