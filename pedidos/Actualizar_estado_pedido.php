<?php
session_start();

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador')) 
{
    echo "Acceso denegado";
    exit();
}

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$pedido_id = $_POST['pedido_id'];
$nuevo_estado = $_POST['estado'];

$sql = "UPDATE pedidos SET estado='$nuevo_estado' WHERE id='$pedido_id'";

if ($conn->query($sql) === TRUE) {
    header("Location: ../vendedor/07.vendedor.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?> //Esto es para que se actualizen los datos