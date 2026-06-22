<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "vendedor") {
    die("Acceso denegado");
}
$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pedidos de Clientes</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#f5f5f5;
    margin:0;
    padding:30px;
}

.contenedor{
    max-width:1200px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 20px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    color:#d88aa7;
    margin-bottom:25px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f4dbe5;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:hover{
    background:#faf2f6;
}

select{
    padding:5px;
}

button{
    padding:8px 12px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    background:#d88aa7;
    color:white;
}

button:hover{
    background:#c06d8c;
}

</style>
</head>

<body>
<?php include("../includes/header.php"); ?>
<div class="contenedor">
<h2>Pedidos de Clientes</h2>

<table>

<tr>
    <th>ID Pedido</th>
    <th>Cliente</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Productos</th>
    <th>Acción</th>
</tr>

<?php

$sqlPedidos = "SELECT * FROM pedidos ORDER BY id DESC";
$resultadoPedidos = $conn->query($sqlPedidos);

if($resultadoPedidos && $resultadoPedidos->num_rows > 0){

    while($pedido = $resultadoPedidos->fetch_assoc()){

        $idPedido = $pedido['id'];
        $sqlProductos = " SELECT p.nombre, c.cantidad FROM carrito c INNER JOIN productos p ON c.productos_codigo = p.codigo WHERE c.pedidos_id = '$idPedido'";
        $resultadoProductos = $conn->query($sqlProductos);
        $productos = "";
        if($resultadoProductos){

            while($prod = $resultadoProductos->fetch_assoc()){
                $productos .= $prod['nombre'] .
                              " (".$prod['cantidad'].")<br>";
            }
        }
?>

<tr>

<td><?php echo $pedido['id']; ?></td>
<td><?php echo htmlspecialchars($pedido['nombre']); ?></td>
<td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
<td><?php echo htmlspecialchars($pedido['estado']); ?></td>
<td><?php echo $productos; ?></td>
<td>

<form action="actualizar_estado_pedido.php" method="POST">
<input type="hidden" name="pedido_id" value="<?php echo $pedido['id']; ?>">

<select name="estado">
<option value="En Proceso">En Proceso</option>
<option value="Aceptado">Aceptado</option>
<option value="Rechazado">Rechazado</option>
</select>

<button type="submit">Actualizar</button>

</form>
</td>
</tr>
<?php
    }
}else{
?>

<tr><td>No existen pedidos registrados.</td></tr>
<?php
}
?>
</table>
</div>
</body>
</html>
<?php
$conn->close();
?>