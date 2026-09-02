
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

/* Verificar que el usuario exista */
$sql = "SELECT * FROM usuario
        WHERE CI='$CI'";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

if ($resultado->num_rows == 0) {
    die("El usuario no existe en la base de datos.");
}

/* Verificar que el producto exista */
$sql = "SELECT * FROM productos
        WHERE codigo='$codigo'";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

if ($resultado->num_rows == 0) {
    die("El producto no existe en la base de datos.");
}

/* Verificar si ya es favorito */
$sql = "SELECT * FROM favoritos
        WHERE ci='$CI'
        AND codigo='$codigo'";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

/* Si todavía no es favorito, guardarlo */
if ($resultado->num_rows == 0) {

    $sql = "INSERT INTO favoritos (ci, codigo)
            VALUES ('$CI', '$codigo')";

    if (!$conn->query($sql)) {
        die("Error al guardar favorito: " . $conn->error);
    }
}

$conn->close();

header("Location: ../pagina/03.productos.php");
exit();

?>
