
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
    $sql = "SELECT Fecha, count(*) AS ventas FROM ventas GROUP BY Fecha";

    $resultado = $conn->query($sql);
    // Paso 2 MOver Datos al array
    while ($fila = $resultado->fetch_assoc()) {
        $fechas[] = $fila["Fecha"];
        $ventas[] = $fila["ventas"];
    }
    $resultado = $conn->query($sql);
?>
+
<!DOCTYPE html>

<html>

<head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Ventas</title>

</head>

<body>

<h2>Lista de Ventas</h2>

<script>
const fechas = <?php echo json_encode($fechas); ?>;
const ventas = <?php echo json_encode($ventas); ?>;
</script>
<div style="width: 400px; height: 250px;">

    <canvas id="graficoVentas" ></canvas>
</div>

<script>
const ctx = document.getElementById('graficoVentas');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: fechas,
        datasets: [{
            label: 'Totales de ventas',
            data: ventas
        }]
    }
});
</script>


</body>

</html>