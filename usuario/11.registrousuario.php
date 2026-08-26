<?php

// ==========================================
// CONEXIÓN A LA BD
// ==========================================

$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}


// ==========================================
// RECIBIR DATOS DEL FORMULARIO
// ==========================================
$CI = $_POST['CI'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$celular = $_POST['celular'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];


// ==========================================
// INSERTAR USUARIO EN LA BASE DE DATOS
// ==========================================

$sql = "INSERT INTO usuario (CI, nombre, direccion, celular, rol, estado) VALUES ('$CI','$nombre', '$direccion', '$celular', '$rol','$estado')";

// ==========================================
// COMPRUEBA SI EL USUARIO SE GUARDÓ
// ==========================================

if ($conn->query($sql) === TRUE) {
    header("Location: ../usuario/09.register.php");



} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// ==========================================
// CERRAR CONEXIÓN
// ==========================================

$conn->close();

?>