<?php
session_start();

if (!isset($_SESSION['nombre']) || trim($_SESSION['nombre']) === "") {
    header("Location: ../usuario/09.register.php");
    exit();
}

$conn = new mysqli("localhost","root","","shena");

if ($conn->connect_error) {
    die("Error de conexión");
}

$nombre = $conn->real_escape_string($_SESSION['nombre']);
$sqlPedido = " SELECT id FROM pedidos WHERE nombre='$nombre' AND estado='En Proceso' ORDER BY id DESC LIMIT 1";
$resPedido = $conn->query($sqlPedido);

if($resPedido->num_rows == 0){
    die("No existe un pedido activo");
}

$pedido = $resPedido->fetch_assoc();
$id_pedido = $pedido['id'];

$sqlTotal = "SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id='$id_pedido'";
$res = $conn->query($sqlTotal);

if ($res) {
    $row = $res->fetch_assoc();
    $total = $row['total'] ?? 0;
} else {
    $total = 0;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi Carrito</title>
<style>
body{
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    margin: 0;
    padding: 30px;
}
.contenedor{
    max-width: 1100px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,.1);
}
h2{
    text-align: center;
    color: #d88aa7;
    margin-bottom: 10px;
}
.total{
    text-align: center;
    color: #666;
    margin-bottom: 25px;
}
table{
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 10px;
}
th{
    background: #f4dbe5;
    color: #555;
    padding: 12px;
}
td{
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}
tr:hover{
    background: #faf2f6;
}
input{
    width: 60px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.btn-actualizar{
    background: #d88aa7;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
}
.btn-actualizar:hover{
    background: #c06d8c;
}
.btn-eliminar{
    background: #d9d9d9;
    color: black;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
}
.btn-eliminar:hover{
    background: #bfbfbf;
}
.btn-finalizar{
    display: block;
    width: 220px;
    margin: 30px auto;
    text-align: center;
    background: #d88aa7;
    color: white;
    padding: 14px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
}
.btn-finalizar:hover{
    background: #c06d8c;
}

@media screen and (max-width: 768px) {
    body {
        padding: 15px;
    }

    .contenedor {
        padding: 15px;
    }

    h2 {
        font-size: 24px;
    }

    h3.total {
        font-size: 18px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }

    .btn-finalizar {
        width: 100%;
        max-width: 300px;
    }
}

@media  (max-width: 600px) {

    .contenedor {
        overflow-x: auto;
    }

    table {
        min-width: 600px;
    }

    input[type="number"] {
        width: 50px;
    }

    .btn-actualizar,
    .btn-eliminar {
        font-size: 12px;
        padding: 6px 8px;
    }

    .btn-finalizar {
        width: 100%;
        font-size: 14px;
        padding: 12px;
    }
}
</style>

</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="contenedor">

<h2>Mi Carrito</h2>
<h3 class="total">Total del Pedido: <?php echo $total; ?> Bs</h3>

<table>

<tr>
<th>Código</th>
<th>Nombre</th>
<th>Precio</th>
<th>Cantidad</th>
<th>Total</th>
<th>Acciones</th>
</tr>

<?php

$sqlCarrito = " SELECT p.codigo,p.nombre,p.precio,c.cantidad,c.costototal
FROM carrito c INNER JOIN productos p ON c.productos_codigo = p.codigo WHERE c.pedidos_id = '$id_pedido'";

$resCarrito = $conn->query($sqlCarrito);
echo "Pedido actual: " . $id_pedido . "<br>";
while($fila = $resCarrito->fetch_assoc()){

?>

<tr>
<td><?php echo htmlspecialchars($fila['codigo']); ?></td>
<td><?php echo htmlspecialchars($fila['nombre']); ?></td>
<td><?php echo htmlspecialchars($fila['precio']); ?> Bs</td>
<td>

<form action="editarcarrito.php" method="POST">

<input type="hidden"name="idPedido"value="<?php echo $id_pedido; ?>">
<input type="hidden"name="codigo"value="<?php echo htmlspecialchars($fila['codigo']); ?>">
<input type="hidden"name="precio"value="<?php echo htmlspecialchars($fila['precio']); ?>">
<input type="number"name="cantidad"value="<?php echo htmlspecialchars($fila['cantidad']); ?>"min="1">
<input class="btn-actualizar"type="submit"value="Actualizar">
</form>
</td>

<td><?php echo htmlspecialchars($fila['costototal']); ?> Bs</td>

<td>
<a class="btn-eliminar"href="eliminarcarrito.php?idPedido=<?php echo $id_pedido; ?>&codigo=<?php echo htmlspecialchars($fila['codigo']); ?>">Eliminar</a>
</td>
</tr>

<?php
}
?>

</table>
<a class="btn-finalizar" href="../pedidos/8.finalizarpedido.php?idPedido=<?php echo $id_pedido; ?>"> Finalizar Pedido </a>
</div>
</body>
</html>
<?php
$conn->close();
?>