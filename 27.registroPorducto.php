<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if($conn->connect_error){
    die("conexion fallida: "   . $conn->connect_error);
}
$id= $_POST['id'];
$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado']
$nombreVendedor = $_POST['nombreVendedor']
$sql = "INSERT INTO      (id, nombre, fecha, estado, nombreVendedor) VALUES ('$id','$nombre', '$fecha', '$estado', '$nombreVendedor')";

if ($conn->query($sql)===TRUE){
    header("");

    header("");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>
