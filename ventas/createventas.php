<?php
$servidor "localhost";
Snombre "root";
Scontraseña
$BDnombre "shena";
$conn new mysqli($servidor, $nombre, $contraseña, $BDnombre);
if($conn->connect_error) {
die ("conexion fallida", $conn->connect_error);
}
$metodo $_POST['metodo'];
$pedidos_id = $_POST['pedidos_id'];

$estado "Pendiente";

$sqlTotal "SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id = '$pedidos_id";
$resultado Sconn->query($sqlTotal);
$fila Sresultado->fetch_assoc();
$costototal $fila['total'];

//Aqui debemos buscar los productos del pedido paar ver si se puede validar la venta
$sqlCarrito ="SELECT productos_id, cantidad FROM carrito WHERE pedidos_id= '$pedidos_id'";
$resultadoCarrito $conn->query($sqlCarrito);

//Luego Validamos el stock antes de registrar la venta
$hayStock= true;
$productoSinStock = "";

while ($productos= $resultadoCarrito->fetch_assoc()) {
     $productos_id= $productos['productos_id'];
$cantidad =$productos['cantidad'];

//Buscamos el stock actual

$sqlProductos= "SELECT nombre, stock FROM productos WHERE id ='$pedidos_id'";

$resultadoProductos =Sconn->query($sqlProductos);
$datosProductos $resultadoProductos->fetch_assoc();
$stock $datosProductos['stock'];
$nombreProductoS =$datosProductos ['nombre'];
// 
}
 