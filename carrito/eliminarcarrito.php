<?php
session_start();
$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$idpedido = $_GET["idPedido"];
$codigo = $_GET["codigo"];


$sql = "DELETE FROM carrito WHERE pedidos_id = '$idpedido'AND productos_codigo = '$codigo'";

if ($conn->query($sql)) {
    header("Location: micarrito.php?idPedido=" . $idpedido);
    exit();

} else {

    echo "Error al eliminar: " . $conn->error;
}
$conn->close();
?>