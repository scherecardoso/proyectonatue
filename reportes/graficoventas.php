
<?php

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="width: 100%; height: 350px;">
    <canvas id="graficoVentas"></canvas>
</div>

<script>

const fechas = <?php echo json_encode($fechas); ?>;
const ventas = <?php echo json_encode($ventas); ?>;

const ctxVentas = document.getElementById('graficoVentas');

new Chart(ctxVentas, {
    type: 'line',

    data: {
        labels: fechas,

        datasets: [{
            label: 'Cantidad de ventas',
            data: ventas,
            borderColor: '#6C9BCF',
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