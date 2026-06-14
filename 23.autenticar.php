<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}

$nombre = $_POST['nombre'];

$sql = "SELECT * FROM usuario WHERE nombre='$nombre'";

$resultado = $conn->query($sql);

if($resultado->num_rows > 0){

    $fila = $resultado->fetch_assoc();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];

    header("Location: 08.usuario.php");
    exit();

}else{

    echo "Usuario no encontrado";

}

$conn->close();
?>