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
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f3f3f3;
    padding:40px;
}

h2{
    text-align:center;
    font-size:42px;
    color:#222;
    margin-bottom:30px;
}

form{
    width:550px;
    margin:0 auto;
    background:white;
    padding:40px;
    border-radius:25px;
    border:2px solid #f8c6e5;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

input{
    width:100%;
    height:58px;
    padding:20px;
    margin-bottom:18px;
    border:1px solid #f5a3d5;
    border-radius:40px;
    background:#fafafa;
    color:#777;
    font-size:15px;
    outline:none;
}

input:focus{
    border-color:#f06ac3;
}

button{
    width:100%;
    padding:16px;
    border:1px solid #f34bb3;
    border-radius:40px;
    background:#f06ac3;
    color:white;
    font-size:17px;
    cursor:pointer;
    margin-top:10px;
    transition:0.3s;
}

button:hover{
    background:#f765c6;
    transform:scale(1.03);
}
select {
    width:100%;
    height:58px;
    color: #777;
    border:1px solid #f5a3d5;
    border-radius:40px;
    display:flex;
    align-items:center;
    padding:20px;
    margin-bottom:18px;
    background:#fafafa;
}
</style>
<body>

    

    <form action="../usuario/14.actualizarusuario.php" method="post">
<h2>Editar Usuario</h2>
        <input type="hidden" name="CI" value="<?=$CI?>">
        <input type="text" name="nombre" value="<?=$nombre?>" placeholder="Nombre Completo" required>
        <input type="text" name="direccion" value="<?=$direccion?>" placeholder="Dirección" required>
        <input type="number" name="celular" value="<?=$celular?>" placeholder="Celular" required>
        <select name="rol" required>

        <option value="">Seleccione un rol</option>
        <option value="administrador">Administrador</option>
        <option value="vendedor">Vendedor</option>
        <option value="usuario">Usuario</option>

    </select>
        <input type="text" name="estado" value="<?=$estado?>" placeholder="Estado" required>
        <button type="submit">Actualizar Usuario</button>

    </form>

</body>
</html>