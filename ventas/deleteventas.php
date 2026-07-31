<?php
session_start();
?>
<?php

$conexion = new mysqli("localhost","root","","shena");
$id = $_GET['id'];
$conexion->query(
    "DELETE FROM ventas WHERE pedidos_id = $id"
);

$conexion->query(
    "DELETE FROM ventas WHERE id = $id"
);
header("Location: readventas.php");
exit();

?>