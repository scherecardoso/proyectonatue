<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";
    
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    echo "Acceso denegado";
    exit();
}

$codigo = $_GET['codigo'];

$sql = "DELETE  FROM productos WHERE codigo=$codigo";

if ($conn->query($sql) === TRUE) {
    echo "Producto eliminado exitosamente";
    header("Location: ../productos/22.readproductos.php");
} else { 
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>