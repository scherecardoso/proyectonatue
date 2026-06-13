<?php
$direccion ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "coneccion fallida"
}

$CI = $_POST['CI'];

$sql = "DELETE FROM usuario WHERE CI=$CI";

if ($conn->query($sql) === TRUE) {
    echo "Usuario eliminado exitosamente";
    header("Location: 13.readusuarios.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>