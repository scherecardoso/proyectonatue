<?php
session_start();

require("../ajax/php/conexion.php");

if(!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])){
    header("Location: ../usuario/09.register.php");
    exit();
}

$rol = $_SESSION['rol'];

$sql = "SELECT  v.id, v.pedidos_id, v.costo, v.metodo, v.estado, p.nombre, p.fecha FROM ventas v INNER JOIN pedidos p ON v.pedidos_id = p.id WHERE DATE(p.fecha) = CURDATE() ORDER BY v.id DESC";
$resultado = $conn->query($sql);
$sqlTotal = "SELECT COALESCE(SUM(costo), 0) AS total,COUNT(*) AS cantidad FROM ventas v INNER JOIN pedidos p ON v.pedidos_id = p.id WHERE DATE(p.fecha) = CURDATE()";
$resultadoTotal = $conn->query($sqlTotal);
$datosTotal = $resultadoTotal->fetch_assoc();
$total = $datosTotal['total'];
$cantidad = $datosTotal['cantidad'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ventas totales del día</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

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


.contenido{
    padding:40px;
    margin-left:330px;
}


.titulo{
    font-family:'Playfair Display', serif;
    font-size:32px;
    margin-bottom:10px;
}

.fecha{
    color:#777;
    margin-bottom:30px;
}


.tarjetas{
    display:flex;
    gap:25px;
    margin-bottom:35px;
}

.tarjeta{
    background:white;
    width:230px;
    padding:25px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,0.06);

}


.tarjeta h3{
    margin:0 0 10px 0;
    font-size:16px;
    color:#777;
}


.tarjeta p{
    margin:0;
    font-size:28px;
    font-weight:bold;
    color:#ff5ca8;
}


.tabla-contenedor{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,0.06);
}

.tabla-contenedor h2{
    font-family:'Playfair Display', serif;
    margin-top:0;
}


table{
    width:100%;
    border-collapse:collapse;

}


th{
    text-align:left;
    padding:13px;
    background:#fff0f7;
    color:#444;
}

td{
    padding:13px;
    border-bottom:1px solid #eeeeee;

}


tr:hover{
    background:#fafafa;
}


.sin-ventas{
    text-align:center;
    padding:30px;
    color:#888;
}


@media(max-width:900px){
    .contenido{
        margin-left:0;
        padding:20px;
    }

    .tarjetas{
        flex-wrap:wrap;

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


<div class="contenido">
    <div class="titulo">
        Ventas totales del día
    </div>
    <div class="fecha">

        <?php echo date("d/m/Y"); ?>

    </div>

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

    <div class="tabla-contenedor">
        <h2> Ventas registradas hoy</h2> <?php if($resultado && $resultado->num_rows > 0){ ?>
        
    <table>
            <tr>
                <th>ID Venta</th>
                <th>Pedido</th>
                <th>Cliente</th>
                <th>Método de pago</th>
                <th>Estado</th>
                <th>Total</th>

            </tr>


    <?php while($venta = $resultado->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $venta['id']; ?></td>
                <td><?php echo $venta['pedidos_id']; ?></td>
                <td><?php echo htmlspecialchars($venta['nombre']); ?></td>
                <td><?php echo htmlspecialchars($venta['metodo']); ?></td>
                <td><?php echo htmlspecialchars($venta['estado']); ?></td>
                <td>Bs <?php echo number_format($venta['costo'], 2); ?></td>
            </tr>
    <?php } ?>


        </table>

        <?php } else { ?>
            <div class="sin-ventas">manaaaa </div>


        <?php } ?>


    </div>


</div>


</body>

</html>