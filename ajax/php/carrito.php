<?php

session_start();
require("conexion.php");
// ==========================================
//  INDICAR QUE LA RESPUESTA SERÁ JSON
// AJAX recibe datos en formato JSON.
// ==========================================
header("Content-Type: application/json");
// ==========================================
// COMPROBAR SI EXISTE PEDIDO ACTIVO
// ==========================================
if(!isset($_SESSION["pedido"])){
    echo json_encode([
        "ok"=>false,
        "mensaje"=>"No existe pedido activo"
    ]);
    exit;
}

$idPedido = $_SESSION["pedido"];
// ==========================================
// RECIBIR LA ACCIÓN DE AJAX
// ==========================================
// Puede ser:
// agregar
// aumentar
// disminuir
// mostrar
// vaciar
$accion = $_POST["accion"] ?? "";
// ==========================================
// DECIDIR QUÉ OPERACIÓN HACER
// ==========================================
switch($accion){
   // ======================================
    //  AGREGAR PRODUCTO
    // ======================================
    case "agregar":

        $codigo = $_POST["codigo"];

        // ==================================
        // BUSCAR PRODUCTO
        // ==================================
        $sqlProducto = "SELECT * FROM productos WHERE codigo='$codigo'";
        $resultadoProducto = $conn->query($sqlProducto);
        if($resultadoProducto->num_rows == 0){

    echo json_encode([
        "ok"=>false,
        "mensaje"=>"Producto no encontrado"
    ]);

    exit;

}
        $producto = $resultadoProducto->fetch_assoc();

        // Verificar si ya existe
        $sqlExiste = "SELECT * FROM carrito
                       WHERE pedidos_id='$idPedido'
                       AND productos_codigo='$codigo'";

        $resultadoExiste = $conn->query($sqlExiste);
        // ==================================
        // SI YA EXISTE
        // ==================================
        if($resultadoExiste->num_rows > 0){

            $fila = $resultadoExiste->fetch_assoc();

            $cantidad = $fila["cantidad"] + 1;

            // ==================================
            //  VERIFICAR STOCK
            // ==================================

            if($cantidad > (int)$producto["stock"]){
                echo json_encode([
                    "ok"=>false,
                    "mensaje"=>"No hay más stock disponible de este producto"
                ]);
                exit;
            }
           // ==================================
            // CALCULAR SUBTOTAL
            // ==================================
            $subtotal = $cantidad * $producto["precio"];
          // ==================================
            //  ACTUALIZAR CARRITO
            // ==================================
            $sql = "UPDATE Carrito
                    SET cantidad='$cantidad',
                        costototal='$subtotal'
                    WHERE pedidos_id='$idPedido'
                    AND productos_codigo='$codigo'";

        }else{
       // ==================================
            //  COMPROBAR QUE TENGA STOCK
            // ==================================

            if((int)$producto["stock"] <= 0){
                echo json_encode([
                    "ok"=>false,
                    "mensaje"=>"Este producto no tiene stock disponible"
                ]);
                exit;
            }
           // ==================================
            //  SUBTOTAL
            // ==================================

            $subtotal = $producto["precio"];
            // ==================================
            //  INSERTAR PRODUCTO AL CARRITO
            // ==================================

            $sql = "INSERT INTO carrito
                    (pedidos_id,productos_codigo,cantidad,costototal)
                    VALUES
                    ('$idPedido','$codigo',1,'$subtotal')";

        }

        if($conn->query($sql)){

    echo json_encode([
        "ok"=>true,
        "mensaje"=>"Producto agregado correctamente"
    ]);

}else{

    echo json_encode([
        "ok"=>false,
        "mensaje"=>$conn->error
    ]);

}  

    break;
        // ======================================
    // AUMENTAR CANTIDAD
    // ======================================

    case "aumentar":

        $codigo = $_POST["codigo"];
        $sql = "SELECT p.stock,c.cantidad,p.precio FROM carrito c INNER JOIN productos p ON c.productos_codigo=p.codigo WHERE c.pedidos_id='$idPedido' AND c.productos_codigo='$codigo'";
        $resultado = $conn->query($sql);

        if($resultado->num_rows == 0){
            echo json_encode(["ok"=>false,"mensaje"=>"Producto no encontrado en el carrito"]);
            exit;
        }

        $fila = $resultado->fetch_assoc();
        $cantidad = (int)$fila["cantidad"] + 1;

        if($cantidad > (int)$fila["stock"]){
            echo json_encode(["ok"=>false,"mensaje"=>"No hay más stock disponible"]);
            exit;
        }

        $subtotal = $cantidad * (float)$fila["precio"];
        $sql = "UPDATE carrito SET cantidad='$cantidad',costototal='$subtotal' WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        echo json_encode(["ok"=>$conn->query($sql)]);

    break;
    // ======================================
    // DISMINUIR CANTIDAD
    // ======================================

    case "disminuir":

        $codigo = $_POST["codigo"];
        $sql = "SELECT cantidad,precio FROM carrito c INNER JOIN productos p ON c.productos_codigo=p.codigo WHERE c.pedidos_id='$idPedido' AND c.productos_codigo='$codigo'";
        $resultado = $conn->query($sql);

        if($resultado->num_rows == 0){
            echo json_encode(["ok"=>false,"mensaje"=>"Producto no encontrado"]);
            exit;
        }

        $fila = $resultado->fetch_assoc();
        $cantidad = (int)$fila["cantidad"] - 1;
      // ==================================
        // SI LLEGA A 0, ELIMINAR
        // ==================================

        if($cantidad <= 0){
            $sql = "DELETE FROM carrito WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        }else{
                  // ==================================
            // RECALCULAR SUBTOTAL
            // ==================================
            $subtotal = $cantidad * (float)$fila["precio"];
                        // ==================================
            //  ACTUALIZAR CARRITO
            // ==================================


            $sql = "UPDATE carrito SET cantidad='$cantidad',costototal='$subtotal' WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        }

        echo json_encode(["ok"=>$conn->query($sql)]);

    break;
    // ======================================
    //  MOSTRAR CARRITO
    // ======================================

    case "mostrar":

    $sql = "SELECT
                c.productos_codigo,
                c.cantidad,
                c.costototal,
                p.nombre,
                p.precio,
                p.imagen
            FROM carrito c
            INNER JOIN productos p
            ON c.productos_codigo = p.codigo
            WHERE c.pedidos_id='$idPedido'";

    $resultado = $conn->query($sql);

    $carrito = [];

    while($fila = $resultado->fetch_assoc()){

        $carrito[] = $fila;

    }

    echo json_encode($carrito);

break;
    // ======================================
    // VACIAR CARRITO
    // ======================================

case "vaciar":

    $sql = "DELETE FROM carrito
            WHERE pedidos_id='$idPedido'";

    if($conn->query($sql)){

        echo json_encode([
            "ok"=>true,
            "mensaje"=>"Carrito vaciado correctamente"
        ]);

    }else{

        echo json_encode([
            "ok"=>false,
            "mensaje"=>$conn->error
        ]);

    }

break;

}
