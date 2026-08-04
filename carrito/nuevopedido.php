<?php
session_start();
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

$sql = "INSERT INTO pedidos (nombre, fecha, estado, vendedor) VALUES ('$nombre', '$fecha', '$estado', '$vendedor')";

if($conn->query($sql)){
    $idpedido = $conn->insert_id;
    $_SESSION['id_pedido'] = $idpedido;
    header("Location: ../carrito/micarrito.php?idPedido=" . $idpedido);
    exit();
}else{
    echo "Error: " . $conn->error;
}

$conn->close();

?>