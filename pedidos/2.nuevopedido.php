<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nombre = $_POST["nombre"];
$fecha = $_POST["fecha"];
$estado = $_POST["estado"];
$vendedor = $_POST["vendedor"];

$sql = "INSERT INTO pedidos (Nombre, Fecha, Estado, vendedor) VALUES ('$nombre', '$fecha', '$estado', '$vendedor')";

if($conn->query($sql)){
    header("location:                ".$conn->insert_id);
}else{
    echo "Error: " . $conn->error;
}

$conn->close();

?>