<?php
session_start();
?>
<?php
$conexion = new mysqli("localhost","root","","shena");
if ($conexion->connect_error) {
    die("Error de conexión");
}
$id = $_POST['pedido_id'];
$estado = $_POST['estado'];
$sql = "UPDATE pedidos SET estado='$estado' WHERE id='$id'";
if ($conexion->query($sql)) {

    header("Location: ../vendedor/07.vendedor.php");
    exit();

} else {
    echo "Error: " . $conexion->error;
}
?>