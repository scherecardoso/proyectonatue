<?php

// Inicia una sesión nueva o recupera la sesión existente para identificar al usuario.
session_start();

// Verifica que el usuario haya iniciado sesión antes de modificar sus favoritos.
if (!isset($_SESSION['CI'])) {
    // Si no hay un identificador de usuario en la sesión, redirige a autenticación.
    header("Location: ../pagina/23.autenticar.php");
    exit();
}

// Guarda el identificador del usuario autenticado.
$CI = $_SESSION['CI'];

// Lee el código del producto enviado por el formulario mediante POST.
$codigo = $_POST['codigo'];

// Datos utilizados para conectarse con la base de datos local del proyecto.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Establece la conexión con el servidor MySQL y la base de datos indicada.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, termina el proceso e informa el error.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Prepara la instrucción para quitar de favoritos el producto indicado
// perteneciente al usuario que inició sesión.
$sql = "DELETE FROM favoritos
        WHERE CI='$CI'
        AND codigo='$codigo'";

// Ejecuta la eliminación en la base de datos.
$conn->query($sql);

// Después de procesar la solicitud, vuelve a mostrar la lista de favoritos.
header("Location: favoritos.php");
// Detiene el script para que no se procese nada más tras la redirección.
exit();

?>