<?php

// Este archivo maneja todas las acciones del carrito de compras.
// Se activa desde JavaScript o formularios AJAX para agregar, modificar, mostrar o vaciar productos.
// La respuesta siempre se devuelve en formato JSON para que el frontend pueda procesarla fácilmente.

session_start();
require("conexion.php");
header("Content-Type: application/json");

// Se valida que exista un pedido activo en sesión.
// Si no hay pedido, no se puede operar con el carrito porque todo está asociado a ese pedido.
if(!isset($_SESSION["pedido"])){
    echo json_encode([
        "ok"=>false,
        "mensaje"=>"No existe pedido activo"
    ]);
    exit;
}

// ID del pedido actual que viene desde la sesión.
$idPedido = $_SESSION["pedido"];

// Acción que recibe el cliente para decidir qué operación ejecutar.
$accion = $_POST["accion"] ?? "";

// Se evalúa la acción pedida por el frontend.
// Cada caso representa una operación distinta sobre el carrito.
switch($accion){

    // Caso: agregar un producto al carrito.
    // Primero comprueba si el producto existe, luego si ya estaba agregado y por último valida stock.
    case "agregar":

        // Código del producto que se quiere agregar.
        $codigo = $_POST["codigo"];

        // Consulta para buscar el producto en la tabla productos usando su código.
        $sqlProducto = "SELECT * FROM productos WHERE codigo='$codigo'";
        $resultadoProducto = $conn->query($sqlProducto);

        // Si no existe el producto, se responde con un error.
        if($resultadoProducto->num_rows == 0){

    echo json_encode([
        "ok"=>false,
        "mensaje"=>"Producto no encontrado"
    ]);

    exit;

}

        // Se guarda la fila del producto para usar su stock y precio.
        $producto = $resultadoProducto->fetch_assoc();

        // Se revisa si el producto ya está en el carrito del pedido actual.
        $sqlExiste = "SELECT * FROM carrito
                       WHERE pedidos_id='$idPedido'
                       AND productos_codigo='$codigo'";

        $resultadoExiste = $conn->query($sqlExiste);

        // Si ya existe el producto en el carrito, se incrementa su cantidad.
        if($resultadoExiste->num_rows > 0){

            $fila = $resultadoExiste->fetch_assoc();

            // Se aumenta 1 al total de unidades ya agregadas.
            $cantidad = $fila["cantidad"] + 1;

            // Se valida que la nueva cantidad no supere el stock disponible del producto.
            if($cantidad > (int)$producto["stock"]){
                echo json_encode([
                    "ok"=>false,
                    "mensaje"=>"No hay más stock disponible de este producto"
                ]);
                exit;
            }

            // El subtotal del producto se recalcula según la cantidad nueva.
            $subtotal = $cantidad * $producto["precio"];

            // Se actualiza la cantidad y el costo total en carrito.
            $sql = "UPDATE Carrito
                    SET cantidad='$cantidad',
                        costototal='$subtotal'
                    WHERE pedidos_id='$idPedido'
                    AND productos_codigo='$codigo'";

        }else{

            // Si el producto todavía no existe en el carrito, se verifica que haya stock disponible.
            if((int)$producto["stock"] <= 0){
                echo json_encode([
                    "ok"=>false,
                    "mensaje"=>"Este producto no tiene stock disponible"
                ]);
                exit;
            }

            // En un producto nuevo, el subtotal inicial es el precio del producto por la cantidad 1.
            $subtotal = $producto["precio"];

            // Se inserta el producto en el carrito con cantidad inicial 1.
            $sql = "INSERT INTO carrito
                    (pedidos_id,productos_codigo,cantidad,costototal)
                    VALUES
                    ('$idPedido','$codigo',1,'$subtotal')";

        }

        // Ejecuta la consulta SQL que inserta o actualiza el producto.
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


    // Caso: aumentar la cantidad del producto en el carrito.
    // Se busca el producto dentro del carrito y valida stock antes de incrementarlo.
    case "aumentar":

        // Código del producto a aumentar.
        $codigo = $_POST["codigo"];

        // Consulta para traer la cantidad actual, el precio y el stock disponible del producto.
        $sql = "SELECT p.stock,c.cantidad,p.precio FROM carrito c INNER JOIN productos p ON c.productos_codigo=p.codigo WHERE c.pedidos_id='$idPedido' AND c.productos_codigo='$codigo'";
        $resultado = $conn->query($sql);

        // Si el producto no está en el carrito, no se puede aumentar.
        if($resultado->num_rows == 0){
            echo json_encode(["ok"=>false,"mensaje"=>"Producto no encontrado en el carrito"]);
            exit;
        }

        // Se obtiene la fila con los datos necesarios.
        $fila = $resultado->fetch_assoc();

        // Se incrementa la cantidad en 1.
        $cantidad = (int)$fila["cantidad"] + 1;

        // Si se excede el stock, se evita la operación.
        if($cantidad > (int)$fila["stock"]){
            echo json_encode(["ok"=>false,"mensaje"=>"No hay más stock disponible"]);
            exit;
        }

        // Se recalcula el subtotal total para esa cantidad.
        $subtotal = $cantidad * (float)$fila["precio"];

        // Actualiza la fila del carrito con la nueva cantidad y subtotal.
        $sql = "UPDATE carrito SET cantidad='$cantidad',costototal='$subtotal' WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        echo json_encode(["ok"=>$conn->query($sql)]);

    break;


    // Caso: disminuir la cantidad del producto.
    // Si la cantidad llega a cero, se elimina el producto del carrito.
    case "disminuir":

        // Código del producto a disminuir.
        $codigo = $_POST["codigo"];

        // Consulta para obtener cantidad y precio del producto dentro del carrito.
        $sql = "SELECT cantidad,precio FROM carrito c INNER JOIN productos p ON c.productos_codigo=p.codigo WHERE c.pedidos_id='$idPedido' AND c.productos_codigo='$codigo'";
        $resultado = $conn->query($sql);

        // Si el producto no existe en el carrito, responde con error.
        if($resultado->num_rows == 0){
            echo json_encode(["ok"=>false,"mensaje"=>"Producto no encontrado"]);
            exit;
        }

        // Obtiene la información del producto en el carrito.
        $fila = $resultado->fetch_assoc();

        // Resta 1 a la cantidad actual.
        $cantidad = (int)$fila["cantidad"] - 1;

        // Si la cantidad llega a cero o menos, se elimina la fila del carrito.
        if($cantidad <= 0){
            $sql = "DELETE FROM carrito WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        }else{

            // Si aún queda cantidad, se recalcula el subtotal con la nueva cantidad.
            $subtotal = $cantidad * (float)$fila["precio"];

            // Actualiza la cantidad y subtotal sin eliminar el producto.
            $sql = "UPDATE carrito SET cantidad='$cantidad',costototal='$subtotal' WHERE pedidos_id='$idPedido' AND productos_codigo='$codigo'";
        }

        // Ejecuta la actualización o eliminación.
        echo json_encode(["ok"=>$conn->query($sql)]);

    break;


    // Caso: mostrar todo el contenido del carrito.
    // Se devuelve un array con cada producto incluido junto con nombre, cantidad, precio e imagen.
    case "mostrar":

    // Consulta para listar todos los productos del carrito del pedido actual.
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

    // Se crea un arreglo para formar la respuesta JSON del carrito.
    $carrito = [];

    // Se agrega cada fila a la lista del carrito.
    while($fila = $resultado->fetch_assoc()){

        $carrito[] = $fila;

    }

    // Se responde con el arreglo completo en formato JSON.
    echo json_encode($carrito);

break;


// Caso: vaciar completamente el carrito del pedido actual.
case "vaciar":

    // Elimina todos los productos del carrito relacionado con este pedido.
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
