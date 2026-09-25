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
        WHERE pedidos.nombre = ?
        ORDER BY pedidos.id DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre);
$stmt->execute();

$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap"
        rel="stylesheet">

<style>

body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;

    grid-template-columns: 198px 1fr 260px;

    grid-template-rows: 70px 1fr;

    grid-template-areas:
        "barra barra barra"
        "menu info act"
        "pie pie pie";

    gap: 10px;

    height: 100vh;

    background: #ffffff;
}


.info {
    grid-area: info;

    display: grid;

    grid-template-areas:
      "contenedor";

    grid-template-rows: auto auto 1fr;

    gap: 20px;

    padding: 10px;

    margin-top: 25px;
}


.menu div:hover {
    background: #ffdcec;
    color: #fb7cb7;
    padding-left: 22px;
}


.contenedor {
    width: 95%;
    height: 100%;

    margin: auto;

    background: white;

    padding: 30px;

    border-radius: 15px;

    box-shadow: 0 0 20px rgba(0,0,0,.1);

    transform: translateX(170px);
}


h2 {
    text-align: center;
    color: #ff5ca8;
    margin-bottom: 25px;
    font-size: 35px;
    font-family: 'Playfair Display', serif;
}


table {
    width: 100%;
    border-collapse: collapse;
}



th {
    background: #fff1f7;
    padding: 16px;
    font-size: 14px;
    color: #ff5ca8;
    text-align: center;
}


td {
    padding: 12px;

    text-align: center;

    border-bottom: 1px solid #ddd;
}


tr:hover {
    background: #faf2f6;
}



.estado {
    font-weight: bold;

    display: inline-block;

    padding: 7px 15px;

    border-radius: 20px;

    font-size: 14px;
}


.estado-aceptado {
    color: #237a3b;

    background: #dff5e4;

    border: 1px solid #9bd6a8;
}

.estado-rechazado {
    color: #b52b2b;

    background: #fde0e0;

    border: 1px solid #efaaaa;
}



.estado-pendiente {
    color: #9a7200;

    background: #fff3c4;

    border: 1px solid #e7cf70;
}



.estado-proceso {
    color: #986300;

    background: #fff0cf;

    border: 1px solid #e5c477;
}


.estado-entregado {
    color: #286d72;

    background: #dff4f5;

    border: 1px solid #9ed5d8;
}


p {
    font-size: 20px;
}


div {
    color: black;
}


i {
    color: black;
}


.menu a {
    text-decoration: none;

    color: black;
}


@media (max-width: 768px) {

    body {
        padding: 15px;
    }

    .contenedor {
        padding: 15px;
    }

    h2 {
        font-size: 24px;
    }

    table {
        font-size: 14px;
    }

    th,
    td {
        padding: 8px;
    }

}


@media (max-width: 600px) {

    body {
        padding: 10px;
    }

    .contenedor {
        padding: 10px;

        overflow-x: auto;
    }

    table {
        min-width: 700px;
    }

    th,
    td {
        padding: 6px;

        font-size: 12px;
    }

    h2 {
        font-size: 20px;
    }

}

</style>

</head>


<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/includeuser.php"); ?>


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

if ($resultado && $resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {
        $estado = strtolower(trim($fila['estado']));

        if ($estado === 'aceptado') {

            $claseEstado = 'estado-aceptado';

        } elseif ($estado === 'rechazado') {

            $claseEstado = 'estado-rechazado';

        } elseif ($estado === 'pendiente') {

            $claseEstado = 'estado-pendiente';

        } elseif ($estado === 'en proceso') {

            $claseEstado = 'estado-proceso';

        } elseif ($estado === 'entregado') {

            $claseEstado = 'estado-entregado';

        } else {

            $claseEstado = 'estado-pendiente';
        }

?>

<tr>

    <td>
        <?php echo htmlspecialchars($fila['id']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($fila['fecha']); ?>
    </td>

    <td>

        <span class="estado <?php echo $claseEstado; ?>">

            <?php echo htmlspecialchars($fila['estado']); ?>

        </span>

    </td>

    <td>
        <?php echo htmlspecialchars($fila['producto']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($fila['precio']); ?> Bs
    </td>

    <td>
        <?php echo htmlspecialchars($fila['cantidad']); ?>
    </td>

    <td>
        <?php echo htmlspecialchars($fila['costototal']); ?> Bs
    </td>

</tr>

<?php

    }

} else {

?>

<tr>

    <td colspan="7">
        No tienes pedidos registrados.
    </td>

</tr>

<?php

}

?>

</table>

</div>


</body>

</html>


<?php

$stmt->close();

$conn->close();

?>