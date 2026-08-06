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


$sql = "INSERT INTO pedidos (fecha) VALUES ('$fecha')";

if($conn->query($sql)){
    $idpedido = $conn->insert_id;
    $_SESSION['pedido'] = $idpedido;
    header("Location: ../carrito/micarrito.php");
    exit();
}else{
    echo "Error: " . $conn->error;
}

$conn->close();

?>