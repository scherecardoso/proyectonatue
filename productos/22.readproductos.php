<?php
session_start();

if ($_SESSION['rol'] != 'vendedor') {
    header("Location: ../pagina/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

<style>

body{
    display:grid;
    margin:0;
    font-family:Arial, sans-serif;
    grid-template-columns:300px 1fr;
    grid-template-rows:70px 1fr;
    grid-template-areas:
    "barra barra"
    "menu contenido";
    background:#ffffff;
}

.menu{
    grid-area:menu;
    display:flex;
    flex-direction:column;
    gap:10px;
    background-color:#ffffff;
    padding:15px;
    width:300px;
    border-right:1px solid #ececec;
}

.titulo-menu{
    font-size:15px;
    color:#ff5ca8;
    margin-bottom:10px;
}

.menu div{
    padding:15px;
    border-radius:12px;
    font-size:18px;
    transition:.3s;
    cursor:pointer;
}

.menu div:hover{
    background:#ffdcec;
    color:#ff5ca8;
    padding-left:22px;
}

.menu a{
    text-decoration:none;
    color:black;
}



.contenedor{
    grid-area:contenido;
    width:90%;
    max-width:1200px;
    margin:40px auto;
    background:white;
    padding:35px;
    border-radius:28px;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
    border:1px solid #f3f3f3;
}



table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 12px;
}

th{
    background:#fff1f7;
    padding:18px;
    font-size:15px;
    color:#ff5ca8;
    border:none;
}

td{
    background:white;
    padding:18px;
    font-size:14px;
    text-align:center;
    border-top:1px solid #f3f3f3;
    border-bottom:1px solid #f3f3f3;
}

tr td:first-child{
    border-left:1px solid #f3f3f3;
    border-radius:15px 0 0 15px;
}

tr td:last-child{
    border-right:1px solid #f3f3f3;
    border-radius:0 15px 15px 0;
}

tr:hover td{
    background:#fff8fb;
}



.btn{
    padding:8px 15px;
    border-radius:12px;
    font-size:13px;
    font-weight:500;
    text-decoration:none;
}

.editar{
    background:#ffe4ef;
    color:#ff4f8b;
}

.eliminar{
    background:#fff0f0;
    color:#ff4d4d;
}

.sin-datos{
    text-align:center;
    margin-top:20px;
    color:#777;
}



@media (max-width:768px){

body{
    display:flex;
    flex-direction:column;
}

.menu{
    width:100%;
    border-right:none;
}

.contenedor{
    width:95%;
    padding:15px;
    margin:20px auto;
}

table{
    font-size:12px;
}

th,
td{
    padding:10px;
}

h1{
    font-size:28px;
}

}

</style>
</head>

<body>
<?php include("../includes/header.php"); ?>
<aside class="menu">

<div class="titulo-menu">MENU ADMINISTRADOR</div>

<a href="../admin/06.admin.php"><div><i class="fa-solid fa-house"></i> Inicio</div></a>
<a href="../usuario/12.readusuario.php"><div><i class="fa-solid fa-users"></i> Gestión de Usuarios</div></a>

 <div><i class="fa-solid fa-shield-halved"></i> Roles y Permisos</div>
 <div><i class="fa-solid fa-box"></i> Gestión de Productos</div>
 <div><i class="fa-solid fa-chart-line"></i> Reportes</div>

<a href="../productos/22.readproductos.php">
 <div><i class="fa-solid fa-cart-shopping"></i> Ventas y Pedidos</div></a>
 <div><i class="fa-solid fa-gear"></i> Configuración</div>
 <div><i class="fa-solid fa-clock-rotate-left"></i> Actividad</div>
 <div><a href="../auth/26.cerrarsesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></div>

</aside>



<div class="contenedor">
    <h1>Lista de Productos</h1>

<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}
if ($_SESSION['rol']) || $_SESSION['rol'] != 'administrador' {
    echo "Acceso denegado";
    exit();
}

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    echo "<table>";
    echo "
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Costo</th>
        <th>Stock</th>
        <th>Acciones</th>
    </tr>
    ";

    while($fila = $result->fetch_assoc()) {

        $codigo = $fila['codigo'];

        echo "
        <tr>
            <td>{$fila['codigo']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['descripcion']}</td>
            <td>$ {$fila['precio']}</td>
            <td>$ {$fila['costo']}</td>
            <td>{$fila['stock']}</td>

            <td>
                <a class='btn editar'
                href='../productos/18.formeditarproductos.php?codigo=$codigo'>
                Editar
                </a>

                <a class='btn eliminar'
                href='../productos/20.eliminarproductos.php?codigo=$codigo'>
                Eliminar
                </a>
            </td>
        </tr>
        ";
    }

    echo "</table>";

} else {

    echo "<p class='sin-datos'>
    No hay productos registrados
    </p>";

}

$conn->close();

?>

</div>

</div>
</body>
</html>