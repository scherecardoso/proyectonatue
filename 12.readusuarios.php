<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Lista de Usuarios</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:#fff;
    padding:20px;
}

.contenedor{
    max-width:900px;
    margin:auto;
    background:#fff;
    border:1px solid #ddd;
    padding:20px;
    border-radius:10px;
}

h1{
    text-align:center;
    margin-bottom:20px;
    font-size:22px;
    color:#c0c0c0;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f5f5f5;
    padding:10px;
    font-size:14px;
    border:1px solid #ddd;
}

td{
    padding:10px;
    font-size:14px;
    border:1px solid #eee;
    text-align:center;
}

.btn{
    padding:6px 10px;
    border:none;
    border-radius:6px;
    color:white;
    text-decoration:none;
    font-size:12px;
    margin:2px;
    display:inline-block;
}

.editar{
    background:#4caf50;
}

.eliminar{
    background:#e74c3c;
}

.sin-datos{
    text-align:center;
    margin-top:20px;
    color:#777;
}

</style>
</head>

<body>

<div class="contenedor">

<h1>Lista de Usuarios</h1>

<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error");
}

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    echo "<table>";
    echo "
    <tr>
        <th>CI</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Celular</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    ";

    while($fila = $result->fetch_assoc()) {

        $CI = $fila["CI"];

        echo "<tr>
            <td>{$fila['CI']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['direccion']}</td>
            <td>{$fila['celular']}</td>
            <td>{$fila['rol']}</td>
            <td>{$fila['estado']}</td>
            <td>
                <a class='btn editar' href='16.editarusuario.php?CI=$CI'>Editar</a>
                <a class='btn eliminar' href='15.eliminarusuario.php?CI=$CI'>Eliminar</a>
            </td>
        </tr>";
    }

    echo "</table>";

} else {
    echo "<p class='sin-datos'>No hay usuarios</p>";
}

$conn->close();

?>

</div>

</body>
</html>