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
    grid-template-columns: 330px minmax(0, 1fr);
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "barra barra"
        "menu info";
    gap: 10px;
    min-height: 100vh;
    background: #ffffff;
    overflow-x: hidden;
}


.info {
    grid-area: info;
    min-width: 0;
    padding: 25px 20px 30px;
    box-sizing: border-box;
}

.contenedor {
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,.1);
    box-sizing: border-box;
    overflow-x: auto;
}

.contenedor h2 {
    text-align: center;
    color: #ff5ca8;
    margin: 0 0 25px 0;
    font-size: 35px;
    font-family: 'Playfair Display', serif;
}

.tabla-pedidos {
    width: 100%;
    border-collapse: collapse;
}

.tabla-pedidos th {
    background: #fff1f7;
    padding: 16px;
    font-size: 14px;
    color: #ff5ca8;
    text-align: center;
}

.tabla-pedidos td {
    padding: 12px;
    text-align: center;
    color: black;
    border-bottom: 1px solid #ddd;
}

.tabla-pedidos tbody tr:hover {
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


@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto;
        grid-template-areas:
            "barra"
            "menu"
            "info";
        gap: 0;
    }

    .info {
        padding: 20px 15px 30px;
    }
}


@media (max-width: 900px) {
    .contenedor {
        padding: 20px;
    }

    .contenedor h2 {
        font-size: 28px;
        margin-bottom: 20px;
    }

    .tabla-pedidos th {
        padding: 12px 8px;
        font-size: 13px;
    }

    .tabla-pedidos td {
        padding: 10px 8px;
        font-size: 14px;
    }

    .estado {
        padding: 6px 12px;
        font-size: 13px;
    }
}



@media (max-width: 700px) {
    .info {
        padding: 15px 10px 25px;
    }

    .contenedor {
        padding: 15px;
        border-radius: 12px;
        overflow-x: visible;
    }

    .contenedor h2 {
        font-size: 24px;
    }

    .tabla-pedidos,
    .tabla-pedidos tbody,
    .tabla-pedidos tr,
    .tabla-pedidos td {
        display: block;
        width: 100%;
        box-sizing: border-box;
    }

    
    .tabla-pedidos thead {
        display: none;
    }

    .tabla-pedidos tbody tr {
        margin-bottom: 15px;
        border: 1px solid #f3d3e3;
        border-radius: 12px;
        padding: 5px 0;
        overflow: hidden;
    }

    .tabla-pedidos td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        text-align: right;
        padding: 9px 14px;
        font-size: 14px;
        border-bottom: 1px solid #f7e6ee;
    }

    .tabla-pedidos td:last-child {
        border-bottom: none;
    }

    .tabla-pedidos td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #ff5ca8;
        text-align: left;
        flex-shrink: 0;
    }


    .tabla-pedidos td.vacio {
        justify-content: center;
        text-align: center;
    }

    .tabla-pedidos td.vacio::before {
        display: none;
    }
}


@media (max-width: 480px) {
    .contenedor {
        padding: 12px;
    }

    .contenedor h2 {
        font-size: 21px;
    }

    .tabla-pedidos td {
        padding: 8px 10px;
        font-size: 13px;
    }

    .estado {
        padding: 5px 10px;
        font-size: 12px;
    }
}

</style>

</head>


<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/includeuser.php"); ?>


<main class="info">

<div class="contenedor">

<h2>Mis Pedidos</h2>

<table class="tabla-pedidos">

<thead>
<tr>
    <th>ID Pedido</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Producto</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Total</th>
</tr>
</thead>

<tbody>

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

    <td data-label="ID Pedido">
        <?php echo htmlspecialchars($fila['id']); ?>
    </td>

    <td data-label="Fecha">
        <?php echo htmlspecialchars($fila['fecha']); ?>
    </td>

    <td data-label="Estado">

        <span class="estado <?php echo $claseEstado; ?>">

            <?php echo htmlspecialchars($fila['estado']); ?>

        </span>

    </td>

    <td data-label="Producto">
        <?php echo htmlspecialchars($fila['producto']); ?>
    </td>

    <td data-label="Precio">
        <?php echo htmlspecialchars($fila['precio']); ?> Bs
    </td>

    <td data-label="Cantidad">
        <?php echo htmlspecialchars($fila['cantidad']); ?>
    </td>

    <td data-label="Total">
        <?php echo htmlspecialchars($fila['costototal']); ?> Bs
    </td>

</tr>

<?php

    }

} else {

?>

<tr>

    <td colspan="7" class="vacio">
        No tienes pedidos registrados.
    </td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</main>


</body>

</html>


<?php

$stmt->close();

$conn->close();

?>