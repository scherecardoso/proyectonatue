<?php

$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "Conexion fallida";
}

$CI = $_GET['CI'];

$sql = "DELETE FROM usuario WHERE CI='$CI'";

if ($conn->query($sql) === TRUE) {
    header("Location: 13.readusuario.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>