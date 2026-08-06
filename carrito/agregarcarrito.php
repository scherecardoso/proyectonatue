<?php
session_start();



$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


if (!isset($_SESSION["pedidos_id"])) {

  
    $_SESSION["producto_temp"] = $_POST;

    header("Location: ../pedidos/1.formpedido.php");
    exit();
}

$pedidos_id = $_SESSION["pedidos_id"];


$productos_codigo = $_POST["codigo"];
$cantidad = (int) $_POST["cantidad"];
$precio = (float) $_POST["precio"];


$total = $cantidad * $precio;


$sql = "INSERT INTO carrito (pedidos_id, productos_codigo, cantidad, costototal)
        VALUES ('$pedidos_id', '$productos_codigo', '$cantidad', '$total')
        ON DUPLICATE KEY UPDATE
        cantidad = cantidad + VALUES(cantidad),
        costototal = costototal + VALUES(costototal)";

$resultado = $conexion->query($sql);


if (!$resultado) {
    die("Error al agregar al carrito: " . $conexion->error);
}


header("Location: micarrito.php");
exit();
?>