<?php
session_start();
?>
<?php
$conn = new mysqli("localhost","root","","shena");

if($conn->connect_error){
    die("Error de conexión");
}

if (!isset($_GET["idPedido"])) {
    header("Location: ../carrito/micarrito.php");
    exit();
}
$idPedido = (int) $_GET['idPedido'];

$sql = "UPDATE pedidos SET estado='Pendiente' WHERE id='$idPedido'";

if($conn->query($sql)){
    unset($_SESSION["pedidos_id"]);
    echo " <script> alert('Pedido enviado correctamente');window.location='../pagina/03.productos.php';</script>";

}else{
    echo $conn->error;
}
$conn->close();
?>