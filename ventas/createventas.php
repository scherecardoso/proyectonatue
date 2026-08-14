<?php

session_start();

if(!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"],["administrador","vendedor"])){
    die("Acceso denegado");
}

$servidor = "localhost";
$nombre = "root";
$contraseña = "";
$BDnombre = "shena";

$conn = new mysqli($servidor, $nombre, $contraseña, $BDnombre);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// ==========================================
// RECIBIR DATOS
// ==========================================

$metodo = $_POST['metodo'] ?? "";

// Primero intenta recibirlo por POST
$pedidos_id = $_POST['pedidos_id'] ?? "";

// Si no viene por POST, usar el pedido de la sesión
if ($pedidos_id == "" && isset($_SESSION["pedido"])) {
    $pedidos_id = $_SESSION["pedido"];
}

$pedidos_id = (int)$pedidos_id;


// ==========================================
// VALIDAR DATOS
// ==========================================

if ($metodo == "" || $pedidos_id <= 0) {

    die("Faltan datos para registrar la venta.");

}

$estado = "Pendiente";


// ==========================================
// COMPROBAR QUE EXISTE EL PEDIDO
// ==========================================

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


// ==========================================
// CALCULAR TOTAL DEL PEDIDO
// ==========================================

$sqlTotal = "
    SELECT SUM(costototal) AS total
    FROM carrito
    WHERE pedidos_id = '$pedidos_id'
";

$resultado = $conn->query($sqlTotal);

if (!$resultado) {

    die("Error al calcular total: " . $conn->error);

}

$fila = $resultado->fetch_assoc();

$costototal = $fila['total'] ?? 0;

$costototal = (float)$costototal;


if ($costototal <= 0) {

    die("El carrito está vacío.");

}


// ==========================================
// COMPROBAR STOCK
// ==========================================

$sqlCarrito = "
    SELECT productos_codigo, cantidad
    FROM carrito
    WHERE pedidos_id = '$pedidos_id'
";

$resultadoCarrito = $conn->query($sqlCarrito);

if (!$resultadoCarrito) {

    die("Error al consultar carrito: " . $conn->error);

}


$hayStock = true;
$productoSinStock = "";


while ($productos = $resultadoCarrito->fetch_assoc()) {

    $productos_codigo = $productos['productos_codigo'];
    $cantidad = (int)$productos['cantidad'];


    // Buscar producto
    $sqlProductos = "
        SELECT nombre, stock
        FROM productos
        WHERE codigo = '$productos_codigo'
    ";

    $resultadoProductos = $conn->query($sqlProductos);


    if (!$resultadoProductos) {

        die("Error al buscar producto: " . $conn->error);

    }


    if ($resultadoProductos->num_rows == 0) {

        die("No se encontró el producto: " . $productos_codigo);

    }


    $datosProductos = $resultadoProductos->fetch_assoc();

    $stock = (int)$datosProductos['stock'];
    $nombreProductos = $datosProductos['nombre'];


    // Comprobar stock
    if ($stock < $cantidad) {

        $hayStock = false;

        $productoSinStock = $nombreProductos;

        break;

    }

}


// ==========================================
// SI NO HAY STOCK SUFICIENTE
// ==========================================

if (!$hayStock) {

    echo "No hay suficiente stock del producto: "
         . htmlspecialchars($productoSinStock);

    $conn->close();

    exit;
}


// ==========================================
// CREAR VENTA
// ==========================================

$sql = "
    INSERT INTO ventas
    (estado, metodo, costo, pedidos_id)
    VALUES
    ('$estado', '$metodo', '$costototal', '$pedidos_id')
";


if (!$conn->query($sql)) {

    die("Error al registrar venta: " . $conn->error);

}


// ==========================================
// DESCONTAR STOCK
// ==========================================

$sqlCarrito = "
    SELECT productos_codigo, cantidad
    FROM carrito
    WHERE pedidos_id = '$pedidos_id'
";

$resultadoCarrito = $conn->query($sqlCarrito);

if (!$resultadoCarrito) {

    die("Error al volver a consultar carrito: " . $conn->error);

}


while ($productos = $resultadoCarrito->fetch_assoc()) {

    $productos_codigo = $productos['productos_codigo'];
    $cantidad = (int)$productos['cantidad'];


    $sqlStock = "
        UPDATE productos
        SET stock = stock - $cantidad
        WHERE codigo = '$productos_codigo'
    ";


    if (!$conn->query($sqlStock)) {

        die(
            "Error actualizando stock del producto "
            . $productos_codigo
            . ": "
            . $conn->error
        );

    }

}


// ==========================================
// ACTUALIZAR ESTADO DEL PEDIDO
// ==========================================

$sqlPedido = "
    UPDATE pedidos
    SET estado = 'Pendiente'
    WHERE id = '$pedidos_id'
";


if (!$conn->query($sqlPedido)) {

    die(
        "Venta creada, pero no se pudo actualizar el pedido: "
        . $conn->error
    );

}


// ==========================================
// GUARDAR ID DE LA VENTA
// ==========================================

$_SESSION["venta"] = $conn->insert_id;


// ==========================================
// IR A VENTAS
// ==========================================

$conn->close();

header("Location: readventas.php");
exit();

?>