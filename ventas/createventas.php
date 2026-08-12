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
$datosProductos =$resultadoProductos->fetch_assoc();
$stock= $datosProductos['stock'];
$nombreProductos =$datosProductos ['nombre'];
// comprobamos si hay stock sufiuiente 
if ($stock<$cantidad ){
     $hayStock=false;
     $productoSinStock=$nombreProductos;
     break;
}
}
//si hay stock registramos la venta 
if ($hayStock==true){
     $sql="INSERT INTO ventas (estado,metodo,costototal,pedidos_id) VALUES ('$estado','$metodo','$costototal','$pedidos_id')";
     if ($conn->query (sql)==TRUE){
          //aqui acualizamos el stock de los productos una ves que la venta este registrada 
          $sqlCarrito="SELECT productos_id, cantidad FROM carrito WHERE pedidos_id='$pedidos_id'";

          $resultadoCarrito=$conn->query($sqlCarrito);
          while($productos =$resultadoCarrito->fetch_assoc()){

          $productos_id=$productos['productos_id'];
           $cantidad=$productos['cantidad'];
           //descontams la cantidad de stock 

           $sqlsotck ="UPDATE productos SET stock =stock-'$cantidad ' WHERE id ='$pedidos_id'";
           $conn->query($sqlsotck);
          }
          header("locatin:readventas.php?") ;
              }else{
               echo "error:",sql,"<br<",$conn->error;
              }
}else{
     //no hay sufiente stock 
     echo "no hya suficiente stock del producto :". $productoSinStock;
}
 $con->close();
 ?>