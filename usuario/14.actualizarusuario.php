<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}


// ==========================================
// RECIBIR LOS DATOS QUE SE VAN A EDITAR
// ==========================================

$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];


// ==========================================
// ACTUALIZAR LOS DATOS EN LA BASE DE DATOS
// ==========================================

$sql = "UPDATE usuario SET CI='$CI', nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol', estado='$estado' WHERE CI=$CI";

// ==========================================
// COMPRUEBA SI SE ACTUALIZÓ BIEN
// ==========================================

if ($conn->query($sql) === TRUE) {
    echo "Usuario actualizado exitosamente";
    header("Location: ../usuario/12.readusuarios.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>