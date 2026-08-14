<?php
session_start();
if(!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador"){ die("Acceso denegado"); }
if (isset($_GET['pedido'])) {
    $pedidos_id = $_GET['pedido'];
} else {
    die("No se recibió el pedido.");
}

$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "shena";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
}

// Buscamos los productos del pedido para luego mostrar el stock
$sqlCarrito = "SELECT productos_codigo, cantidad FROM carrito WHERE pedidos_id = '$pedidos_id'";
$resultadoCarrito = $conn->query($sqlCarrito);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Venta </title>
</head>
<body>

<article class="caja-formulario">

    <header class="caja-titulos">
        <h3 class="texto-saludo">Productos del pedido</h3>
        <h1 class="texto-rol">Registrar Venta</h1>
    </header>

    <div class="caja-tabla">
        <table>
            <tr>
                <th>Producto</th>
                <th>Stock disponible</th>
                <th>Cantidad solicitada</th>
            </tr>

            <?php
            while ($producto = $resultadoCarrito->fetch_assoc()) {
                $productos_id = $producto['productos_codigo'];
                $cantidad = $producto['cantidad'];

                // Buscar el producto
                $sqlProductos = "SELECT nombre, stock FROM productos WHERE codigo = '$productos_id'";
                $resultadoProductos = $conn->query($sqlProductos);
                $datosProductos = $resultadoProductos->fetch_assoc();
            ?>

            <tr>
                <td><?php echo $datosProductos['nombre']; ?></td>
                <td><?php echo $datosProductos['stock']; ?></td>
                <td><?php echo $cantidad; ?></td>
            </tr>

            <?php
            }
            ?>
        </table>
    </div>

    <form action="createventas.php" method="POST" class="caja-pago">

        <input type="hidden" name="pedidos_id" value="<?php echo $pedidos_id; ?>">

        <div class="grupo-campo">
            <label>Método de Pago:</label>
            <select name="metodo" required>
                <option value="">Seleccione</option>
                <option value="Efectivo">Efectivo</option>
                <option value="QR">QR</option>
                <option value="Tarjeta">Tarjeta</option>
            </select>
        </div>

        <button type="submit" class="boton-registrar">Registrar Venta</button>

    </form>

</article>

</body>
</html>

<?php
    $conn->close();
?>