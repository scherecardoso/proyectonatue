<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$codigo = $_POST['codigo'];
$id = $_POST['id'];
$cantidad = $_POST['cantidad'];
$costototal = $_POST['costototal'];

$sql = "UPDATE carrito SET codigo='$codigo', id='$id', cantidad='$cantidad', costototal='$costototal' WHERE codigo=$codigo";

if ($conn->query($sql) === TRUE) {
    echo "carrito actualizado exitosamente";
    header("Location: 30.readcarrito.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>