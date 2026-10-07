<?php
// Este archivo verifica la sesión del usuario y comprueba si su cuenta está bloqueada.

// Si no hay un CI guardado en la sesión, el usuario no está identificado.
// Se redirige a la página de registro y se detiene la ejecución.
if (!isset($_SESSION['CI'])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

// Se obtiene de la sesión el CI del usuario actual.
$CI = $_SESSION['CI'];

// Datos de conexión a la base de datos local del proyecto.
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

// Se establece la conexión con MySQL utilizando los datos anteriores.
$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

// Se consulta el estado de la cuenta asociada al CI de la sesión.
$sql = "SELECT estado FROM usuario WHERE CI = $CI";
// Se ejecuta la consulta para poder revisar si el usuario existe y su estado.
$resultado = $conn->query($sql);

// Se continúa solo si la consulta encontró al menos un usuario.
if ($resultado->num_rows > 0) {

    // Se obtiene la información encontrada como un arreglo asociativo.
    $fila = $resultado->fetch_assoc();

    // Si el estado indica que la cuenta está bloqueada, se guarda esa condición
    // en la sesión para que también pueda consultarse en la página de destino.
    if ($fila['estado'] == "bloqueado") {

        $_SESSION['estado'] = "bloqueado";

        // Se envía al usuario a la página que muestra la información del bloqueo.
        // Se detiene el script para evitar que continúe después de la redirección.
        header("Location: ../admin/verbloqueo.php");
        exit();
    }
}

// Si no se realizó una redirección, se cierra la conexión a la base de datos.
$conn->close();

?>