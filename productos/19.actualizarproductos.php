
<?php
session_start();

if ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador') {
    header("Location: ../pagina/login.php");
    exit();
}

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$codigo_original = $_POST['codigo_original'];
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

$sql = "UPDATE productos SET
codigo='$codigo',
nombre='$nombre',
descripcion='$descripcion',
precio='$precio',
costo='$costo',
stock='$stock'
WHERE codigo='$codigo_original'";

if ($conn->query($sql) === TRUE) {

    if ($_SESSION['rol'] == 'vendedor') {
        header("Location: ../productos/22.readproductos.php");
        exit();
    }

    if ($_SESSION['rol'] == 'administrador') {
        header("Location: ../admin/gestionproductos.php");
        exit();
    }

} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
