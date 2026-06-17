<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";
    
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$codigo = $_GET['codigo'];

$sql = "DELETE  FROM carrito WHERE codigo=$codigo";

if ($conn->query($sql) === TRUE) {
    echo "Producto eliminado exitosamente";
    header("Location: 30.readcarrito.php");
} else { 
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>