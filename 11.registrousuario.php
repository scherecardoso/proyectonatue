<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "No se conectó a la base de datos.";
}

$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$sql = "INSERT INTO usuario (CI, nombre, direccion, celular, rol, estado)
VALUES ('$CI','$nombre','$direccion','$celular','$rol','$estado')";

if ($conn->query($sql) === TRUE) {

    header("Location: 13.readusuario.php");

} else {

    echo "Error: " . $conn->error;

}

$conn->close();

?>