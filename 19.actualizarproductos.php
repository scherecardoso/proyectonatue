<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

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

$sql = "UPDATE productos SET codigo='$codigo', nombre='$nombre', descripcion='$descripcion', precio='$precio', costo='$costo', stock='$stock' WHERE codigo=$codigo";

if ($conn->query($sql) === TRUE) {
    echo "Producto actualizado exitosamente";
    header("Location: 22.readproductos.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>