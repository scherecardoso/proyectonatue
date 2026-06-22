<?php
session_start();
?>
<?php

$conexion = new mysqli("localhost","root","","shena");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$codigo = $_POST['codigo'];
$pedidos_id = $_POST['pedidos_id'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];
$total = $cantidad * $precio;

$sql = "INSERT INTO carrito (productos_codigo, pedidos_id, cantidad, costototal)VALUES ('$codigo','$pedidos_id','$cantidad','$total')";
if ($conexion->query($sql)) {
    header("Location: ../pedidos/3.guardarpedido.php?id=".$pedidos_id);
    exit();
} else {
    echo "Error: " . $conexion->error;
}
?>