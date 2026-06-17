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

$sql = "SELECT precio FROM productos WHERE codigo='$codigo'";

$resultado = $conn->query($sql);
$fila = $resultado->fetch_assoc();
$precio = $fila['precio'];
$costototal = $cantidad * $precio;
$sql = "INSERT INTO carrito (codigo, id, cantidad, costototal) VALUES('$codigo', '$id', '$cantidad', '$costototal')";
if($conn->query($sql)==TRUE){
    header("Location:30.readcarrito.php");
}else{
    echo "Error";
}
$conn->close();
?>