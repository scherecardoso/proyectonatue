<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}


$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];



$sql = "INSERT INTO usuario (CI, nombre, direccion, celular) VALUES ('$CI','$nombre', '$direccion', '$celular')";


if ($conn->query($sql) === TRUE) {
    header("Location: ../usuario/09.register.php");



} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

?>