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

$sql = "UPDATE usuario SET nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol', estado='$estado' WHERE CI=$CI";

if ($conn->query($sql) === TRUE) {
    echo "Usuario actualizado exitosamente";
    header("Location: 11.readusuario.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>