<?php 

session_start();

require("conexion.php");

header("Content-Type: application/json");

$datos = json_decode(
    file_get_contents("php://input"),
    true
);

if(!$datos){

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibieron datos"
    ]);

    exit;

}


/* =========================
   DATOS DEL CLIENTE
========================= */

$nombre = $_SESSION['nombre'] ?? "";
$telefono = $datos["telefono"] ?? "";
$direccion = $datos["direccion"] ?? "";
$metodoPago = $datos["metodoPago"] ?? "";


/* =========================
   VALIDAR SESIÓN
========================= */

if($nombre == ""){

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se encontró el usuario en la sesión"
    ]);

    exit;

}


/* =========================
   VALIDAR DATOS
========================= */

if($telefono == "" || $direccion == "" || $metodoPago == ""){

    echo json_encode([
        "ok" => false,
        "mensaje" => "Complete todos los datos del pedido"
    ]);

    exit;

}


/* =========================
   CREAR PEDIDO
========================= */

$sql = "
INSERT INTO pedidos
(
    nombre,
    fecha,
    estado,
    vendedor,
    telefono,
    direccion,
    metodoPago
)
VALUES
(
    '$nombre',
    NOW(),
    'Pendiente',
    'Sin asignar',
    '$telefono',
    '$direccion',
    '$metodoPago'
)
";


if($conn->query($sql)){

    $idPedido = $conn->insert_id;

    /* Guardar el pedido actual */
    $_SESSION["pedido"] = $idPedido;

    echo json_encode([
        "ok" => true,
        "pedido" => $idPedido,
        "sesion" => $_SESSION["pedido"]
    ]);

}else{

    echo json_encode([
        "ok" => false,
        "mensaje" => $conn->error
    ]);

}

$conn->close();

?>