<?php
// Se configuran los datos necesarios para conectarse a la base de datos local.
// Este script usa el servidor MySQL de XAMPP y la base de datos "shena".
// Se configuran los datos necesarios para conectarse a la base de datos local.
// En este script se usa el servidor MySQL de XAMPP, el usuario root,
// la contraseña vacía y la base de datos "shena".

// Datos de acceso a MySQL: servidor, usuario, contraseña y nombre de la base de datos.
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

// Se crea la conexión que se utilizará para guardar el nuevo usuario.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si ocurre un error al conectarse, se detiene el script y se informa del problema.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}


// Se reciben los datos enviados por el formulario mediante el método POST.
$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];



// Se prepara la instrucción SQL para insertar los datos recibidos en la tabla usuario.
$sql = "INSERT INTO usuario (CI, nombre, direccion, celular) VALUES ('$CI','$nombre', '$direccion', '$celular')";


// Se ejecuta la consulta y se comprueba si el registro se guardó correctamente.
if ($conn->query($sql) === TRUE) {
    // Si la inserción fue exitosa, se redirige al formulario de registro.
    header("Location: ../usuario/09.register.php");



} else {
    // Si la inserción falla, se muestra la consulta y el error devuelto por MySQL.
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Se cierra la conexión con la base de datos al finalizar el proceso.
$conn->close();

?>