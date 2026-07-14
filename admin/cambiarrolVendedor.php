<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}
$CI = $_GET['CI'];

$sql = "UPDATE usuario SET rol='Vendedor' WHERE CI=$CI";

if ($conn->query($sql) === TRUE) {
    echo "Rol actualizado exitosamente";
    header("Location: ../usuario/12.readusuarios.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>