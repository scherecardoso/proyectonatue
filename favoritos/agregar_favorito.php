
<?php

// Se inicia la sesión para verificar que el usuario haya iniciado sesión antes de agregar un producto a favoritos.
// Si no existe la variable CI dentro de la sesión, se lo redirige a la página de registro o login.
session_start();

// Verifica que el usuario esté autenticado; si no lo está, no puede acceder a esta acción.
if (!isset($_SESSION['CI'])) {
    // Redirige al usuario a la vista de registro para que inicie sesión.
    header("Location: ../usuario/09.register.php");
    exit();
}

// Se obtiene la cédula del usuario logueado desde la sesión.
$CI = $_SESSION['CI'];

// Se obtiene el código del producto que se quiere guardar como favorito.
// Este valor normalmente llega desde un formulario o un enlace con método POST.
$codigo = $_POST['codigo'];

// Se configuran los datos de conexión a la base de datos local.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se crea la conexión con MySQL utilizando la extensión mysqli.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se termina la ejecución y se muestra el error.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Se consulta si el usuario existe en la tabla usuario usando la CI almacenada en la sesión.
$sql = "SELECT * FROM usuario
        WHERE CI='$CI'";

$resultado = $conn->query($sql);

// Si la consulta falla, se corta la ejecución y se muestra el error.
if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

// Si no existe ningún usuario con esa CI, se detiene la operación por seguridad.
if ($resultado->num_rows == 0) {
    die("El usuario no existe en la base de datos.");
}

// Se verifica que el producto indicado realmente exista en la base de datos.
$sql = "SELECT * FROM productos
        WHERE codigo='$codigo'";

$resultado = $conn->query($sql);

// Si la consulta falla, se muestra el detalle del problema.
if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

// Si el producto no existe, no se puede agregar a favoritos.
if ($resultado->num_rows == 0) {
    die("El producto no existe en la base de datos.");
}

// Antes de insertar el favorito, se revisa si ese mismo producto ya fue agregado anteriormente por el mismo usuario.
// Esto evita duplicados en la tabla favoritos.
$sql = "SELECT * FROM favoritos
        WHERE ci='$CI'
        AND codigo='$codigo'";

$resultado = $conn->query($sql);

// Si la consulta falla, se informa el error.
if (!$resultado) {
    die("Error en la consulta: " . $conn->error);
}

// Si no existe un registro previo, entonces se guarda el producto como favorito.
if ($resultado->num_rows == 0) {

    // Inserta la relación entre el usuario y el producto en la tabla favoritos.
    $sql = "INSERT INTO favoritos (ci, codigo)
            VALUES ('$CI', '$codigo')";

    // Si la inserción falla, se muestra el error para saber qué ocurrió.
    if (!$conn->query($sql)) {
        die("Error al guardar favorito: " . $conn->error);
    }
}

// Se cierra la conexión para liberar recursos.
$conn->close();

// Después de guardar el favorito, el usuario vuelve a la vista de productos.
header("Location: ../pagina/03.productos.php");
exit();

?>
