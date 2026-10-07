<?php 

// Se inicia la sesión para poder leer el nombre del cliente y guardar el identificador del pedido.
// Se inicia la sesión para identificar al usuario que está haciendo el pedido.
// Así se puede usar el nombre del cliente guardado en la sesión y asociarlo al registro del pedido.
session_start();

// Se carga la conexión a MySQL que se utilizará para guardar el pedido.
// Se incluye el archivo de conexión a la base de datos.
// Este archivo permite abrir la conexión con MySQL para poder insertar el pedido en la tabla pedidos.
require("conexion.php");

// Las respuestas de este endpoint se envían como JSON para que el cliente pueda procesarlas.
header("Content-Type: application/json");

// Se lee el contenido enviado en el cuerpo de la solicitud HTTP y se convierte el JSON a un arreglo asociativo.
$datos = json_decode(
    file_get_contents("php://input"),
    true
);

// Si el cuerpo está vacío o no contiene datos JSON utilizables, se devuelve un mensaje de error.
if(!$datos){

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se recibieron datos"
    ]);

    exit;

}


// El nombre del cliente se toma de la sesión; teléfono, dirección y método de pago vienen en la solicitud.
// El operador ?? usa una cadena vacía si alguno de estos valores no fue enviado o no está definido.
$nombre = $_SESSION['nombre'] ?? "";
$telefono = $datos["telefono"] ?? "";
$direccion = $datos["direccion"] ?? "";
$metodoPago = $datos["metodoPago"] ?? "";



// Se requiere un cliente identificado en la sesión para asociar el pedido con su nombre.
if($nombre == ""){

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se encontró el usuario en la sesión"
    ]);

    exit;

}


// Se verifica que los tres datos obligatorios del pedido hayan sido proporcionados.
if($telefono == "" || $direccion == "" || $metodoPago == ""){

    echo json_encode([
        "ok" => false,
        "mensaje" => "Complete todos los datos del pedido"
    ]);

    exit;

}


// Se construye la instrucción SQL para insertar el pedido en la tabla pedidos.
// La fecha se establece con la fecha y hora actuales; el pedido inicia pendiente y sin vendedor asignado.
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


// Se ejecuta la inserción; el resultado determina cuál respuesta JSON se devuelve.
if($conn->query($sql)){

    // MySQL proporciona el identificador generado automáticamente para la fila recién insertada.
    $idPedido = $conn->insert_id;

    // Se conserva el identificador del pedido en la sesión para su uso posterior.
    $_SESSION["pedido"] = $idPedido;

    // Se confirma el registro y se envía el identificador del pedido y el valor guardado en la sesión.
    echo json_encode([
        "ok" => true,
        "pedido" => $idPedido,
        "sesion" => $_SESSION["pedido"]
    ]);

}else{

    // Si MySQL no pudo insertar el pedido, se devuelve el mensaje de error de la conexión.
    echo json_encode([
        "ok" => false,
        "mensaje" => $conn->error
    ]);

}

// Se libera la conexión a la base de datos al finalizar la operación.
$conn->close();

?>