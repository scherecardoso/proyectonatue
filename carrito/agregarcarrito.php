<?php

session_start();

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$codigo = $_POST["codigo"]; 
$idpedido = $_POST["idpedido"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];
$total=$precio*$cantidad;

if ($cantidad <= 0) {
    die("La cantidad debe ser mayor a cero.");
}

if ($precio < 0) {
    die("Precio inválido.");
}


if ($_SESSION['nombre']  == "") {

    header("Location: ../usuario/09.register.php");
    exit();
}


$total = $cantidad * $precio;

$verificar="SELECT cantidad FROM carrito WHERE productos_codigo = $codigo AND pedidos_id = $idpedido";

$resultado = $conn->query($verificar);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $nuevaCantidad = $fila["cantidad"] + $cantidad;
    $nuevoTotal = $nuevaCantidad * $precio;

 
} else {

    $sql = "INSERT INTO carrito
    (productos_codigo, pedidos_id, cantidad, costototal)
    VALUES
    ('$codigo', '$idpedido', '$cantidad', '$total')
    ";
}

if ($conn->query($sql)) {
    echo "Producto agregado al carrito";
    header("Location: micarrito.php?idPedido=" . $idpedido);
    exit();

} else {

    echo "Error: " . $conn->error;
}

$conn->close();

?>