<?php
session_start();

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexion");
}

$CI = $_GET['CI'];

$sql = "SELECT * FROM usuario WHERE CI='$CI'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];

    if ($fila['rol'] == "administrador") {
        header("Location: 06.admin.php");
        exit();
    }

    if ($fila['rol'] == "vendedor") {
        header("Location: 07.vendedor.php");
        exit();
    }

    if ($fila['rol'] == "usuario") {
        header("Location: 24.inicio.php");
        exit();
    }

    header("Location: 24.inicio.php");
    exit();

} else {
    echo "NO EXISTE EL USUARIO";
}
?>