
<?php
session_start();

require("../ajax/php/conexion.php");

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

$rol = $_SESSION['rol'];
$fechaConsulta = '2026-09-19';

$sql = "SELECT v.id, v.pedidos_id, v.costo, v.metodo, v.estado, p.nombre, p.fecha
        FROM ventas v
        INNER JOIN pedidos p ON v.pedidos_id = p.id
        WHERE p.fecha = '$fechaConsulta'
        AND v.estado = 'Entregado'
        ORDER BY v.id DESC";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

$sqlTotal = "SELECT COALESCE(SUM(v.costo), 0) AS total, COUNT(*) AS cantidad
             FROM ventas v
             INNER JOIN pedidos p ON v.pedidos_id = p.id
             WHERE p.fecha = '$fechaConsulta'
             AND v.estado = 'Entregado'";

$resultadoTotal = $conn->query($sqlTotal);

if (!$resultadoTotal) {
    die("Error al calcular el total: " . $conn->error);
}

$datosTotal = $resultadoTotal->fetch_assoc();

$total = $datosTotal['total'];
$cantidad = $datosTotal['cantidad'];

$ventasGrafico = [];
$ingresosGrafico = [];

$sqlGrafico = "SELECT v.id, v.costo
               FROM ventas v
               INNER JOIN pedidos p ON v.pedidos_id = p.id
               WHERE p.fecha = '$fechaConsulta'
               AND v.estado = 'Entregado'
               ORDER BY v.id ASC";

$resultadoGrafico = $conn->query($sqlGrafico);

if ($resultadoGrafico) {
    while ($fila = $resultadoGrafico->fetch_assoc()) {
        $ventasGrafico[] = "Venta " . $fila['id'];
        $ingresosGrafico[] = (float) $fila['costo'];
    }
}

$fechaMostrar = date("d/m/Y", strtotime($fechaConsulta));
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ventas totales del día</title>

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
    width: 100%;
    min-width: 0;
       width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0,0,0,.08);
    border: 1px solid #f3f3f3;
    box-sizing: border-box;
}

.titulo {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    margin-bottom: 10px;
    color: #ff5ca8;
}

.fecha {
    color: #777;
    margin-bottom: 30px;
}

.tarjetas {
    display: flex;
    gap: 25px;
    margin-bottom: 35px;
    flex-wrap: wrap;
}

.tarjeta {
    background: white;
    width: 230px;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    transition: 0.3s;
}

.tarjeta:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255,92,168,0.15);
}

.tarjeta h3 {
    margin: 0 0 10px;
    font-size: 16px;
    color: #777;
}

.tarjeta p {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
    color: #ff5ca8;
}

.grafico-contenedor {
    background: white;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 3px 15px rgba(0,0,0,0.07);
    margin-bottom: 35px;
}

.grafico-contenedor h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
    margin-bottom: 25px;
    color: #333;
}

.grafico {
    width: 100%;
    max-width: 900px;
    height: 350px;
    margin: auto;
}

.tabla-contenedor {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    overflow-x: auto;
    
}

.tabla-contenedor h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
    color: #ff5ca8;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #fff1f7;
    padding: 16px;
    font-size: 14px;
    color: #ff5ca8;
    text-align: center;
}

td {
    background: #ffffff;
    padding: 16px;
    font-size: 14px;
    text-align: center;
    border-top: 1px solid #f3f3f3;
    border-bottom: 1px solid #f3f3f3;
}

tr:hover {
    background: #fff8fb;
}

.estado {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    background: #fff1f7;
    color: #ff5ca8;
    font-size: 13px;
    white-space: nowrap;
}

.sin-ventas {
    text-align: center;
    padding: 30px;
    color: #888;
}

@media (max-width: 900px) {
    body {
        display: block;
    }

    .contenido {
        padding: 20px;
    }

    .tarjeta {
        flex: 1 1 180px;
        width: auto;
    }

    .grafico {
        height: 300px;
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
    include("../includes/includevendedor.php");
}
?>

<main class="contenido">

    <h1 class="titulo">Ventas totales del día</h1>
    <div class="fecha"><?php echo $fechaMostrar; ?></div>

    <div class="tarjetas">

        <div class="tarjeta">
            <h3>Ventas realizadas</h3>
            <p><?php echo $cantidad; ?></p>
        </div>

        <div class="tarjeta">
            <h3>Total vendido</h3>
            <p>Bs <?php echo number_format($total, 2); ?></p>
        </div>

    </div>

    <div class="grafico-contenedor">
        <h2>Ingresos de las ventas del día</h2>

        <div class="grafico">
            <canvas id="graficoVentas"></canvas>
        </div>
    </div>

    <div class="tabla-contenedor">
        <h2>Ventas registradas del día</h2>

        <?php if ($resultado->num_rows > 0) { ?>

        <table>
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Método de pago</th>
                    <th>Estado del pedido</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($venta = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($venta['id']); ?></td>

                    <td>
                        <?php echo htmlspecialchars($venta['pedidos_id']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($venta['nombre']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($venta['metodo']); ?>
                    </td>

                    <td>
                        <span class="estado">
                            <?php echo htmlspecialchars($venta['estado']); ?>
                        </span>
                    </td>

                    <td>
                        Bs <?php echo number_format((float) $venta['costo'], 2); ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php } else { ?>

        <div class="sin-ventas">
            No hay ventas registradas para esta fecha.
        </div>

        <?php } ?>

    </div>

</main>

<script>
const ventas = <?php echo json_encode($ventasGrafico); ?>;
const ingresos = <?php echo json_encode($ingresosGrafico); ?>;

const contexto = document.getElementById("graficoVentas");

new Chart(contexto, {
    type: "line",
    data: {
        labels: ventas,
        datasets: [{
            label: "Ventas (Bs)",
            data: ingresos,
            borderColor: "#ff5ca8",
            backgroundColor: "rgba(255,92,168,0.15)",
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
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: "#333",
                callbacks: {
                    label: function(context) {
                        return " Bs " + context.parsed.y.toFixed(2);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: "rgba(0,0,0,0.06)"
                },
                title: {
                    display: true,
                    text: "Ingresos en Bs"
                }
            },
            x: {
                grid: {
                    display: false
                },
                title: {
                    display: true,
                    text: "Ventas realizadas"
                }
            }
        }
    }
});
</script>

</body>
</html>

<?php
$conn->close();
?>