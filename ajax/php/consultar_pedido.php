<?php

require("conexion.php");

// Validar que el id exista y no esté vacío
if (!isset($_POST["id"]) || empty(trim($_POST["id"]))) {
    http_response_code(400);
    echo json_encode([
        "ok" => false,
        "error" => "El número de pedido es obligatorio"
    ]);
    exit;
}

$id = trim($_POST["id"]);

// Validar que sea un número
if (!is_numeric($id) || $id <= 0) {
    http_response_code(400);
    echo json_encode([
        "ok" => false,
        "error" => "El número de pedido debe ser válido"
    ]);
    exit;
}

// Usar prepared statements para evitar SQL Injection
$sql = "SELECT * FROM pedidos WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Error en la base de datos"
    ]);
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $pedido = $resultado->fetch_assoc();
    
    echo json_encode([
        "ok" => true,
        "pedido" => $pedido
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "error" => "Pedido no encontrado"
    ]);
}

$stmt->close();
$conn->close();
?>