<?php
// Datos de conexión para acceder a la base de datos local del proyecto.
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

// Se crea la conexión con MySQL usando los datos definidos arriba.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si ocurre un error al conectar, se detiene el proceso y se muestra el motivo.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}



// Se reciben del formulario los valores enviados mediante el método POST.
// Estos datos corresponden a los campos del usuario que se desea actualizar.
$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];



// Se prepara la consulta para cambiar los datos del usuario cuya CI coincide.
// La condición WHERE identifica el registro que será actualizado.
$sql = "UPDATE usuario SET CI='$CI', nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol', estado='$estado' WHERE CI=$CI";


// Se ejecuta la consulta y se verifica si MySQL la realizó correctamente.
if ($conn->query($sql) === TRUE) {
    // Se informa que la actualización fue exitosa y se vuelve al listado de usuarios.
    echo "Usuario actualizado exitosamente";
    header("Location: ../usuario/12.readusuarios.php");
} else {
    // Si la consulta falla, se muestran la consulta ejecutada y el error de MySQL.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Se cierra la conexión a la base de datos al terminar el proceso.
$conn->close();

?>