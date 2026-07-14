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
    font-family:Arial, sans-serif;
}

body{
    background:linear-gradient(to bottom,#f8f8f8,#ececec);
    padding:30px;
}

.contenedor{
    width:95%;
    max-width:1400px;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

h1{
    margin-bottom:25px;
    font-size:42px;
    color:#444;
    font-weight:700;
}

.volver{
    background:linear-gradient(135deg,#e6e6e6,#cfcfcf);
    color:#444;
    padding:12px 24px;
    border-radius:12px;
    text-decoration:none;
    display:inline-block;
    margin-bottom:25px;
    font-weight:bold;
    box-shadow:0 3px 8px rgba(0,0,0,0.12);
    transition:0.3s;
}

.volver:hover{
    background:linear-gradient(135deg,#d8d8d8,#bdbdbd);
    transform:translateY(-2px);
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 15px;
}

th{
    background:#f7e8ee;
    color:#ff4f8b;
    padding:18px;
}

td{
    background:white;
    padding:18px;
    text-align:center;
}

.btn{
    padding:10px 18px;
    border-radius:12px;
    text-decoration:none;
    font-size:14px;
    margin:3px;
    display:inline-block;
    font-weight:bold;
}

.editar{
    background:#f8d8e5;
    color:#d63384;
}

.eliminar{
    background:#ffe1e1;
    color:#dc3545;
}

.cambiar{
    background:#ffe1e1;
    color:#E9967A;
}

.btn:hover{
    transform:translateY(-2px);
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

<?php include("../includes/header.php"); ?>

<div class="contenedor">

<h1>Lista de Usuarios</h1>

<a class="volver" href="../admin/06.admin.php">
    ← Volver
</a>

<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor,$usuario,$contra,$baseDeDatos);

if($conn->connect_error){
    die("Error de conexión");
}

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);

?>

<?php if($result && $result->num_rows > 0){ ?>

<table>

    <tr>
        <th>CI</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Celular</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php while($fila = $result->fetch_assoc()){ ?>

    <tr>

        <td><?= $fila["CI"] ?></td>
        <td><?= $fila["nombre"] ?></td>
        <td><?= $fila["direccion"] ?></td>
        <td><?= $fila["celular"] ?></td>
        <td><?= $fila["rol"] ?></td>
        <td><?= $fila["estado"] ?></td>

        <td>

            <a class="btn editar"
               href="../usuario/13.formeditarusuario.php?CI=<?= $fila['CI'] ?>">
               Editar
            </a>

            <a class="btn eliminar"
               href="../usuario/15.eliminarusuario.php?CI=<?= $fila['CI'] ?>">
               Eliminar
            </a>

            <?php if($fila["rol"]=="Usuario"){ ?>

                <a class="btn cambiar" href="../admin/cambiarrolVendedor.php?CI=<?= $fila['CI'] ?>">
                   Hacer Vendedor
                </a>

            <?php }elseif($fila["rol"]=="Vendedor"){ ?>

                <a class="btn cambiar" href="../admin/cambiarrolUsuario.php?CI=<?= $fila['CI'] ?>">
                   Hacer Usuario
                </a>

            <?php } ?>

        </td>

    </tr>

    <?php } ?>

</table>

<?php }else{ ?>

<p class="sin-datos">No hay usuarios registrados.</p>

<?php } ?>

<?php $conn->close(); ?>

</div>

</body>
</html>