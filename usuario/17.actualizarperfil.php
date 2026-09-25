<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario' || empty($_SESSION['CI'])) {
    header('Location: ../pagina/login.php');
    exit();
}

$nombre = trim($_POST['nombre'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$celular = trim($_POST['celular'] ?? '');
$CI = (string) $_SESSION['CI'];

if ($nombre === '' || $direccion === '' || $celular === '') {
    die('Todos los campos son obligatorios.');
}

$conn = new mysqli('localhost', 'root', '', 'shena');

if ($conn->connect_error) {
    die('Conexión fallida: ' . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

$stmtAnterior = $conn->prepare(
    'SELECT nombre 
     FROM usuario 
     WHERE CI = ? AND rol = ?'
);

$rol = 'usuario';

$stmtAnterior->bind_param(
    'ss',
    $CI,
    $rol
);

$stmtAnterior->execute();
$resultadoAnterior = $stmtAnterior->get_result();
$usuarioAnterior = $resultadoAnterior->fetch_assoc();
$stmtAnterior->close();
if (!$usuarioAnterior) {
    $conn->close();
    die('Usuario no encontrado.');
}

$nombreAnterior = $usuarioAnterior['nombre'];
$conn->begin_transaction();

try {

    $stmt = $conn->prepare(
        'UPDATE usuario 
         SET nombre = ?, direccion = ?, celular = ? 
         WHERE CI = ? AND rol = ?'
    );

    $stmt->bind_param(
        'sssss',
        $nombre,
        $direccion,
        $celular,
        $CI,
        $rol
    );

    if (!$stmt->execute()) {
        throw new Exception('No se pudo actualizar la información.');
    }

    $stmt->close();

    if ($nombreAnterior !== $nombre) {

        $stmtPedidos = $conn->prepare(
            'UPDATE pedidos 
             SET nombre = ? 
             WHERE nombre = ?'
        );

        $stmtPedidos->bind_param(
            'ss',
            $nombre,
            $nombreAnterior
        );

        if (!$stmtPedidos->execute()) {
            throw new Exception('No se pudieron actualizar los pedidos.');
        }

        $stmtPedidos->close();
    }

    $conn->commit();
    $_SESSION['nombre'] = $nombre;
    $_SESSION['direccion'] = $direccion;
    $_SESSION['celular'] = $celular;


    $conn->close();


    header('Location: ../usuario/perfilUser.php');
    exit();


} catch (Exception $e) {


    $conn->rollback();

    $conn->close();

    die('No se pudo actualizar la información.');
}
?>