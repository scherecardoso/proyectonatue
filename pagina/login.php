<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$CI = $_POST["CI"] ;
$direccion = $_POST['direccion'];

$sql = "SELECT CI, nombre, rol, estado
        FROM usuario
        WHERE CI='$CI'
        AND direccion='$direccion'";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $result->fetch_assoc();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];

    if ($_SESSION['rol'] == "vendedor") {
        header("Location: ../vendedor/07.vendedor.php");
        exit();
    } elseif ($_SESSION['rol'] == "administrador") {
        header("Location: ../admin/06.admin.php");
        exit();
    } elseif ($_SESSION['rol'] == "usuario") {
        header("Location: ../usuario/08.usuario.php");
        exit();
    } else {
        header("Location: ../pagina/02.inicio.php");
        exit();
    }

} else {
    echo "Usuario o datos incorrectos";
}

$stmt->close();
$conn->close();
?>