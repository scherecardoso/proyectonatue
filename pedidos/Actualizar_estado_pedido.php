<?php
session_start();
require("../ajax/php/conexion.php");

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != "vendedor"){
    echo "Acceso denegado";
    exit();
}

$id = $_POST['pedido_id'];
$estado = $_POST['estado'];

if($estado == "Rechazado"){
    $sql = "UPDATE pedidos SET estado='Rechazado' WHERE id='$id'";
    if($conn->query($sql)){
        header("Location: ../vendedor/07.vendedor.php");
        exit();
    }
    echo "Error: ".$conn->error;
    exit();
}

if($estado == "Aceptado"){

    $ventaExistente = $conn->query("SELECT id FROM ventas WHERE pedidos_id='$id'");
    if($ventaExistente && $ventaExistente->num_rows > 0){
        die("Este pedido ya fue aceptado.");
    }

    $sqlPedido = "SELECT * FROM pedidos WHERE id='$id'";
    $resultadoPedido = $conn->query($sqlPedido);
    $pedido = $resultadoPedido->fetch_assoc();

    $sqlCarrito = "SELECT productos_codigo,cantidad,costototal FROM carrito WHERE pedidos_id='$id'";
    $resultadoCarrito = $conn->query($sqlCarrito);

    if(!$resultadoCarrito || $resultadoCarrito->num_rows==0){
        die("El pedido no tiene productos.");
    }

    while($item=$resultadoCarrito->fetch_assoc()){
        $codigo=$item['productos_codigo'];
        $cantidad=(int)$item['cantidad'];
        $stockResultado=$conn->query("SELECT stock FROM productos WHERE codigo='$codigo'");
        $producto=$stockResultado->fetch_assoc();
        if(!$producto || (int)$producto['stock'] < $cantidad){
            die("No hay suficiente stock para aceptar el pedido.");
        }
    }

    $totalResultado=$conn->query("SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id='$id'");
    $total=$totalResultado->fetch_assoc()['total'];
    $metodoPago=$pedido['metodoPago'];
    $vendedor=$_SESSION['nombre'] ?? $_SESSION['usuario'] ?? 'Vendedor';

    $sqlVenta="INSERT INTO ventas(pedidos_id,costo,metodo,estado) VALUES('$id','$total','$metodoPago','En proceso')";
    if(!$conn->query($sqlVenta)){
        die("Error al registrar la venta: ".$conn->error);
    }

    $resultadoCarrito=$conn->query("SELECT productos_codigo,cantidad FROM carrito WHERE pedidos_id='$id'");
    while($item=$resultadoCarrito->fetch_assoc()){
        $codigo=$item['productos_codigo'];
        $cantidad=(int)$item['cantidad'];
        $conn->query("UPDATE productos SET stock=stock-$cantidad WHERE codigo='$codigo'");
    }

    $sql="UPDATE pedidos SET estado='Aceptado',vendedor='$vendedor' WHERE id='$id'";
    if($conn->query($sql)){
        header("Location: ../vendedor/07.vendedor.php");
        exit();
    }
    echo "Error: ".$conn->error;
    exit();
}

header("Location: ../vendedor/07.vendedor.php");
?>