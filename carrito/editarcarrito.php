<?php
session_start();
$conn = new mysqli("localhost", "root", "", "shena");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


if (
    !isset($_POST["idPedido"]) ||
    !isset($_POST["codigo"]) ||
    !isset($_POST["cantidad"]) ||
    !isset($_POST["precio"])
) {
    die("Faltan datos.");
}

$idpedido = intval($_POST["idPedido"]);
$codigo = intval($_POST["codigo"]);
$cantidad = intval($_POST["cantidad"]);
$precio = floatval($_POST["precio"]);


if ($cantidad <= 0) {
    die("La cantidad debe ser mayor a 0.");
}

if ($precio < 0) {
    die("Precio inválido.");
}

$total = $cantidad * $precio;
$sql = "UPDATE carritoSET cantidad = '$cantidad',costototal = '$total'WHERE pedidos_id = '$idpedido'AND productos_codigo = '$codigo'";
if ($conn->query($sql)) {
    header("Location: micarrito.php?idPedido=" . $idpedido);
    exit();
} else {
    echo "Error al actualizar: " . $conn->error;
}

$conn->close();

?>