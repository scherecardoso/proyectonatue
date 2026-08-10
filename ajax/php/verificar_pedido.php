<?php
//Inicia o recupera la sesión del usuario.
session_start();
//Le dice al navegador:La respuesta que voy a enviar no es HTML, es un JSON
header("Content-Type: application/json");

//En tu proyecto del carrito esto es importante porque ahí guardas el número del pedido:
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