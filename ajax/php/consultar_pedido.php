<?php

// Se incluye el archivo de conexión a la base de datos.
// Este archivo normalmente contiene la variable $conn con la conexión activa a MySQL.
require("conexion.php");

// Se valida que el campo "id" haya llegado por POST.
// Si no existe o si viene vacío, se responde con un error 400.
if (!isset($_POST["id"]) || empty(trim($_POST["id"]))) {
    // http_response_code(400) indica que la solicitud es incorrecta.
    http_response_code(400);

    // Se devuelve un JSON con el formato esperado por el cliente.
    echo json_encode([
        "ok" => false,
        "error" => "El número de pedido es obligatorio"
    ]);

    // Se detiene la ejecución del script para no seguir procesando.
    exit;
}

// Se limpia el valor recibido para evitar espacios en blanco al inicio o final.
$id = trim($_POST["id"]);

// Se valida que el id sea numérico y positivo.
// Si no lo es, también se devuelve un error 400 porque el pedido no es válido.
if (!is_numeric($id) || $id <= 0) {
    http_response_code(400);
    echo json_encode([
        "ok" => false,
        "error" => "El número de pedido debe ser válido"
    ]);
    exit;
}

// Se prepara la consulta SQL para buscar un pedido por su identificador.
// El símbolo ? se usa como parámetro para prevenir inyección SQL.
$sql = "SELECT * FROM pedidos WHERE id = ?";

// Se prepara la sentencia SQL con la conexión actual.
$stmt = $conn->prepare($sql);

// Si la preparación falla, significa que hubo un problema en la consulta o conexión.
if (!$stmt) {
    // Se responde con un error 500, que indica error interno del servidor.
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => "Error en la base de datos"
    ]);
    exit;
}

// Se vincula el valor $id al parámetro ? de la consulta.
// "i" indica que el tipo es entero (integer).
$stmt->bind_param("i", $id);

// Se ejecuta la consulta preparada.
$stmt->execute();

// Se obtiene el resultado de la consulta para poder leer los datos.
$resultado = $stmt->get_result();

// Si la consulta encontró al menos una fila, significa que existe el pedido.
if ($resultado->num_rows > 0) {
    // Se obtiene la fila como un arreglo asociativo.
    // Ejemplo: ["id" => 12, "cliente" => "Ana", ...]
    $pedido = $resultado->fetch_assoc();

    // Se devuelve un JSON exitoso con el pedido encontrado.
    echo json_encode([
        "ok" => true,
        "pedido" => $pedido
    ]);
} else {
    // Si no hay filas, entonces no existe ese pedido con ese ID.
    echo json_encode([
        "ok" => false,
        "error" => "Pedido no encontrado"
    ]);
}

// Se libera la sentencia preparada para evitar recursos abiertos.
$stmt->close();

// Se cierra la conexión a la base de datos.
$conn->close();
?>
