
<?php
// Inicia o recupera la sesión para consultar el rol del usuario actual.
session_start();

// Solo los vendedores y administradores tienen permiso para eliminar productos.
// Si el usuario no tiene uno de esos roles, se le envía a la página de inicio de sesión.
if ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador') {
    header("Location: ../pagina/login.php");
    exit();
}

// Datos de conexión para acceder a la base de datos del proyecto.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se establece la conexión con MySQL usando los datos definidos arriba.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si no se pudo conectar, se detiene el proceso y se informa del problema.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Se obtiene de la URL el código del producto que se desea eliminar.
$codigo = $_GET['codigo'];

// Se prepara la consulta SQL para borrar de la tabla el producto con ese código.
$sql = "DELETE FROM productos WHERE codigo=$codigo";

// Se ejecuta la eliminación y se comprueba si la consulta tuvo éxito.
if ($conn->query($sql) === TRUE) {

    // Después de eliminar, cada tipo de usuario vuelve a la lista que le corresponde.
    if ($_SESSION['rol'] == 'vendedor') {
        header("Location: ../productos/22.readproductos.php");
        exit();
    }

    // Los administradores regresan a la página de gestión de productos.
    if ($_SESSION['rol'] == 'administrador') {
        header("Location: ../admin/gestionproductos.php");
        exit();
    }

} else {
    // Si ocurre un error al eliminar, se muestran la consulta y el detalle del error.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Se cierra la conexión a la base de datos al finalizar el proceso.
$conn->close();
?>
