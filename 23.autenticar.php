<?php
session_start();

$conn = new mysqli("localhost", "root", "", "shena");

$CI = $_POST['CI'];

$sql = "SELECT * FROM usuario WHERE CI='$CI'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];

    echo "LOGIN OK<br>";
    echo "ROL: " . $fila['rol'];
    exit();

} else {
    echo "NO EXISTE";
}
?>