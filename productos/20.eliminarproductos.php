```php
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

$codigo = $_GET['codigo'];

$sql = "DELETE FROM productos WHERE codigo=$codigo";

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
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
```
