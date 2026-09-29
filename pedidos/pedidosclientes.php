<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "vendedor") {
    header("Location: ../pagina/login.php");
    exit();
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&family=Tenor+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<title>Pedidos de Clientes</title>
<style>


body {
    display: grid;
    font-family: Arial, sans-serif;
    margin: 0;
    grid-template-areas:
        "barra barra"
        "menu-lateral contenedor";
    grid-template-columns: 320px minmax(0, 1fr);
    grid-template-rows: 88px 1fr;
    min-height: 100vh;
    gap: 5px;
}

.contenedor {
    grid-area: contenedor;
    width: 95%;
    min-width: 0;
    margin: 20px auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, .1);
}

.barra-superior {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.barra-superior h2 {
    margin: 0;
    flex: 1;
    text-align: center;
    color: #ff5ca8;
    font-family: "Playfair Display", serif;
}

.tabla-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
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
    background: #ffffff;
    padding: 16px;
    font-size: 14px;
    text-align: center;
    border-top: 1px solid #f3f3f3;
    border-bottom: 1px solid #f3f3f3;
    word-break: break-word;
}

tbody tr:hover td {
    background: #faf2f6;
}

.estado {
    display: inline-block;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: bold;
}

.estado-pendiente {
    background: #f6dce7;
    color: #ff4f94;
}

.estado-aceptado,
.estado-entregado {
    background: #d8f0dc;
    color: #159957;
}

.estado-rechazado {
    background: #ffe1e1;
    color: #b42323;
}

.accionesPedido {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.accionesPedido form {
    margin: 0;
}

.accionesPedido a,
.accionesPedido button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 14px;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: .2s;
}

.btnVerPedido {
    background: #eeeeee;
    color: #222;
}

.btnVerPedido:hover {
    background: #dddddd;
    transform: translateY(-2px);
}

.btnAceptar {
    background: #dff5e7;
    color: #217346;
}

.btnAceptar:hover {
    background: #c7ecd4;
    transform: translateY(-2px);
}

.btnRechazar {
    background: #ffe1e1;
    color: #b42323;
}

.btnRechazar:hover {
    background: #ffcaca;
    transform: translateY(-2px);
}

.sin-datos {
    text-align: center;
    margin: 30px 0;
    color: #777;
}

@media (max-width: 1199px) {
    body {
        grid-template-areas:
            "barra"
            "menu-lateral"
            "contenedor";
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto;
        gap: 0;
    }

    .contenedor {
        width: 95%;
        padding: 20px;
        margin: 15px auto;
    }
}

@media (max-width: 768px) {
    .contenedor {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 0;
    }

    .barra-superior h2 {
        font-size: 22px;
    }

    .tabla-scroll {
        overflow-x: visible;
    }

    table,
    tbody {
        display: block;
        width: 100%;
    }

    thead {
        display: none;
    }

    tbody tr {
        display: block;
        margin-bottom: 16px;
        background: #ffffff;
        border: 1px solid #f3d5e2;
        border-radius: 18px;
        padding: 8px 14px;
        box-shadow: 0 4px 14px rgba(255, 92, 168, 0.08);
    }

    tbody tr:hover td {
        background: transparent;
    }

    td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 10px 0;
        border: none;
        border-bottom: 1px dashed #f3d5e2;
        background: transparent;
        text-align: right;
        font-size: 14px;
    }

    td:last-child {
        border-bottom: none;
    }

    td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #ff5ca8;
        text-align: left;
        flex-shrink: 0;
        max-width: 40%;
    }

    td[data-label="Acción"] {
        flex-direction: column;
        align-items: stretch;
    }

    td[data-label="Acción"]::before {
        display: none;
    }

    .accionesPedido {
        width: 100%;
    }

    .accionesPedido form {
        flex: 1;
    }

    .accionesPedido a,
    .accionesPedido button {
        width: 100%;
        padding: 10px;
    }

    .accionesPedido a {
        flex: 1 1 100%;
    }
}
</style>
</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/includeVendedor.php"); ?>

<div class="contenedor">
    <div class="barra-superior">
        <h2>Pedidos de Clientes</h2>
    </div>

<?php
$resultadoPedidos = $conn->query("SELECT * FROM pedidos ORDER BY id DESC");

$stmtProductos = $conn->prepare(
    "SELECT productos.nombre, carrito.cantidad
     FROM carrito
     INNER JOIN productos ON carrito.productos_codigo = productos.codigo
     WHERE carrito.pedidos_id = ?"
);

if ($resultadoPedidos && $resultadoPedidos->num_rows > 0) {
?>
    <div class="tabla-scroll">
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Productos</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
<?php
    while ($pedido = $resultadoPedidos->fetch_assoc()) {
        $idPedido = (int)$pedido['id'];
        $estado = $pedido['estado'];
        $claseEstado = "estado-" . strtolower(preg_replace('/[^A-Za-z]/', '', $estado));

        $stmtProductos->bind_param("i", $idPedido);
        $stmtProductos->execute();
        $resultadoProductos = $stmtProductos->get_result();

        $productos = "";
        while ($prod = $resultadoProductos->fetch_assoc()) {
            $productos .= htmlspecialchars($prod['nombre']) . " (" . (int)$prod['cantidad'] . ")<br>";
        }

        if ($productos === "") {
            $productos = "Sin productos";
        }
?>
                <tr>
                    <td data-label="ID Pedido"><?php echo $idPedido; ?></td>
                    <td data-label="Cliente"><?php echo htmlspecialchars($pedido['nombre']); ?></td>
                    <td data-label="Fecha"><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                    <td data-label="Estado">
                        <span class="estado <?php echo htmlspecialchars($claseEstado); ?>"><?php echo htmlspecialchars($estado); ?></span>
                    </td>
                    <td data-label="Productos"><?php echo $productos; ?></td>
                    <td data-label="Acción">
                        <div class="accionesPedido">
                            <a href="detallepedido.php?id=<?php echo $idPedido; ?>" class="btnVerPedido">
                                <i class="fa-solid fa-eye"></i>
                                Ver pedido
                            </a>

<?php if ($estado == 'Pendiente') { ?>
                            <form action="Actualizar_estado_pedido.php" method="POST">
                                <input type="hidden" name="pedido_id" value="<?php echo $idPedido; ?>">
                                <input type="hidden" name="estado" value="Aceptado">
                                <button type="submit" class="btnAceptar">
                                    <i class="fa-solid fa-check"></i>
                                    Aceptar
                                </button>
                            </form>

                            <form action="Actualizar_estado_pedido.php" method="POST">
                                <input type="hidden" name="pedido_id" value="<?php echo $idPedido; ?>">
                                <input type="hidden" name="estado" value="Rechazado">
                                <button type="submit" class="btnRechazar">
                                    <i class="fa-solid fa-xmark"></i>
                                    Rechazar
                                </button>
                            </form>
<?php } ?>
                        </div>
                    </td>
                </tr>
<?php
    }
?>
            </tbody>
        </table>
    </div>
<?php
} else {
?>
    <p class="sin-datos">No hay pedidos registrados.</p>
<?php
}

$stmtProductos->close();
?>
</div>

</body>
</html>
<?php
$conn->close();
?>