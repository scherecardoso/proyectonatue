<?php
// Inicia o reanuda la sesión para comprobar quién está usando el sistema.
session_start();
// Esta operación solo está permitida para usuarios con rol de administrador.
if(!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador"){ die("Acceso denegado"); }
?>
<?php 
// Datos de conexión para acceder a la base de datos del proyecto.
$direccion = "localhost";
$usuario = "root";
$contrasenia = "";
$nombreBD = "shena";
// Se establece la conexión con MySQL.
$conexion = new mysqli($direccion, $usuario, $contrasenia, $nombreBD);

// Se detiene el proceso y se informa si hubo un problema de conexión.
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Se leen del formulario los datos de la venta que se desea modificar.
$id = $_POST['id'];
$costo = $_POST['costo'];
$metodo = $_POST['metodo'];
// Si no se envía un estado, se toma "En proceso" como predeterminado.
$estado = $_POST['estado'] ?? 'En proceso';

// Se valida que el estado recibido sea uno de los valores admitidos.
if (!in_array($estado, ['En proceso', 'Entregado'], true)) {
    die('Estado de venta no válido');
}

// Se prepara la consulta que actualiza los datos de la venta identificada por su ID.
$sql = "UPDATE ventas SET costo='$costo',metodo='$metodo',estado='$estado' WHERE id='$id'";

// Si se actualizó la venta, se busca y sincroniza el estado de su pedido asociado.
if ($conexion->query($sql)) {

    // Se obtiene el ID del pedido vinculado con esta venta.
    $pedido = $conexion->query("SELECT pedidos_id FROM ventas WHERE id='$id'")->fetch_assoc();

    // Solo se intenta actualizar el pedido cuando existe una relación encontrada.
    if($pedido){
        // Si la venta fue marcada como entregada, también se marca así el pedido.
        if($estado == "Entregado"){
            $conexion->query("UPDATE pedidos SET estado='Entregado' WHERE id='".$pedido['pedidos_id']."'");
        }else{
            // En caso contrario, el pedido queda en proceso.
            $conexion->query("UPDATE pedidos SET estado='En proceso' WHERE id='".$pedido['pedidos_id']."'");
        }
    }

    // Se regresa al listado de administración después de completar la actualización.
    header("Location: ../admin/ventasypedidos.php");
    exit();

} else {
    // Si la consulta de actualización falla, se muestra el mensaje de error de la conexión.
    echo "Error al actualizar: " . $conexion->error;
}

?>