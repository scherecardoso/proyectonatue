<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="db_natue";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$CI = $_GET['CI'];

$sql = "DELETE FROM usuario WHERE CI=$CI";

if ($conn->query($sql) === TRUE) {
    echo "Usuario eliminado exitosamente";
    header("Location: readUsuario.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>