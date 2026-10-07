<?php
// Inicia la sesión para mantener disponible la información del usuario actual.
session_start();

// Se establece la conexión con la base de datos "shena" del servidor local.
$conexion = new mysqli("localhost","root","","shena");

// Si la conexión no se pudo realizar, se detiene el proceso y se muestra un mensaje.
if($conexion->connect_error){
    die("Error de conexión");
}

// Se reciben desde el formulario los datos enviados mediante el método POST.
$costo = $_POST['costo'];
$metodo = $_POST['metodo'];

// La venta se registra inicialmente con el estado "En proceso".
$estado = 'En proceso';

// Se prepara la consulta SQL para guardar el costo, el método de pago y el estado.
$sql = "INSERT INTO ventas(costo, metodo, estado)VALUES('$costo','$metodo','$estado')";

// Se ejecuta la consulta para insertar la nueva venta en la base de datos.
if($conexion->query($sql)){
    // Si el registro se guardó correctamente, se redirige al listado de ventas.
    header("Location: readventas.php");
    // Finaliza la ejecución para que no se procese más código después de redirigir.
    exit();
}else{
    // Si ocurrió un error al guardar, se muestra el mensaje devuelto por MySQL.
    echo "Error: " . $conexion->error;
}
?>