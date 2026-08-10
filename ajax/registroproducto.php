<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
$codigo = $_POST["codigo"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$precio = $_POST["precio"];
$stock=$_POST["stock"];
$imagen=$_POST["imagen"];
$estado=$_POST["estado"];

$sql = "INSERT INTO producto
(codigo,nombre,descripcion,precio,stock,imagen,estado)
VALUES
('$codigo','$nombre','$descripcion','$precio','$stock','$imagen','$estado')";

if($conn->query($sql)){
    echo "Producto registrado correctamente";
}else{
    echo "Error: ".$conn->error;
}



?>