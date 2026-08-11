<?php

session_start();

require("conexion.php");

header("Content-Type: application/json");


if(!isset($_SESSION["pedido"])){

    echo json_encode([

        "ok"=>false,
        "mensaje"=>"No hay pedido activo"

    ]);

    exit;

}


$id=$_SESSION["pedido"];


$sql="

SELECT *
FROM pedido
WHERE id='$id'

";


$resultado=$conn->query($sql);


if($resultado and $resultado->num_rows>0){


    $pedido=$resultado->fetch_assoc();


    echo json_encode([

        "ok"=>true,
        "pedido"=>$pedido

    ]);


}else{


    echo json_encode([

        "ok"=>false,
        "mensaje"=>"Pedido no encontrado"

    ]);


}


$conn->close();

?>