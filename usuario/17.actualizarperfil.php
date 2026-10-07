<?php
// Inicia la sesión para comprobar la identidad y el rol del usuario actual.
session_start();

// Solo los usuarios con rol y CI registrados pueden actualizar su perfil.
// Si falta alguno de estos datos, se redirige al inicio de sesión.
if (!isset($_SESSION['rol']) || empty($_SESSION['CI'])) {
    header('Location: ../pagina/login.php');
    exit();
}

// Obtiene los datos enviados por el formulario y elimina espacios al inicio y al final.
// El CI se toma de la sesión para que el usuario no pueda elegir qué cuenta modificar.
$nombre = trim($_POST['nombre'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$celular = trim($_POST['celular'] ?? '');
$CI = (string) $_SESSION['CI'];

// Impide continuar si alguno de los campos obligatorios está vacío.
if ($nombre === '' || $direccion === '' || $celular === '') {
    die('Todos los campos son obligatorios.');
}

// Abre la conexión con la base de datos del proyecto.
$conn = new mysqli('localhost', 'root', '', 'shena');

// Finaliza el proceso si no fue posible conectarse con la base de datos.
if ($conn->connect_error) {
    die('Conexión fallida: ' . $conn->connect_error);
}

// Define la codificación de caracteres para manejar correctamente textos en español.
$conn->set_charset('utf8mb4');

// Busca el nombre actual del usuario; se utilizará para actualizar sus pedidos
// asociados si el nombre cambia.
$stmtAnterior = $conn->prepare(
    'SELECT nombre 
     FROM usuario 
     WHERE CI = ?'
);

// Vincula el CI como parámetro para evitar insertar directamente datos en la consulta.
$stmtAnterior->bind_param(
    's',
    $CI
);

// Ejecuta la consulta y obtiene los datos encontrados.
$stmtAnterior->execute();
$resultadoAnterior = $stmtAnterior->get_result();
$usuarioAnterior = $resultadoAnterior->fetch_assoc();
// Libera el recurso de la consulta ya completada.
$stmtAnterior->close();

// Si no existe una cuenta con ese CI, cierra la conexión y muestra un error.
if (!$usuarioAnterior) {
    $conn->close();
    die('Usuario no encontrado.');
}

// Conserva el nombre anterior para compararlo con el nuevo más adelante.
$nombreAnterior = $usuarioAnterior['nombre'];

// Inicia una transacción para que la actualización del usuario y de sus pedidos
// se guarde de forma conjunta o se revierta si ocurre un error.
$conn->begin_transaction();

try {

    // Prepara la actualización de los datos personales del usuario identificado por CI.
    $stmt = $conn->prepare(
        'UPDATE usuario 
         SET nombre = ?, direccion = ?, celular = ? 
         WHERE CI = ?'
    );

    // Asocia los valores del formulario y el CI a los marcadores de la consulta.
    $stmt->bind_param(
        'ssss',
        $nombre,
        $direccion,
        $celular,
        $CI
    );

    // Si falla la actualización, genera una excepción para revertir la transacción.
    if (!$stmt->execute()) {
        throw new Exception('No se pudo actualizar la información.');
    }

    // Cierra la consulta de actualización del usuario.
    $stmt->close();

    // Solo actualiza los pedidos cuando el usuario cambió su nombre.
    if ($nombreAnterior !== $nombre) {

        // Mantiene sincronizado el nombre guardado en los pedidos del usuario.
        $stmtPedidos = $conn->prepare(
            'UPDATE pedidos 
             SET nombre = ? 
             WHERE nombre = ?'
        );

        // Vincula el nuevo nombre y el nombre anterior usados para localizar los pedidos.
        $stmtPedidos->bind_param(
            'ss',
            $nombre,
            $nombreAnterior
        );

        // Si falla la actualización de pedidos, se revierte también el cambio del perfil.
        if (!$stmtPedidos->execute()) {
            throw new Exception('No se pudieron actualizar los pedidos.');
        }

        // Cierra la consulta de actualización de pedidos.
        $stmtPedidos->close();
    }

    // Confirma y guarda todos los cambios realizados durante la transacción.
    $conn->commit();

    // Actualiza los datos de la sesión para que reflejen inmediatamente el perfil nuevo.
    $_SESSION['nombre'] = $nombre;
    $_SESSION['direccion'] = $direccion;
    $_SESSION['celular'] = $celular;

    // Guarda el rol antes de cerrar la conexión; se usa para elegir la página de destino.
    $rol = $_SESSION['rol'];

    // Cierra la conexión antes de redirigir al usuario.
    $conn->close();

    // Envía a los administradores a su perfil correspondiente.
    if ($rol == 'administrador') {
        header('Location: ../perfil/perfiladmin.php');
        exit();
    }



    // Envía a los usuarios regulares a su página de perfil.
    if ($rol == 'usuario') {
        header('Location: ../usuario/perfilUser.php');
        exit();
    }

} catch (Exception $e) {

    // Revierte los cambios parciales si ocurre un error durante la transacción.
    $conn->rollback();
    // Cierra la conexión y presenta un mensaje general sin exponer detalles internos.
    $conn->close();

    die('No se pudo actualizar la información.');
}
?>