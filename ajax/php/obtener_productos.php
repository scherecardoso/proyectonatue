
<?php

include("conexion.php");

$sql = "SELECT * FROM producto WHERE estado='Activo'";

$resultado = $conn->query($sql);

$productos = [];

while($fila = $resultado->fetch_assoc()){
    $productos[] = $fila;
}

header("Content-Type: application/json");
echo json_encode($productos);

?>