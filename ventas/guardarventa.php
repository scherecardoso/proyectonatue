<?php
session_start();

$conexion = new mysqli("localhost","root","","shena");

if($conexion->connect_error){
    die("Error de conexión");
}
// ==========================================
// RECIBIR DATOS DEL FORMULARIO
// ==========================================

$costo = $_POST['costo'];
$metodo = $_POST['metodo'];
$estado = $_POST['estado'];
// ==========================================
// INSERTAR VENTA
// ==========================================

$sql = "INSERT INTO ventas(costo, metodo, estado)VALUES('$costo','$metodo','$estado')";

if($conexion->query($sql)){
    header("Location: readventas.php");
    exit();
}else{
    echo "Error: " . $conexion->error;
}
?>