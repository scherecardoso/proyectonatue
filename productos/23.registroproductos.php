<?php
session_start();

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador')) {
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

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

$carpetaImagenes = "../img/";

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {

    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));

    $extensionesPermitidas = ["jpg", "jpeg", "png", "gif"];

    if (!in_array($extension, $extensionesPermitidas)) {
        die("Solo se permiten imágenes JPG, JPEG, PNG o GIF.");
    }

    $nombreImagen = "P-" . $codigo . "." . $extension;
    $ruta = $carpetaImagenes . $nombreImagen;

    if (file_exists($ruta)) {
        die("Ya existe una imagen para este producto.");
    }

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta)) {
        die("No se pudo subir la imagen.");
    }

} else {
    $nombreImagen = "angie.png";
}

$sql = "INSERT INTO productos 
(codigo, nombre, descripcion, precio, costo, stock, imagen) 
VALUES 
('$codigo', '$nombre', '$descripcion', '$precio', '$costo', '$stock', '$nombreImagen')";

if ($conn->query($sql) === TRUE) {

    if ($_SESSION['rol'] === 'administrador') {
        header("Location: ../admin/gestionproductos.php");
        exit();
    }

    if ($_SESSION['rol'] === 'vendedor') {
        header("Location: ../productos/22.readproductos.php");
        exit();
    }

} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>