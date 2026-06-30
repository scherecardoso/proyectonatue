<?php
session_start();
$conn = new mysqli("localhost", "root", "", "shena");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$idpedido = $_POST["idPedido"];
$codigo = $_POST["codigo"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];



$total = $cantidad * $precio;
$sql = "UPDATE carrito SET cantidad = '$cantidad',costototal = '$total'WHERE pedidos_id = '$idpedido'AND productos_codigo = '$codigo'";
if ($conn->query($sql)) {
    header("Location: micarrito.php?idPedido=" . $idpedido);
    exit();
} else {
    echo "Error al actualizar: " . $conn->error;
}

$conn->close();

?>