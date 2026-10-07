<?php
// Datos necesarios para conectarse al servidor MySQL y a la base de datos del proyecto.
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

// Se crea la conexión con MySQL usando los datos indicados anteriormente.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Se detiene la ejecución si no fue posible conectarse a la base de datos.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Se lee de la URL el CI que identifica al usuario que se desea eliminar.
$CI = $_GET['CI'];

// Consulta que elimina de la tabla usuario el registro cuyo CI coincide con el recibido.
$sql = "DELETE FROM usuario WHERE CI='$CI'";

// Se ejecuta la consulta y se revisa si terminó correctamente.
if ($conn->query($sql) === TRUE) {

    // Se muestra un mensaje de confirmación de la eliminación.
    echo "Usuario eliminado exitosamente";
    // Se redirige a la página que presenta el listado de usuarios.
    header("Location: ../usuario/12.readusuarios.php");

} else {
    // Si ocurre un error, se muestran la consulta ejecutada y el detalle proporcionado por MySQL.
    echo "Error: " . $sql . "<br>" . $conn->error;
}
// Se libera la conexión a la base de datos al finalizar el proceso.
$conn->close();

?>