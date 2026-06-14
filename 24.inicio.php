<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
session_start();
$CI=$_SESSION['CI'];
$sql = "SELECT * FROM usuario WHERE CI='$CI'";
$resultado = $conn->query($sql);
if ($resultado->num_rows>0){
    while($fila=$resultado->fetch_assoc()){
        $_SESSION ['CI']= $fila['CI']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado'];
}
}
?>