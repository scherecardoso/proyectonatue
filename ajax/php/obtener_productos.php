
<?php

// Incluye el archivo que configura y establece la conexión con la base de datos.
include("conexion.php");

// Consulta los productos cuyo estado es "Activo" para devolverlos al cliente.
$sql = "SELECT * FROM productos WHERE estado='Activo'";

// Ejecuta la consulta usando la conexión creada en conexion.php.
$resultado = $conn->query($sql);

// Inicializa el arreglo que contendrá los productos encontrados.
$productos = [];

// Recorre cada fila del resultado y la agrega al arreglo de productos.
while($fila = $resultado->fetch_assoc()){
    $productos[] = $fila;
}

// Indica que la respuesta del servidor tendrá formato JSON.
header("Content-Type: application/json");

// Convierte el arreglo de productos a JSON y lo envía como respuesta.
echo json_encode($productos);

?>