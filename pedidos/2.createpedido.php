<?php
session_start();

$conexion = new mysqli("localhost","root","","shena");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$vendedor = $_POST['nombrevendedor'];

$sql = "INSERT INTO pedidos (nombre, fecha, estado, vendedor)VALUES ('$nombre','$fecha','$estado','$vendedor')";
header("Location: 4.readpedidos.php");
exit();
if($conexion->query($sql)){
    $idPedido = $conexion->insert_id;
    header("Location: ../pedidos/3.guardarpedido.php?id=".$idPedido);
    exit();

}else{
    echo $conexion->error;
}
?>