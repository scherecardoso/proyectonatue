<?php

session_start();

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$codigo = $_POST["codigo"]; 
$idpedido = $_POST["Pedido_id"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];

$total=$precio*$cantidad;

$sql = "INSERT INTO carrito
    (productos_codigo, pedidos_id, cantidad, costototal)
    VALUES
    ('$codigo', '$idpedido', '$cantidad', '$total')
    ";

if ($conn->query($sql)) {
    header("Location: micarrito.php?Pedido_id=" . $idpedido);
    exit();

} else {

    echo "Error: " . $conn->error;
}

$conn->close();

?>