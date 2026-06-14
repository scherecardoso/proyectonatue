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
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];
$sql = "INSERT INTO productos (codigo, nombre, descripcion, precio, costo, stock) VALUES ('$codigo','$nombre', '$descripcion', '$precio',  '$costo','$stock')";
if ($conn->query($sql) === TRUE) {
    header("Location: 22.readproductos.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>