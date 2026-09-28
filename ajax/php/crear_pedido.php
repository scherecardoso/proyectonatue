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



$nombre = $_SESSION['nombre'] ?? "";
$telefono = $datos["telefono"] ?? "";
$direccion = $datos["direccion"] ?? "";
$metodoPago = $datos["metodoPago"] ?? "";



if($nombre == ""){

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se encontró el usuario en la sesión"
    ]);

    exit;

}




if($telefono == "" || $direccion == "" || $metodoPago == ""){

    echo json_encode([
        "ok" => false,
        "mensaje" => "Complete todos los datos del pedido"
    ]);

    exit;

}




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