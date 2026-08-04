guardaredido <?php
session_start();

$conexion = new mysqli("localhost","root","","shena");

if($conexion->connect_error){
    die("Error de conexión");
}

$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$vendedor = $_POST['vendedor'];

$sql = "INSERT INTO pedidos(nombre, fecha, estado, vendedor)VALUES('$nombre','$fecha','$estado','$vendedor')";

if($conexion->query($sql)){
    $idPedido = $conexion->insert_id;

    if($conexion->query($sql)){

        header("Location: ../carrito/micarrito.php?idPedido=".$idPedido);
        exit();

    }else{
        echo "Error al guardar carrito: ".$conexion->error;
    }


}else{
    echo "Error al crear pedido: " . $conexion->error;
}
?>