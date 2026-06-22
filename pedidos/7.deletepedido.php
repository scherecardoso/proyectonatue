<?php
session_start();
?>
<?php

$conexion = new mysqli("localhost","root","","shena");
$id = $_GET['id'];
$conexion->query(
    "DELETE FROM carritobWHERE pedidos_id = $id"
);

$conexion->query(
    "DELETE FROM pedidos WHERE id = $id"
);
header("Location: 4.readpedidos.php");
exit();

?>