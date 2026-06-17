<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$codigo = $_POST['codigo'];
$id = $_POST['id'];
$cantidad = $_POST['cantidad'];
$precio = $_POST['precio'];
$costototal = $cantidad * $precio;

$sql = "INSERT INTO carrito (codigo, id, cantidad, costototal) VALUES('$codigo', '$id', '$cantidad', '$costototal')";

if($conn->query($sql)==TRUE){
    echo "Producto agregado al carrito";
    header("Location: 28.micarrito.php?id=$id".$id);
}else{
    echo "el producto ya se agrego al carrito";
    echo "<a href='28.micarrito.php?id=$id'>
    <button>Volver al carrito</button>
    </a>";
}
$conn->close();
?>