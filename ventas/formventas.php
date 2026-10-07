<?php
// Inicia o recupera la sesión para poder comprobar el rol del usuario.
session_start();
// Solo los usuarios administradores pueden registrar una venta.
if(!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador"){ die("Acceso denegado"); }
// El pedido se recibe por la URL mediante el parámetro GET "pedido".
if (isset($_GET['pedido'])) {
    $pedidos_id = $_GET['pedido'];
} else {
    // Sin el identificador del pedido no es posible mostrar sus productos.
    die("No se recibió el pedido.");
}

// Datos de conexión a la base de datos del proyecto.
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "shena";

// Se establece la conexión con MySQL usando la extensión mysqli.
$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

// Se detiene la ejecución si la conexión no pudo realizarse.
if($conn->connect_error) {
    die ("conexion fallida" . $conn->connect_error);
}

// Se consultan los códigos de productos y cantidades asociados al pedido.
$sqlCarrito = "SELECT productos_codigo, cantidad FROM carrito WHERE pedidos_id = '$pedidos_id'";
$resultadoCarrito = $conn->query($sqlCarrito);
?>

<!-- Estructura HTML de la página de registro de venta. -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Venta </title>
</head>
<body>

<!-- Contenedor principal con el detalle del pedido y el formulario de pago. -->
<article class="caja-formulario">

    <!-- Encabezado que identifica la sección y la acción disponible. -->
    <header class="caja-titulos">
        <h3 class="texto-saludo">Productos del pedido</h3>
        <h1 class="texto-rol">Registrar Venta</h1>
    </header>

    <!-- Tabla con los productos del pedido, su stock y la cantidad solicitada. -->
    <div class="caja-tabla">
        <table>
            <tr>
                <th>Producto</th>
                <th>Stock disponible</th>
                <th>Cantidad solicitada</th>
            </tr>

            <?php
            // Se recorren los productos del carrito para completar una fila por cada uno.
            while ($producto = $resultadoCarrito->fetch_assoc()) {
                $productos_id = $producto['productos_codigo'];
                $cantidad = $producto['cantidad'];

                // Se busca el nombre y el stock actual del producto en el catálogo.
                $sqlProductos = "SELECT nombre, stock FROM productos WHERE codigo = '$productos_id'";
                $resultadoProductos = $conn->query($sqlProductos);
                $datosProductos = $resultadoProductos->fetch_assoc();
            ?>

            <!-- Se muestran los datos del producto en la fila correspondiente. -->
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

    <!-- El formulario envía el pedido y el método de pago al proceso de registro. -->
    <form id="formCrearVenta" action="createventas.php" method="POST" class="caja-pago">

        <!-- Campo oculto para conservar el identificador del pedido al enviar el formulario. -->
        <input type="hidden" name="pedidos_id" value="<?php echo $pedidos_id; ?>">

        <!-- El administrador debe elegir cómo se pagará la venta. -->
        <div class="grupo-campo">
            <label>Método de Pago:</label>
            <select name="metodo" required>
                <option value="">Seleccione</option>
                <option value="Efectivo">Efectivo</option>
                <option value="QR">QR</option>
                <option value="Tarjeta">Tarjeta</option>
            </select>
        </div>

        <!-- Envía el formulario una vez que se haya seleccionado el método de pago. -->
        <button type="submit" class="boton-registrar">Registrar Venta</button>

    </form>
    <!-- Validación del formulario en el navegador mediante jQuery Validate. -->
    <script>
// Espera a que el documento esté listo antes de configurar la validación.
$(document).ready(function(){

    // Comprueba que el campo de método de pago no quede sin seleccionar.
    $("#formCrearVenta").validate({

        rules:{
            metodo:{
                required:true
            }
        },

        messages:{
            metodo:{
                required:"Debes seleccionar un método de pago"
            }
        }

    });

});
</script>

</article>

</body>
</html>

<?php
    // Se cierra la conexión con la base de datos al finalizar la página.
    $conn->close();
?>