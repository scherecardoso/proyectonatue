<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$productos_codigo = $_POST["productos_codigo"];
$pedidos_id = $_POST["pedidos_id"];
$cantidad = $_POST["cantidad"];
$precio = $_POST["precio"];
$costototal=$precio*$cantidad;

$sql = "INSERT INTO carrito
(Producto_codigo,Pedido_id,cantidad,costototal)
VALUES
('$productos_codigo','$pedidos_id','$cantidad','$costototal')";

if($conn->query($sql)){
    echo "Producto agregado al carrito";
    header("location: 29.micarrito.php?pedidos_id=".$pedidos_id);
}else{
    echo "El producto ya se agregó";
    echo "<a href='29.micarrito.php?pedidos_id=$pedidos_id'>
        <button>Volver a Pedidos</button>
      </a>";
}



?>