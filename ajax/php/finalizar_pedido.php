<?php

// Inicia o recupera la sesión para acceder al pedido asociado al usuario actual.
session_start();

// Carga la conexión a la base de datos definida para los archivos AJAX.
require("conexion.php");

// Indica que todas las respuestas de este archivo se devolverán en formato JSON.
header("Content-Type: application/json");

// Comprueba que exista un pedido activo guardado en la sesión.
if(!isset($_SESSION["pedido"])){
    // Informa al cliente que no hay ningún pedido que pueda finalizar.
    echo json_encode([
        "ok" => false,
        "mensaje" => "No existe pedido activo"
    ]);
    exit;
}

// Guarda el identificador del pedido para utilizarlo en las consultas siguientes.
$idPedido = $_SESSION["pedido"];

// Obtiene los artículos del carrito y el stock disponible de cada producto.
// La unión permite consultar únicamente productos existentes en la tabla productos.
$sql = "SELECT c.cantidad, p.nombre, p.stock
        FROM carrito c
        INNER JOIN productos p
        ON c.productos_codigo = p.codigo
        WHERE c.pedidos_id = '$idPedido'";

$resultado = $conn->query($sql);

// Si la consulta falla o no devuelve artículos, no se puede finalizar el pedido.
if(!$resultado || $resultado->num_rows == 0){
    // Devuelve un mensaje que el cliente puede mostrar al usuario.
    echo json_encode([
        "ok" => false,
        "mensaje" => "El carrito está vacío"
    ]);
    exit;
}

// Revisa cada artículo para comprobar que la cantidad solicitada esté disponible.
while($fila = $resultado->fetch_assoc()){

    // Compara como números la cantidad pedida y el stock actual del producto.
    if((int)$fila["cantidad"] > (int)$fila["stock"]){

        // Detalla qué producto no cuenta con unidades suficientes.
        echo json_encode([
            "ok" => false,
            "mensaje" => "No hay suficiente stock de ".$fila["nombre"]
        ]);

        exit;
    }
}

// Al superar la validación del carrito, cambia el estado del pedido a Pendiente.
$sql = "UPDATE pedidos
        SET estado = 'Pendiente'
        WHERE id = '$idPedido'";

// Comprueba si la actualización del estado se realizó correctamente.
if($conn->query($sql)){

    // Confirma el éxito y devuelve el identificador del pedido finalizado.
    echo json_encode([
        "ok" => true,
        "pedido" => $idPedido
    ]);

}else{

    // Si ocurre un error en la base de datos, lo devuelve como mensaje JSON.
    echo json_encode([
        "ok" => false,
        "mensaje" => $conn->error
    ]);
}

?>