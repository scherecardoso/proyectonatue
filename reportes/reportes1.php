
<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión");
}

$sql = "SELECT p.fecha, COUNT(*) AS ventas
        FROM ventas v
        INNER JOIN pedidos p ON v.pedidos_id = p.id
        GROUP BY p.fecha
        ORDER BY p.fecha ASC";

$resultado = $conn->query($sql);

$fechas = [];
$ventas = [];

while ($fila = $resultado->fetch_assoc()) {
    $fechas[] = $fila["fecha"];
    $ventas[] = $fila["ventas"];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Reporte de Ventas</title>
</head>

<body>

<h2>Reporte de Ventas</h2>

<script>
const fechas = <?php echo json_encode($fechas); ?>;
const ventas = <?php echo json_encode($ventas); ?>;
</script>

<div style="width: 700px; height: 400px;">
    <canvas id="graficoVentas"></canvas>
</div>

<script>
const ctx = document.getElementById('graficoVentas');

new Chart(ctx, {
    type: 'line',

    data: {
        labels: fechas,

        datasets: [{
    label: 'Cantidad de ventas',
    data: ventas,
    borderColor: '#cf6cb0',
    backgroundColor: 'rgba(108, 155, 207, 0.2)',
    borderWidth: 2,
    tension: 0.3
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>