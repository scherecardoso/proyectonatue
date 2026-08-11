<?php

session_start();

// Eliminar el pedido activo
unset($_SESSION["pedido"]);

echo json_encode([
    "ok" => true
]);

?>