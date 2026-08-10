<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$costo = $_POST['total'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$id_pedidos = $_POST['id_pedidos'];

$sql = "INSERT INTO ventas (costo, fecha, estado, pedidos_id) 
        VALUES ('$costo', '$fecha', '$estado', '$id_pedidos')";

if($conn->query($sql)){

    $idVentas = $conn->insert_id;

    header("Location: readventas.php");
    exit();

}else{

    echo $conn->error;

}

?>