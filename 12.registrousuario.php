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
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$sql = "INSERT INTO usuario (CI, nombre, direccion, celular, rol, estado) VALUES ('$CI','$nombre', '$direccion', '$celular', '$rol','$estado')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo usuario creado exitosamente";
    header("Location: 08.usuario.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>