<?php
session_start();
require("conexion.php");
header("Content-Type: application/json");

if(!isset($_SESSION["pedido"])){
    echo json_encode(["ok"=>false,"mensaje"=>"No existe pedido"]);
    exit;
}

$idPedido=$_SESSION["pedido"];
$sql="SELECT c.cantidad,p.nombre,p.stock FROM carrito c INNER JOIN productos p ON c.productos_codigo=p.codigo WHERE c.pedidos_id='$idPedido'";
$resultado=$conn->query($sql);

if(!$resultado || $resultado->num_rows==0){
    echo json_encode(["ok"=>false,"mensaje"=>"El carrito está vacío"]);
    exit;
}

while($fila=$resultado->fetch_assoc()){
    if((int)$fila["cantidad"] > (int)$fila["stock"]){
        echo json_encode(["ok"=>false,"mensaje"=>"No hay suficiente stock de ".$fila["nombre"]]);
        exit;
    }
}

$sql="UPDATE pedidos SET estado='Pendiente' WHERE id='$idPedido'";
if($conn->query($sql)){
    echo json_encode(["ok"=>true,"pedido"=>$idPedido]);
}else{
    echo json_encode(["ok"=>false,"mensaje"=>$conn->error]);
}
?>