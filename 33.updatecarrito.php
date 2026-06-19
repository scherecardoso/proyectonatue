<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$productos_codigo = $_POST['productos_codigo'];
$pedidos_id = $_POST['pedidos_id'];
$cantidad = $_POST['cantidad'];
$costototal = $_POST['costototal'];

$sql = "UPDATE carrito SET productos_codigo='$productos_codigo', pedidos_id='$pedidos_id', cantidad='$cantidad', costototal='$costototal' WHERE productos_codigo=$productos_codigo";

if ($conn->query($sql) === TRUE) {
    echo "carrito actualizado exitosamente";
    header("Location: 30.readcarrito.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>