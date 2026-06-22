<?php
session_start();

$conexion = new mysqli("localhost","root","","shena");

if($conexion->connect_error){
    die("Error de conexión");
}

$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$vendedor = $_POST['nombrevendedor'];

$sql = "INSERT INTO pedidos(nombre, fecha, estado, vendedor)VALUES('$nombre','$fecha','$estado','$vendedor')";

if($conexion->query($sql)){
    header("Location: 4.readpedidos.php");
    exit();
}else{
    echo "Error: " . $conexion->error;
}
?>