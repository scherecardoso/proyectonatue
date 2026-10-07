<?php
// Inicia o recupera la sesión actual para consultar el rol del usuario.
session_start();

// Restringe esta operación a usuarios con rol de administrador.
// Si no hay sesión válida o el rol no corresponde, se detiene el script.
if(!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador"){ die("Acceso denegado"); }

// Abre la conexión con la base de datos del proyecto.
$conexion = new mysqli("localhost","root","","shena");

// Si la conexión no se pudo establecer, se informa el error y no se continúa.
if($conexion->connect_error){ die("Error de conexión"); }

// Obtiene el identificador de la venta enviado en la URL mediante el parámetro id.
$id = $_GET['id'];

// Busca el pedido asociado a la venta que se desea eliminar.
$venta = $conexion->query("SELECT pedidos_id FROM ventas WHERE id='$id'")->fetch_assoc();

// Solo se realizan las operaciones siguientes si se encontró la venta.
if($venta){
    // Guarda el identificador del pedido para actualizarlo al terminar.
    $pedido = $venta['pedidos_id'];

    // Recupera los productos y cantidades del carrito de ese pedido.
    $productos = $conexion->query("SELECT productos_codigo,cantidad FROM carrito WHERE pedidos_id='$pedido'");

    // Recorre cada producto para devolver al inventario las unidades de esta venta.
    while($producto=$productos->fetch_assoc()){
        // Obtiene el código del producto y convierte la cantidad a un entero.
        $codigo=$producto['productos_codigo'];
        $cantidad=(int)$producto['cantidad'];

        // Suma al stock las unidades que estaban asociadas con el pedido cancelado.
        $conexion->query("UPDATE productos SET stock=stock+$cantidad WHERE codigo='$codigo'");
    }

    // Elimina el registro de la venta.
    $conexion->query("DELETE FROM ventas WHERE id='$id'");

    // Deja el pedido disponible para ser procesado de nuevo y sin vendedor asignado.
    $conexion->query("UPDATE pedidos SET estado='Pendiente',vendedor='Sin asignar' WHERE id='$pedido'");
}

// Regresa a la página que muestra el listado de ventas.
header("Location: readventas.php");
// Finaliza la ejecución después de enviar la redirección.
exit();
?>