<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$CI = $_GET['CI'];

$sql = "SELECT * FROM usuario WHERE CI = $CI";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $nombre = $fila['nombre'];
        $direccion = $fila['direccion'];
        $celular = $fila['celular'];
        $rol = $fila['rol'];
        $estado = $fila['estado'];
    }
} else {
    echo "Usuario no encontrado";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>

    <h2>Editar Usuario</h2>

    <form action="14.actualizarusuario.php" method="post">

        <input type="hidden" name="CI" value="<?=$CI?>">
        <input type="text" name="nombre" value="<?=$nombre?>" placeholder="Nombre Completo" required>
        <input type="text" name="direccion" value="<?=$direccion?>" placeholder="Dirección" required>
        <input type="number" name="celular" value="<?=$celular?>" placeholder="Celular" required>
        <input type="text" name="rol" value="<?=$rol?>" placeholder="Rol" required>
        <input type="text" name="estado" value="<?=$estado?>" placeholder="Estado" required>
        <button type="submit">Actualizar Usuario</button>

    </form>

</body>
</html>