<?php
session_start();
if(!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador"){ die("Acceso denegado"); }

$conexion = new mysqli("localhost","root","","shena");
if($conexion->connect_error){ die("Error de conexión"); }

$id = $_GET['id'];
$venta = $conexion->query("SELECT pedidos_id FROM ventas WHERE id='$id'")->fetch_assoc();

if($venta){
    $pedido = $venta['pedidos_id'];
    $productos = $conexion->query("SELECT productos_codigo,cantidad FROM carrito WHERE pedidos_id='$pedido'");

    while($producto=$productos->fetch_assoc()){
        $codigo=$producto['productos_codigo'];
        $cantidad=(int)$producto['cantidad'];
        $conexion->query("UPDATE productos SET stock=stock+$cantidad WHERE codigo='$codigo'");
    }

    $conexion->query("DELETE FROM ventas WHERE id='$id'");
    $conexion->query("UPDATE pedidos SET estado='Pendiente',vendedor='Sin asignar' WHERE id='$pedido'");
}

header("Location: readventas.php");
exit();
?>