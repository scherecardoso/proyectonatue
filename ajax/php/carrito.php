<?php

session_start();

require("conexion.php");

header("Content-Type: application/json");


if(!isset($_SESSION["pedido"])){

    echo json_encode([

        "ok"=>false,
        "mensaje"=>"No hay un pedido activo"

    ]);

    exit;

}


if(!isset($_POST["accion"])){

    echo json_encode([

        "ok"=>false,
        "mensaje"=>"Falta la acción"

    ]);

    exit;

}


$idPedido=$_SESSION["pedido"];

$accion=$_POST["accion"];


if($accion=="agregar"){


    if(!isset($_POST["codigo"])){

        echo json_encode([

            "ok"=>false,
            "mensaje"=>"Falta el código del producto"

        ]);

        exit;

    }


    $codigo=$_POST["codigo"];


    if(isset($_POST["cantidad"])){

        $cantidad=(int)$_POST["cantidad"];

    }else{

        $cantidad=1;

    }


    $sqlProducto="

    SELECT precio
    FROM producto
    WHERE codigo='$codigo'

    ";


    $resultadoProducto=$conn->query($sqlProducto);


    if(!$resultadoProducto or $resultadoProducto->num_rows==0){

        echo json_encode([

            "ok"=>false,
            "mensaje"=>"Producto no encontrado"

        ]);

        exit;

    }


    $producto=$resultadoProducto->fetch_assoc();

    $precio=$producto["precio"];

    $total=$cantidad*$precio;


    $sql="

    INSERT INTO carrito
    (Pedido_id, Producto_codigo, cantidad, costototal)

    VALUES
    ('$idPedido','$codigo','$cantidad','$total')

    ON DUPLICATE KEY UPDATE
    cantidad = cantidad + VALUES(cantidad),
    costototal = costototal + VALUES(costototal)

    ";


    if($conn->query($sql)){

        echo json_encode([

            "ok"=>true

        ]);

    }else{

        echo json_encode([

            "ok"=>false,
            "mensaje"=>$conn->error

        ]);

    }


}elseif($accion=="mostrar"){


    $sql="

    SELECT p.codigo, p.nombre, p.precio, p.imagen, c.cantidad, c.costototal

    FROM carrito c

    INNER JOIN producto p
    ON c.Producto_codigo=p.codigo

    WHERE c.Pedido_id='$idPedido'

    ";


    $resultado=$conn->query($sql);


    $productos=[];


    while($fila=$resultado->fetch_assoc()){

        $productos[]=$fila;

    }


    echo json_encode($productos);


}elseif($accion=="vaciar"){


    $sql="

    DELETE FROM carrito
    WHERE Pedido_id='$idPedido'

    ";


    if($conn->query($sql)){

        echo json_encode([

            "ok"=>true

        ]);

    }else{

        echo json_encode([

            "ok"=>false,
            "mensaje"=>$conn->error

        ]);

    }


}else{

    echo json_encode([

        "ok"=>false,
        "mensaje"=>"Acción no reconocida"

    ]);

}


$conn->close();

?>