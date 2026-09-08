
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


$sql = "SELECT nombre, COUNT(*) AS veces
        FROM pedidos
        WHERE nombre IS NOT NULL
        GROUP BY nombre
        ORDER BY veces DESC
        LIMIT 3";

$resultado = $conn->query($sql);

$nombres = [];
$veces = [];

while ($fila = $resultado->fetch_assoc()) {
    $nombres[] = $fila["nombre"];
    $veces[] = $fila["veces"];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Clientes Frecuentes</title>
</head>

<body>

<h2>Clientes Frecuentes</h2>

<script>
const nombres = <?php echo json_encode($nombres); ?>;
const veces = <?php echo json_encode($veces); ?>;
</script>

<div style="width: 700px; height: 400px;">
    <canvas id="graficoClientes"></canvas>
</div>

<script>

const ctx = document.getElementById('graficoClientes');

new Chart(ctx, {
    type: 'bar',

    data: {
        labels: nombres,

        datasets: [{
            label: 'Cantidad de pedidos',
            data: veces,
            borderWidth: 1
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
