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
    background:#f3f3f3;
    padding:30px;
}

.contenedor{
    width:95%;
    margin:auto;
}

h1{
    text-align:left;
    margin-bottom:30px;
    font-size:50px;
    color:black;
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 15px;
}

th{
    background:#f7e8ee;
    color:#ff4f8b;
    padding:20px;
    font-size:18px;
    border:none;
}

th:first-child{
    border-radius:10px 0 0 10px;
}

th:last-child{
    border-radius:0 10px 10px 0;
}

td{
    background:white;
    padding:18px;
    font-size:18px;
    border-top:1px solid #e5e5e5;
    border-bottom:1px solid #e5e5e5;
    text-align:center;
}

tr td:first-child{
    border-left:1px solid #e5e5e5;
    border-radius:20px 0 0 20px;
}

tr td:last-child{
    border-right:1px solid #e5e5e5;
    border-radius:0 20px 20px 0;
}

.btn{
    padding:10px 20px;
    border-radius:15px;
    text-decoration:none;
    font-size:15px;
    margin:3px;
    display:inline-block;
}

.editar{
    background:#f7d9e5;
    color:#ff4f8b;
}

.eliminar{
    background:#f6e5e5;
    color:#ff5b5b;
}

.btn:hover{
    opacity:0.8;
}

.sin-datos{
    text-align:center;
    margin-top:20px;
    color:#777;
    font-size:18px;
}

</style>
</head>

<body>

<div class="contenedor">

<h1>Lista de Usuarios</h1>
<a class='btn volver' href='../usuario/09.register.php?CI=$CI'>Volver</a>

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
                <a class='btn editar' href='../usuario/13.formeditarusuario.php?CI=$CI'>Editar</a>
                <a class='btn eliminar' href='../usuario/15.eliminarusuario.php?CI=$CI'>Eliminar</a>
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