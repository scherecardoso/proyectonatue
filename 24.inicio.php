<?php
session_start();

$CI = $_SESSION['CI'];

$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida");
}

$sql = "SELECT * FROM usuario WHERE CI='$CI'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $_SESSION['datos'] =
        $fila['CI']." ".
        $fila['nombre']." ".
        $fila['direccion']." ".
        $fila['celular']." ".
        $fila['rol']." ".
        $fila['estado'];
}
?>