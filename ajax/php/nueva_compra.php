<?php

session_start();

header("Content-Type: application/json");

// Eliminar el pedido activo
unset($_SESSION["pedido"]);

echo json_encode([
    "ok" => true
]);

?>