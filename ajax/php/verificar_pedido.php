<?php

// Inicia o recupera la sesión para poder consultar el pedido guardado
// para el usuario que realiza esta solicitud.
session_start();

// Indica al navegador y a quien consuma este endpoint que la respuesta es JSON.
header("Content-Type: application/json");


// Comprueba si existe un pedido activo en los datos de la sesión.
if(isset($_SESSION["pedido"])){


// Si hay un pedido, informa que está activo y devuelve sus datos.
echo json_encode([

"pedidoActivo"=>true,
"pedido"=>$_SESSION["pedido"]

]);


}else{


// Si no hay pedido en la sesión, informa que no existe uno activo.
echo json_encode([

"pedidoActivo"=>false

]);


}

?>