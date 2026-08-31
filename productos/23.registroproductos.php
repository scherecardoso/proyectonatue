<?php
session_start();

if ($_SESSION['rol'] != 'vendedor') {
    header("Location: ../pagina/login.php");
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
    //Define a que carpeta irá el archivo
     $carpetaImagenes = "../img/";
    if ($_FILES["IMAGEN"]["NAME"]==""){
        $nuevoNombre=".angie.png";
        
    } else{
         $extension = strtolower(pathinfo($_FILES["imagen"]["name"],PATHINFO_EXTENSION));
    //Define el nombre del archivo P-[codigo del producto]
    $nuevoNombre = "P-".$codigo.".".$extension;
    //Ejemplo: P-233.jpg
    }

   
   

    //ruta comppleta de carpeta+nombre donde se guardara el archivo
    $ruta = $carpetaImagenes . $nuevoNombre;
    $bandera=1;
    // Verificar si el archivo existe
    if (file_exists($ruta)) {
        echo "Lo sentimos, ya subiste este archivo.";
        $bandera = 0;
    }

    // Validar extensiones permitidas
    if($extension != "jpg" && $extension != "jpeg" && $extension != "png" &&$extension != "gif")
    {
        echo "Solo se permiten imágenes JPG, JPEG, PNG o GIF.<br>";
        $bandera = 0;
    }

     //subir archivo
    if ($bandera == 0) {
        echo "Ocurrió algun error.";
    } else {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " se subió.";
        } else {
            echo "No se pudo subir tu archivo.";
        }
    }

    header("Location: ../productos/22.readproductos.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>