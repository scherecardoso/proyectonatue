<?php
session_start();

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión");
}

$nombre = $_SESSION['nombre'];

$sql = "SELECT pedidos.id,
               pedidos.fecha,
               pedidos.estado,
               productos.nombre AS producto,
               productos.precio,
               carrito.cantidad,
               carrito.costototal
        FROM pedidos
        INNER JOIN carrito
        ON pedidos.id = carrito.pedidos_id
        INNER JOIN productos
        ON carrito.productos_codigo = productos.codigo
        WHERE pedidos.nombre = '$nombre'
        ORDER BY pedidos.id DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Pedidos</title>

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
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#faf2f6;
}

.estado{
    font-weight:bold;
}

@media  (max-width: 768px) {

    body{
        padding:15px;
    }

    .contenedor{
        padding:15px;
    }

    h2{
        font-size:24px;
    }

    table{
        font-size:14px;
    }

    th,
    td{
        padding:8px;
    }
}


@media (max-width: 600px) {

    body{
        padding:10px;
    }

    .contenedor{
        padding:10px;
        overflow-x:auto;
    }

    table{
        min-width:700px;
    }

    th,
    td{
        padding:6px;
        font-size:12px;
    }

    h2{
        font-size:20px;
    }
}
</style>

</head>
<body>

<?php include("../includes/header.php"); ?>

<div class="contenedor">

<h2>Mis Pedidos</h2>

<table>

<tr>
    <th>ID Pedido</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Producto</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Total</th>
</tr>

<?php

if($resultado && $resultado->num_rows > 0){
    while($fila = $resultado->fetch_assoc()){

?>

<tr>
    <td><?php echo $fila['id']; ?></td>
    <td><?php echo $fila['fecha']; ?></td>
    <td class="estado"><?php echo $fila['estado']; ?></td>
    <td><?php echo $fila['producto']; ?></td>
    <td><?php echo $fila['precio']; ?> Bs</td>
    <td><?php echo $fila['cantidad']; ?></td>
    <td><?php echo $fila['costototal']; ?> Bs</td>
</tr>

<?php
    }
}else{
?>
<tr><td>No tienes pedidos registrados.</td></tr>
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