<?php

// Se inicia la sesión para verificar que el usuario tenga permisos para registrar ventas.
// Solo pueden acceder administradores y vendedores, según la validación de roles.
session_start();

// Se valida que exista una sesión activa y que el rol del usuario esté permitido.
// Si no cumple con estos requisitos, se corta la ejecución para evitar accesos no autorizados.
if(!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"],["administrador","vendedor"])){
    die("Acceso denegado");
}

// Datos de conexión a la base de datos local del proyecto.
// Estos valores apuntan a la base de datos "shena" que contiene pedidos, carrito, productos y ventas.
$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "shena";

// Se crea la conexión a MySQL usando mysqli.
$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

// Si la conexión falla, se detiene la ejecución inmediatamente.
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// Se obtiene el método de pago enviado desde el formulario.
// Ejemplos posibles: efectivo, tarjeta, transferencia, QR, etc.
$metodo = $_POST['metodo'] ?? "";

// Se toma el ID del pedido enviado por el formulario.
// Si no llega, se intenta usar el valor guardado en la sesión como respaldo.
$pedidos_id = $_POST['pedidos_id'] ?? "";


// Si no se envió un pedido y existe uno guardado en la sesión, se usa ese.
// Esto ayuda a que el flujo siga funcionando aunque el formulario no lo envíe explícitamente.
if ($pedidos_id == "" && isset($_SESSION["pedido"])) {
    $pedidos_id = $_SESSION["pedido"];
}

// Se convierte a entero para evitar inyecciones o valores inválidos.
$pedidos_id = (int)$pedidos_id;



// Se valida que el método de pago y el pedido sean datos necesarios para registrar la venta.
// Si falta alguno, se aborta la operación para no guardar información incompleta.
if ($metodo == "" || $pedidos_id <= 0) {

    die("Faltan datos para registrar la venta.");

}

// Estado inicial de la venta cuando se registra.
// Se usa un texto claro para identificar el proceso en la base de datos.
$estado = "En proceso";

// Fecha actual en formato YYYY-MM-DD, que se guarda con la venta.
$fecha = date("Y-m-d");


// Primero se valida que el pedido exista realmente en la tabla pedidos.
// Si el id no coincide con ninguna fila, la venta no puede registrarse.
$sqlPedido = "
    SELECT id
    FROM pedidos
    WHERE id = '$pedidos_id'
";

$resultadoPedido = $conn->query($sqlPedido);

if (!$resultadoPedido) {

    die("Error al comprobar el pedido: " . $conn->error);

}

if ($resultadoPedido->num_rows == 0) {

    die("El pedido no existe.");

}


// Se calcula el total de la venta sumando los costos totales de todos los productos en carrito.
// La suma se hace sobre la columna costototal de la tabla carrito, asociado al pedido actual.
$sqlTotal = "
    SELECT SUM(costototal) AS total
    FROM carrito
    WHERE pedidos_id = '$pedidos_id'
";

$resultado = $conn->query($sqlTotal);

if (!$resultado) {

    die("Error al calcular total: " . $conn->error);

}

// Se obtiene el resultado de la suma.
$fila = $resultado->fetch_assoc();

// Si no hubo filas o la suma es null, el total se toma como 0.
$costototal = $fila['total'] ?? 0;

// Se fuerza como número decimal para manejar valores monetarios.
$costototal = (float)$costototal;


// Si el total es cero o menor, significa que el carrito está vacío.
// No tiene sentido crear una venta sin productos.
if ($costototal <= 0) {

    die("El carrito está vacío.");

}


// Se consulta nuevamente el contenido del carrito para verificar cada producto y validar stock.
// Es importante revisar cada producto antes de registrar la venta para no vender algo no disponible.
$sqlCarrito = "
    SELECT productos_codigo, cantidad
    FROM carrito
    WHERE pedidos_id = '$pedidos_id'
";

$resultadoCarrito = $conn->query($sqlCarrito);

if (!$resultadoCarrito) {

    die("Error al consultar carrito: " . $conn->error);

}


// Variables para controlar si hay suficiente stock en todo el carrito.
$hayStock = true;
$productoSinStock = "";


