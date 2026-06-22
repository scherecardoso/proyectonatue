<?php

session_start();

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (
    !isset($_POST["codigo"]) ||
    !isset($_POST["cantidad"]) ||
    !isset($_POST["precio"])
) {
    die("Faltan datos.");
}

$codigo = intval($_POST["codigo"]);
$cantidad = intval($_POST["cantidad"]);
$precio = floatval($_POST["precio"]);

if ($cantidad <= 0) {
    die("La cantidad debe ser mayor a cero.");
}

if ($precio < 0) {
    die("Precio inválido.");
}


if (!isset($_SESSION['nombre']) || trim($_SESSION['nombre']) === "") {

    header("Location: ../usuario/09.register.php");
    exit();
}

$nombre = $conn->real_escape_string($_SESSION['nombre']);

$buscarPedido = "
SELECT id
FROM pedidos
WHERE nombre='$nombre'
AND estado='En Proceso'
LIMIT 1
";

$resPedido = $conn->query($buscarPedido);

if ($resPedido && $resPedido->num_rows > 0) {

    $pedido = $resPedido->fetch_assoc();
    $idpedido = intval($pedido['id']);

} else {

    $fecha = date("Y-m-d");

    $crearPedido = "
    INSERT INTO pedidos(nombre, fecha, estado, vendedor)
    VALUES('$nombre', '$fecha', 'En Proceso', 'Administrador')
    ";

    if (!$conn->query($crearPedido)) {
        die("Error al crear pedido: " . $conn->error);
    }

    $idpedido = $conn->insert_id;
}

$total = $cantidad * $precio;


$verificar = "
SELECT cantidad
FROM carrito
WHERE productos_codigo = $codigo
AND pedidos_id = $idpedido
";

$resultado = $conn->query($verificar);

if ($resultado && $resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $nuevaCantidad = intval($fila["cantidad"]) + $cantidad;
    $nuevoTotal = $nuevaCantidad * $precio;

    $sql = "
    UPDATE carrito
    SET cantidad = '$nuevaCantidad',
        costototal = '$nuevoTotal'
    WHERE productos_codigo = '$codigo'
    AND pedidos_id = '$idpedido'
    ";

} else {

    $sql = "
    INSERT INTO carrito
    (productos_codigo, pedidos_id, cantidad, costototal)
    VALUES
    ('$codigo', '$idpedido', '$cantidad', '$total')
    ";
}

if ($conn->query($sql)) {

    header("Location: micarrito.php?idPedido=" . $idpedido);
    exit();

} else {

    echo "Error: " . $conn->error;
}

$conn->close();

?>