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
$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$vendedor = $_POST['vendedor'];

$sql = "UPDATE pedidos SET nombre='$nombre',fecha='$fecha',estado='$estado',vendedor='$vendedor'WHERE id='$id'";

if ($conexion->query($sql)) {

    header("Location: 4.readpedidos.php");
    exit();

} else {
    echo "Error al actualizar: " . $conexion->error;
}

?>