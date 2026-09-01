<?php

session_start();

if (!isset($_SESSION['CI'])) {
    header("Location: ../pagina/23.autenticar.php");
    exit();
}

$CI = $_SESSION['CI'];
$codigo = $_POST['codigo'];

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "DELETE FROM favoritos
        WHERE CI='$CI'
        AND codigo='$codigo'";

$conn->query($sql);

header("Location: favoritos.php");
exit();

?>