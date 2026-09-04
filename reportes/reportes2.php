<?php
    session_start();
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $bd = "shena";
    $conn = new mysqli($servidor,$usuario,$contrasena,$bd);

    if($conn->connect_error){
        die("Error de conexión");
    }
    $ci = $_SESSION["Ci"];
    //Paso 1 Consulta SQL
    $sql = "SELECT Nombre, count(*) AS veces FROM pedido GROUP BY Nombre ORDER BY veces DESC LIMIT 3";

    $resultado = $conn->query($sql);
    // Paso 2 MOver Datos al array
    while ($fila = $resultado->fetch_assoc()) {
        $nombres[] = $fila["Nombre"];
        $veces[] = $fila["veces"];
    }
    $resultado = $conn->query($sql);
?>

<!DOCTYPE html>

<html>

<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Ventas</title>

</head>

<body>

<h2>Lista de Clientes Frecuentes</h2>

<script>
const nombres = <?php echo json_encode($nombres); ?>;
const veces = <?php echo json_encode($veces); ?>;
</script>
<div style="width: 400px; height: 250px;">

    <canvas id="graficoVentas" ></canvas>
</div>

<script>
const ctx = document.getElementById('graficoVentas');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: nombres,
        datasets: [{
            label: 'Totales de ventas',
            data: veces
        }]
    }
});
</script>


</body>

</html>