
<?php
// Se inicia la sesión para verificar que el usuario tenga permisos de acceso.
// Solo pueden entrar vendedores y administradores, en caso contrario se redirige al login.
session_start();

// Validación de permisos: si el usuario no tiene el rol permitido, se bloquea el acceso.
if ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador') {
    // Redirige al formulario de inicio de sesión si el usuario no tiene permisos.
    header("Location: ../pagina/login.php");
    exit();
}

// Datos de conexión a la base de datos local.
// Estas credenciales corresponden a la BD "shena" del proyecto.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se crea la conexión a la base de datos usando MySQLi.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se termina la ejecución del script y se muestra el error.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Se reciben los datos enviados desde el formulario de edición.
// $codigo_original guarda el código anterior para ubicar el registro a actualizar.
$codigo_original = $_POST['codigo_original'];
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

// Se arma la consulta SQL para actualizar el producto seleccionado.
// Se actualizan los campos principales: código, nombre, descripción, precio, costo y stock.
$sql = "UPDATE productos SET
codigo='$codigo',
nombre='$nombre',
descripcion='$descripcion',
precio='$precio',
costo='$costo',
stock='$stock'
WHERE codigo='$codigo_original'";

// Se ejecuta la consulta SQL.
// Si la actualización fue exitosa, se redirige según el tipo de usuario.
if ($conn->query($sql) === TRUE) {

    // Si el usuario es vendedor, vuelve a la vista de lectura de productos.
    if ($_SESSION['rol'] == 'vendedor') {
        header("Location: ../productos/22.readproductos.php");
        exit();
    }

    // Si el usuario es administrador, lo devuelve a la gestión de productos.
    if ($_SESSION['rol'] == 'administrador') {
        header("Location: ../admin/gestionproductos.php");
        exit();
    }

} else {
    // Si la actualización falla, se muestra el mensaje del error de MySQL.
    echo "Error: " . $conn->error;
}

// Se cierra la conexión a la base de datos para liberar recursos.
$conn->close();
?>
