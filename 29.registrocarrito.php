<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$productos_codigo = $_POST["productos_codigo"];
$pedidos_id = $_POST["pedidos_id"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];
$costototal=$precio*$cantidad;

$sql = "INSERT INTO carrito
(productos_codigo, pedidos_id, cantidad, costototal)
VALUES
('$productos_codigo','$pedidos_id','$cantidad','$costototal')";

if($conn->query($sql)){
    echo "Producto agregado al carrito";
    header("location: 28.micarrito.php?pedidos_id=".$pedidos_id);
}else{
    echo "El producto ya se agregó";
    echo "<a href='28.micarrito.php?pedidos_id=$pedidos_id'>
        <button>Volver a Pedidos</button>
      </a>";
}
?>