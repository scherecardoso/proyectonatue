
<?php

include("conexion.php");

$sql = "SELECT * FROM productos WHERE estado='Activo'";

$resultado = $conn->query($sql);

$productos = [];

while($fila = $resultado->fetch_assoc()){
    $productos[] = $fila;
}

header("Content-Type: application/json");
echo json_encode($productos);

?>