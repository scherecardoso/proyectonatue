<?php
// Datos necesarios para conectarse al servidor y seleccionar la base de datos.
$direccion="localhost";
$usuario="root";
$contra="";
$baseDeDatos="shena";

// Se crea la conexión con MySQL usando los datos definidos arriba.
$conn = new mysqli($direccion, $usuario, $contra, $baseDeDatos);

// Si MySQL informa un error de conexión, se muestra un mensaje.
if ($conn->error) {
    echo "No se conecto a la base de datos.";
}

// Se obtienen de la solicitud POST los datos enviados desde el formulario.
// CI identifica al usuario; los demás valores corresponden a sus datos editables.
$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

// Se prepara la consulta para actualizar los datos del usuario cuya CI coincide.
// Los valores nuevos se asignan a sus respectivas columnas de la tabla usuario.
$sql = "UPDATE usuario SET CI='$CI', nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol',estado='$estado' WHERE CI='$CI'";

// Se ejecuta la consulta y se comprueba si MySQL la procesó correctamente.
if ($conn->query($sql)===TRUE) {
    // Se informa que la actualización tuvo éxito y se vuelve al listado de usuarios.
    echo "Se edito exitosamente";
    header("Location: ../usuario/13.readusuario.php");
} else {
    // Si la consulta falla, se muestran la consulta y el error reportado por MySQL.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Se cierra la conexión para liberar los recursos utilizados.
$conn->close();

?>