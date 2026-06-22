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

$CI = isset($_POST["CI"]) ? intval($_POST["CI"]) : 0;
$direccion = isset($_POST["direccion"]) ? trim($_POST["direccion"]) : "";

if ($CI === 0 || $direccion === "") {
    echo "Faltan credenciales.";
    exit();
}

$stmt = $conn->prepare("SELECT CI, nombre, rol, estado FROM usuario WHERE CI = ? AND direccion = ?");
if (!$stmt) {
    echo "Error en la preparación: " . $conn->error;
    exit();
}
$stmt->bind_param("is", $CI, $direccion);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
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