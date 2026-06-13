<?php
$direccion="localhost";
$usuario="root";
$contra="";
$baseDeDatos="shena";

$conn = new mysqli($direccion, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "No se conecto a la base de datos."
}

$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$sql = "UPDATE usuario SET CI='$CI', nombre='$nombre', direccion='$direccion', celular='$celular', rol='$rol',estado='$estado' WHERE CI='$CI'";

if ($conn->query($sql)===TRUE) {
    echo "Se edito exitosamente";
    header("Location: 12readusuario.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>