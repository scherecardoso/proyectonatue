<?php

if (!isset($_SESSION['CI'])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

$CI = $_SESSION['CI'];

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

$sql = "SELECT estado FROM usuario WHERE CI = $CI";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    if ($fila['estado'] == "bloqueado") {

        $_SESSION['estado'] = "bloqueado";

        header("Location: ../admin/verbloqueo.php");
        exit();
    }
}

$conn->close();

?>