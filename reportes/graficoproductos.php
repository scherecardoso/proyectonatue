<?php
session_start();
require("../ajax/php/conexion.php");

if(!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])){
    header("Location: ../usuario/09.register.php");
    exit();
}

$rol = $_SESSION['rol'];
$sql = "SELECT p.codigo,p.nombre,COALESCE(vm.cantidad_vendida, 0) AS cantidad_vendida FROM productos p

LEFT JOIN (SELECT c.productos_codigo,SUM(c.cantidad) AS cantidad_vendida FROM carrito c
    INNER JOIN ventas v ON c.pedidos_id = v.pedidos_id
    INNER JOIN pedidos pe ON v.pedidos_id = pe.id
    WHERE MONTH(pe.fecha) = MONTH(CURDATE()) AND YEAR(pe.fecha) = YEAR(CURDATE()) GROUP BY c.productos_codigo) vm  ON p.codigo = vm.productos_codigo
ORDER BY cantidad_vendida DESC, p.nombre ASC";

$resultado = $conn->query($sql);

if(!$resultado){
    die("Error en la consulta: " . $conn->error);
}
$nombres = [];
$cantidades = [];

while($fila = $resultado->fetch_assoc()){
    $nombres[] = $fila["nombre"];
    $cantidades[] = (int)$fila["cantidad_vendida"];
}

$productoMasVendido = "Ninguno";
$cantidadMayor = 0;
for($i = 0; $i < count($nombres); $i++){

    if($cantidades[$i] > $cantidadMayor){

        $cantidadMayor = $cantidades[$i];
        $productoMasVendido = $nombres[$i];

    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos más vendidos</title>
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
}

.contenedor{
    width:90%;
    max-width:1100px;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-sizing:border-box;
}

h1{
    text-align:center;
    margin-bottom:10px;
    color:#222;
}

.subtitulo{
    text-align:center;
    color:#666;
    margin-bottom:25px;
}

.producto-principal{
    width:100%;
    background:#f2f2f2;
    padding:20px;
    border-radius:10px;
    text-align:center;
    margin-bottom:30px;
    box-sizing:border-box;
}

.producto-principal h2{
    margin:0 0 10px 0;
    font-size:20px;
}

.producto-principal p{
    margin:5px;
    font-size:18px;
}

.grafico{
    width:100%;
    height:650px;
    margin-bottom:40px;
}

.tabla-contenedor{
    width:100%;
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th{
    background:#222;
    color:white;
    padding:12px;
    text-align:left;
}

td{
    padding:11px;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#f5f5f5;
}

.numero{
    text-align:center;
    width:80px;
}

.cantidad{
    text-align:center;
    font-weight:bold;
    width:130px;
}
.primero{
    font-weight:bold;
}

.sin-ventas{
    color:#999;
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

<main class="contenido">

<div class="contenedor">
    <h1>Productos más vendidos</h1>
    <div class="subtitulo">
        Ventas registradas durante el mes 
    </div>

    <div class="producto-principal">
        <h2>Producto más vendido del mes</h2>

        <?php if($cantidadMayor > 0){ ?>
            <p><strong><?php echo htmlspecialchars($productoMasVendido); ?></strong></p>
            <p><?php echo $cantidadMayor; ?> unidades vendidas</p>
        <?php }else{ ?>
            <p>No hay vtas registradas este mes.</p>

<?php } ?>

    </div>
    <div class="grafico">
        <canvas id="graficoProductos"></canvas>
    </div>

    <h2>Detalle de productos</h2>
    <div class="tabla-contenedor">
    <table>
        <thead>
            <tr>
                <th class="numero">N°</th>
                <th>Producto</th>
                <th class="cantidad">Cantidad vendida</th>
            </tr>
        </thead>

        <tbody>
        <?php
            for($i = 0; $i < count($nombres); $i++){
                $clase = "";
            if($cantidades[$i] == 0){
                $clase = "sin-ventas";
            }

            if($i == 0 && $cantidades[$i] > 0){
                $clase = "primero";
            }
        ?>


        <tr class="<?php echo $clase; ?>">
            <td class="numero"><?php echo $i + 1; ?></td>
            <td><?php echo htmlspecialchars($nombres[$i]); ?></td>
            <td class="cantidad"><?php echo $cantidades[$i]; ?></td>
        </tr>

<?php } ?>

        </tbody>
        </table>
    </div>
</div>


<script>

    const nombres = <?php echo json_encode($nombres); ?>;
    const cantidades = <?php echo json_encode($cantidades); ?>;
    const ctx = document
        .getElementById("graficoProductos")
        .getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: nombres,
            datasets: [{
                label: "Unidades vendidas",
                data: cantidades,
                borderWidth: 1
            }]

        },

        options: {
            indexAxis: "y",
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {

                        precision: 0
                    },

                    title: {
                        display: true,
                        text: "Cantidad vendida"
                    }

                },

                y: {
                    title: {
                        display: true,
                        text: "Productos"

                    }

                }

            },

            plugins: {

                legend: {

                    display: true

                },
                tooltip: {
                    callbacks: {
                        label: function(context){
                            return context.raw + " unidades vendidas";

                        }

                    }

                }

            }

        }

    });

</script>
</main>

</body>

</html>