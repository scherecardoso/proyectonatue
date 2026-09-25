<?php
session_start();
$rol = strtolower(trim((string) ($_SESSION['rol'] ?? '')));
if (
    !isset($_SESSION['rol']) ||
    !in_array($rol, ['administrador', 'admin', 'vendedor'], true)
) {
    echo "Acceso denegado";
    exit();

}
?>
<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$costo = $_POST['costo'];
$stock = $_POST['stock'];
$sql = "INSERT INTO productos (codigo, nombre, descripcion, precio, costo, stock) VALUES ('$codigo', '$nombre', '$descripcion', '$precio',  '$costo','$stock')";
if ($conn->query($sql) === TRUE) {

     $carpetaImagenes = "../img/";
    if ($_FILES["IMAGEN"]["NAME"]==""){
        $nuevoNombre=".angie.png";
        
    } else{
         $extension = strtolower(pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION));
    $nuevoNombre = "P-".$codigo.".".$extension;
    }

   
  
    $ruta = $carpetaImagenes . $nuevoNombre;
    $bandera=1;
    if (file_exists($ruta)) {
        echo "Lo sentimos, ya subiste este archivo.";
        $bandera = 0;
    }


    if($extension != "jpg" && $extension != "jpeg" && $extension != "png" &&$extension != "gif")
    {
        echo "Solo se permiten imágenes JPG, JPEG, PNG o GIF.<br>";
        $bandera = 0;
    }

    if ($bandera == 0) {
        echo "Ocurrió algun error.";
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " se subió.";
        } else {
            echo "No se pudo subir tu archivo.";
        }
    }

    if ($rol === 'admin' || $rol === 'administrador') {
        header("Location: ../admin/gestionproductos.php");
    } else {
        header("Location: ../productos/22.readproductos.php");
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>