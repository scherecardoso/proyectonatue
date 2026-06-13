<?php
$direccion ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "coneccion fallida"
}

$CI = $_POST['CI'];

$sql = "DELETE FROM usuario WHERE CI=$CI";

if ($conn->query($sql) === TRUE) {
    echo "Usuario eliminado exitosamente";
<<<<<<< HEAD:16.eliminarusuario.php
    header("Location: 13.readusuarios.php");
=======
    header("Location: 11.readusuario.php");
>>>>>>> 19750247a25495b946007d7f962f839b51e61ea1:15.eliminarusuario.php
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>