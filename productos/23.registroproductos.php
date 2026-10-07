<?php
// Inicia o recupera la sesión para consultar el rol del usuario actual.
session_start();

// Solo vendedores y administradores pueden registrar productos.
// Si el usuario no tiene una sesión autorizada, se le redirige al inicio de sesión.
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador')) {
    header("Location: ../pagina/login.php");
    exit();
}

// Configuración de acceso a la base de datos local del proyecto.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se establece la conexión para guardar el nuevo producto.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se detiene el proceso y se informa del problema.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Se reciben del formulario los datos que se guardarán para el producto.
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];

// Carpeta relativa donde se almacenan las imágenes de los productos.
$carpetaImagenes = "../img/";

// Si se envió una imagen sin errores, se valida su extensión y se guarda.
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {

    // Se obtiene la extensión del archivo en minúsculas para validarla.
    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));

    // Lista de extensiones de imagen permitidas para los productos.
    $extensionesPermitidas = ["jpg", "jpeg", "png", "gif"];

    // Se rechaza el archivo si su extensión no está permitida.
    if (!in_array($extension, $extensionesPermitidas)) {
        die("Solo se permiten imágenes JPG, JPEG, PNG o GIF.");
    }

    // El nombre de la imagen combina un prefijo, el código del producto y la extensión.
    $nombreImagen = "P-" . $codigo . "." . $extension;
    $ruta = $carpetaImagenes . $nombreImagen;

    // Se evita sobrescribir una imagen existente con el mismo nombre.
    if (file_exists($ruta)) {
        die("Ya existe una imagen para este producto.");
    }

    // Se mueve el archivo temporal cargado al directorio de imágenes del proyecto.
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta)) {
        die("No se pudo subir la imagen.");
    }

} else {
    // Si no se recibió una imagen válida, se utiliza la imagen predeterminada.
    $nombreImagen = "angie.png";
}

// Consulta que inserta los datos del producto y el nombre de su imagen en la tabla.
$sql = "INSERT INTO productos 
(codigo, nombre, descripcion, precio, costo, stock, imagen) 
VALUES 
('$codigo', '$nombre', '$descripcion', '$precio', '$costo', '$stock', '$nombreImagen')";

// Se ejecuta la inserción; si funciona, se redirige al usuario según su rol.
if ($conn->query($sql) === TRUE) {

    // Los administradores vuelven a la página de gestión de productos.
    if ($_SESSION['rol'] === 'administrador') {
        header("Location: ../admin/gestionproductos.php");
        exit();
    }

    // Los vendedores vuelven a la lista de productos.
    if ($_SESSION['rol'] === 'vendedor') {
        header("Location: ../productos/22.readproductos.php");
        exit();
    }

} else {
    // Si la inserción falla, se muestra el error informado por la base de datos.
    echo "Error: " . $conn->error;
}

// Se cierra la conexión al finalizar el procesamiento.
$conn->close();
?>