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

$CI = $_POST["CI"] ?? "";
$direccion = $_POST["direccion"] ?? "";

if ($CI == "" || $direccion == "") {
    echo "Usuario o datos incorrectos";
    $conn->close();
    exit();
}

$sql = "SELECT CI, nombre, rol, estado
        FROM usuario
        WHERE CI = ?
        AND direccion = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

$stmt->bind_param("ss", $CI, $direccion);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['direccion'] = $fila['direccion'];
    $_SESSION['celular'] = $fila['celular'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];
    $_SESSION['fecha'] = $fila['fecha'];

    if ($fila['rol'] == "vendedor") {

        header("Location: ../vendedor/07.vendedor.php");
        exit();

    } elseif ($fila['rol'] == "administrador") {

        header("Location: ../admin/06.admin.php");
        exit();

    } elseif ($fila['rol'] == "usuario") {

        header("Location: ../usuario/08.usuario.php");
        exit();

    } else {

        echo "Rol no reconocido";
    }

} else {

    echo "Usuario o datos incorrectos";
}

$stmt->close();
$conn->close();
?>
