<?php

// Datos de conexión al servidor MySQL y a la base de datos del proyecto.
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

// Se establece la conexión que permitirá guardar el producto.
$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

// Si la conexión falla, se detiene la ejecución y se informa el error.
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Se reciben los valores enviados por el formulario usando el método POST.
$codigo = $_POST["codigo"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$precio = $_POST["precio"];
$stock=$_POST["stock"];
$imagen=$_POST["imagen"];
$estado=$_POST["estado"];

// Consulta SQL que inserta los datos del nuevo producto en la tabla producto.
$sql = "INSERT INTO producto
(codigo,nombre,descripcion,precio,stock,imagen,estado)
VALUES
('$codigo','$nombre','$descripcion','$precio','$stock','$imagen','$estado')";

// Se ejecuta la consulta y se muestra un mensaje según el resultado.
if($conn->query($sql)){
    echo "Producto registrado correctamente";
}else{
    // Si ocurre un error al insertar, se muestra el mensaje de MySQL.
    echo "Error: ".$conn->error;
}


// Fin del proceso de registro.

?>