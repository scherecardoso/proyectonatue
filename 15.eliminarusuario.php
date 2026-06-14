<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$CI = $_GET['CI'];

$sql = "DELETE FROM usuario WHERE CI=$CI";

if ($conn->query($sql) === TRUE) {
    echo "Usuario eliminado exitosamente";
    header("Location: 12.readusuarios.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>