// Recorremos cada producto del carrito para comparar la cantidad pedida con el stock disponible.
while ($productos = $resultadoCarrito->fetch_assoc()) {

    $productos_codigo = $productos['productos_codigo'];
    $cantidad = (int)$productos['cantidad'];


    // Buscar el producto en la tabla productos usando su código.
    $sqlProductos = "
        SELECT nombre, stock
        FROM productos
        WHERE codigo = '$productos_codigo'
    ";

    $resultadoProductos = $conn->query($sqlProductos);


    if (!$resultadoProductos) {

        die("Error al buscar producto: " . $conn->error);

    }


    // Si el producto no existe en la base de datos, se cancela la venta.
    if ($resultadoProductos->num_rows == 0) {

        die("No se encontró el producto: " . $productos_codigo);

    }


    // Se obtienen los datos del producto encontrado.
    $datosProductos = $resultadoProductos->fetch_assoc();

    $stock = (int)$datosProductos['stock'];
    $nombreProductos = $datosProductos['nombre'];


    // Si la cantidad solicitada supera el stock actual, se marca la falla.
    // Se guarda el nombre del producto para mostrar un aviso más claro al usuario.
    if ($stock < $cantidad) {

        $hayStock = false;

        $productoSinStock = $nombreProductos;

        break;

    }

}


// Si no hay stock suficiente para vender el pedido, se informa al usuario y se termina la ejecución.
// Aquí no se registra la venta ni se descuenta inventario, para evitar inconsistencias.
if (!$hayStock) {

    echo "No hay suficiente stock del producto: "
         . htmlspecialchars($productoSinStock);

    $conn->close();

    exit;
}



// Una vez validado el pedido y el stock, se guarda la venta en la tabla ventas.
// La tabla ventas registra la información general de la transacción.
$sql = "
    INSERT INTO ventas
    (estado, metodo, costo, pedidos_id, fecha)
    VALUES
    ('$estado', '$metodo', '$costototal', '$pedidos_id', '$fecha')
";


// Si la inserción falla, se aborta la operación y se muestra el detalle del error.
if (!$conn->query($sql)) {

    die("Error al registrar venta: " . $conn->error);

}


// Después de crear la venta, se vuelve a consultar el carrito para descontar stock.
// Se hace otra vez porque la primera consulta ya fue usada para validar disponibilidad.
$sqlCarrito = "
    SELECT productos_codigo, cantidad
    FROM carrito
    WHERE pedidos_id = '$pedidos_id'
";

$resultadoCarrito = $conn->query($sqlCarrito);

if (!$resultadoCarrito) {

    die("Error al volver a consultar carrito: " . $conn->error);

}


// Se recorre cada línea del carrito para restar la cantidad vendida del stock del producto.
while ($productos = $resultadoCarrito->fetch_assoc()) {

    $productos_codigo = $productos['productos_codigo'];
    $cantidad = (int)$productos['cantidad'];


    // Se actualiza el stock del producto restando exactamente la cantidad vendida.
    $sqlStock = "
        UPDATE productos
        SET stock = stock - $cantidad
        WHERE codigo = '$productos_codigo'
    ";


    // Si falla la actualización del stock, se corta la ejecución para detectar el problema.
    if (!$conn->query($sqlStock)) {

        die(
            "Error actualizando stock del producto "
            . $productos_codigo
            . ": "
            . $conn->error
        );

    }

}



// Se actualiza el estado del pedido para reflejar que ya fue procesado como venta.
// El pedido sigue en "En proceso" según el flujo actual del sistema.
$sqlPedido = "
    UPDATE pedidos
    SET estado = 'En proceso'
    WHERE id = '$pedidos_id'
";


// Si no se puede actualizar el pedido, se muestra una advertencia porque la venta sí se creó.
if (!$conn->query($sqlPedido)) {

    die(
        "Venta creada, pero no se pudo actualizar el pedido: "
        . $conn->error
    );

}

// Se guarda el ID de la venta recién creada en sesión para poder consultarla luego.
// Esto permite reutilizar la última venta en otras pantallas o procesos.
$_SESSION["venta"] = $conn->insert_id;


// Se cierra la conexión a la base de datos para liberar recursos.
$conn->close();

// Redirige al usuario a la vista de ventas para ver el registro generado.
header("Location: readventas.php");
exit();

?>