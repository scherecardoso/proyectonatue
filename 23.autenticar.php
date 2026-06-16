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

$CI = $_GET['CI'];
$direccion = $_GET['direccion'];
$rol = $_GET['rol'];

$sql = "SELECT * FROM usuario
        WHERE CI='$CI'
        AND direccion='$direccion'
        AND rol='$rol'";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['direccion'] = $fila['direccion'];
    $_SESSION['rol'] = $fila['rol'];

    if ($fila['rol'] == "administrador") {

        header("Location: 06.admin.php");
        exit();

    } elseif ($fila['rol'] == "vendedor") {

        header("Location: 07.vendedor.php");
        exit();

    } elseif ($fila['rol'] == "usuario") {

        header("Location: 24.inicio.php");
        exit();

    } else {

        echo "Rol no reconocido";
    }

} else {

    echo "CI, dirección o rol incorrectos";

}

$conn->close();
?>