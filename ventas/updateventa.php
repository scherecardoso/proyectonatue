<?php
session_start();
if(!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador"){ die("Acceso denegado"); }
?>
<?php 
$direccion = "localhost";
$usuario = "root";
$contrasenia = "";
$nombreBD = "shena";
$conexion = new mysqli($direccion, $usuario, $contrasenia, $nombreBD);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_POST['id'];
$costo = $_POST['costo'];
$metodo = $_POST['metodo'];
$estado = $_POST['estado'];

$sql = "UPDATE ventas SET costo='$costo',metodo='$metodo',estado='$estado' WHERE id='$id'";

if ($conexion->query($sql)) {

    $pedido = $conexion->query("SELECT pedidos_id FROM ventas WHERE id='$id'")->fetch_assoc();

    if($pedido){
        if($estado == "Entregado"){
            $conexion->query("UPDATE pedidos SET estado='Entregado' WHERE id='".$pedido['pedidos_id']."'");
        }else{
            $conexion->query("UPDATE pedidos SET estado='En proceso' WHERE id='".$pedido['pedidos_id']."'");
        }
    }

    header("Location: ../admin/ventasypedidos.php");
    exit();

} else {
    echo "Error al actualizar: " . $conexion->error;
}

?>