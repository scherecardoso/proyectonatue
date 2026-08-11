<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$costo = $_POST['pedidos_id'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$id_pedidos = $_POST['total'];

$sql = "INSERT INTO ventas (pedidos_id, fecha, estado, total) VALUES ('$pedidos_id', '$fecha', '$estado', '$total')";

if($conn->query($sql))
  {
      
     //buscar nevamente los productos para desconectar stock
$sql="SELECT * FROM micarrito WHERE pedidos_id='$pedidos_id'";
$resultao=$conn->query($sql);
while($fila=$resultao->fetch_assoc())
    {
          $codigo=$fila['productos_codigo'];
         $cantidad=$fila['cantidad'];
         //obtener stock actual 

         $sql="SELECT * FROM producos WHERE codigo='$codigo'";
         $r2=$conn->query($sql2);
         $productos=$r2->fetch_assoc();
         $stock=$productos['stock'];
         $nuevosSTOCK=$stock-$cantidad;
         //actualizar stock
         $sql3="UPDATE producos SET stock=´$nuevoStock´ WHERE codigo=´$codigo´";
         $cconn->query($sql3);

    }
        echo "<h2>venta registrada correctmente</h2>";
  }   
   else
    {
        echo"error".$conn->error;
    }
    
?>