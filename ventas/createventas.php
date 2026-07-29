<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$costo= $_POST['costo'];
$metodo = $_POST['metodo'];
$estado = $_POST['estado'];
$sql = "INSERT INTO ventas (costo, metodo, estado) VALUES ('$costo', '$metodo', '$estado')";
header("Location: readventas.php");
exit();
if($conexion->query($sql)){
    $idVentas = $conexion->insert_id;
    header("Location: ../ventas/guardarventa.php?id=".$idVentas);
    exit();

}else{
    echo $conexion->error;
}
?>