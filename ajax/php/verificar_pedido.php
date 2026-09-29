<?php

session_start();
header("Content-Type: application/json");


if(isset($_SESSION["pedido"])){


echo json_encode([

"pedidoActivo"=>true,
"pedido"=>$_SESSION["pedido"]

]);


}else{


echo json_encode([

"pedidoActivo"=>false

]);


}

?>