
<?php

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div style="width: 100%; height: 350px;">
    <canvas id="graficoClientes"></canvas>
</div>

<script>

const nombres = <?php echo json_encode($nombres); ?>;
const veces = <?php echo json_encode($veces); ?>;

const ctxClientes = document.getElementById('graficoClientes');

new Chart(ctxClientes, {
    type: 'bar',

    data: {
        labels: nombres,

        datasets: [{
            label: 'Cantidad de pedidos',
            data: veces,
            backgroundColor: [
                '#6C9BCF',
                '#A8C7E8',
                '#D9E8F5'
            ],
            borderColor: '#555555',
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
