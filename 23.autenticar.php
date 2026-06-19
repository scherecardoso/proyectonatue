
<?php
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$CI = $_POST['CI'];
$direccion = $_POST['direccion'];

$sql = "SELECT * FROM usuario
        WHERE CI='$CI'
        AND direccion='$direccion'";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    session_start();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['direccion'] = $fila['direccion'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['nombre'] = $fila['nombre'];

    if ($_SESSION['rol'] == "vendedor") {

        header("Location: 07.vendedor.php");
        exit();

    } elseif ($_SESSION['rol'] == "administrador") {

        header("Location: 06.admin.php");
        exit();

    } elseif ($_SESSION['rol'] == "USUARIO") {

        header("Location: 08.usuario.php");
        exit();

    } else {

        echo "Rol no reconocido.";
    }

} else {

    echo "Usuario o datos incorrectos";
}

$conn->close();
?>

