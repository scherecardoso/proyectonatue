<?php

session_start();

if (!isset($_SESSION['CI'])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

$CI = $_SESSION['CI'];
$codigo = $_POST['codigo'];

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

/* Verificar si el producto ya es favorito */
$sql = "SELECT * FROM favoritos
        WHERE CI='$CI'
        AND codigo='$codigo'";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

/* Si todavía no es favorito, guardarlo */
if ($resultado->num_rows == 0) {

    $sql = "INSERT INTO favoritos (CI, codigo)
            VALUES ('$CI', '$codigo')";

    if (!$conn->query($sql)) {
        die("Error al guardar favorito: " . $conn->error);
    }
}

$conn->close();

header("Location: ../pagina/03.productos.php");
exit();

?>
