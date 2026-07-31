<?php
session_start();
?>
<?php 
$direccion = "localhost";
$usuario = "root";
$contrasenia = "";
$nombreBD = "shena";
$conexion = new mysqli($direccion, $usuario, $contrasenia, $nombreBD);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_POST['id'];
$costo = $_POST['costo'];
$metodo = $_POST['metodo'];
$estado = $_POST['estado'];

$sql = "UPDATE ventas SET costo='$costo',metodo='$metodo',estado='$estado' WHERE id='$id'";

if ($conexion->query($sql)) {

    header("Location: readventas.php");
    exit();

} else {
    echo "Error al actualizar: " . $conexion->error;
}

?>