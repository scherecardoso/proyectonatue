<?php

$direccion = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($direccion, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "Error";
}

$sql = "SELECT * FROM usuario";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while($fila=$resultado->fetch_assoc()){
        echo $fila['CI']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado']."<br>";
        $CI=$fila['CI'];
        echo "<a href='12.readusuario.php'><button>Mostrar</button></a>"
        echo "<a href='14formeditarusuariophp'><button>Editar</button></a>"
        echo "<a href='16.eliminarusuario.php'><button>eliminar</button></a>"
    }
}
$conn->close();

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
  
body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 198px 1fr 260px;
    grid-template-rows: 70px 1fr;   
    grid-template-areas:
        "barra barra barra"
        "menu info act";
    gap: 10px;
    height: 100vh;
    background: #ffffff
}


header {
    grid-area: barra;
    background-color: #ffffffb5;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 120px;
    top: 0;
    position: sticky;
    height: 60px;
    z-index: 100;
}

.logo {
    font-family: 'Playfair Display', serif;
    font-size: 13px;
    color: #000000;
    margin: 0;
}



nav {
    display: flex;
    align-items: center;
    gap: 40px;
}


nav ul {
    list-style: none;
    display: flex;
    gap: 25px;
}
nav a {
    text-decoration: none;
    color: #2b2b2b;
    font-weight: 500px;
    font-size: 15px;
    position: relative;
}


nav a.activo:after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 100%;
    height: 1px;
    background-color: #333333;
}

.iconos-barra {
    display: flex;
    align-items: center;
    gap: 25px;
}

.iconos-barra a {
    color: #2b2b2b;
    text-decoration: none;
    font-size: 18px;
    position: relative;
}


.menu {
    grid-area: menu;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: #ffffff;
    padding: 15px;
    margin-top: 27px;
    width: 330px;
    border-right: 1px solid #ececec;
}

.titulo-menu {
    font-size: 15px;
    color: #ff5ca8; 
    margin-bottom: 10px;
}

.menu div{
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
    cursor: pointer;
}

.menu div:hover{
    background: #ffdcec;
    color: #ff5ca8;
    padding-left: 22px;
} 


.contenedor{
    width:1100px;
    margin-top:40px;
    margin-left:250px;
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
tr:hover{
    background:#fff8fb;
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

h2{
    font-size: 35px;
}

p{
    font-size: 20px;
}

div{
  color: #000;
}


</style>
</head>

<body>
<header>
    <div class="logo">
    <h1>Natué</h1>
    </div>


<nav>
    <ul>
    <li><a href="02.inicio.php">Inicio</a></li>
    <li><a href="03.productos.php">Cuidado</a></li>
    <li><a href="04.productos2.php">Cosmeticos</a></li>
    <li><a href="05.acercade.php">Nosotros</a></li>
    </ul>
</nav>


    <div class="iconos-barra">
    <a href="10.formusuario.php"><i class="fa-solid fa-user"></i> <span style="font-size:14px; margin-left:5px;"></span></a>
    <a href="16.formproductos.php"><i class="fa-solid fa-bag-shopping"></i></a>
    </div>
</header>


<aside class="menu">
    <div class="titulo-menu">MENU ADMINISTRADOR</div>
    <a href="06.admin.php"><div><i class="fa-solid fa-house"></i> Inicio</div></a>
    <a href="11.readusuario.php"><div><i class="fa-solid fa-users"></i> Gestión de Usuarios</div></a>
    <div><i class="fa-solid fa-shield-halved"></i> Roles y Permisos</div>
    <div><i class="fa-solid fa-box"></i> Gestión de Productos</div>
    <div><i class="fa-solid fa-chart-line"></i> Reportes</div>
    <a href="17.readproductos.php"><div><i class="fa-solid fa-cart-shopping"></i> Ventas y Pedidos</div></a>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><i class="fa-solid fa-clock-rotate-left"></i> Actividad</div>
    <div><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</div>
</aside>

<div class="contenedor"><h1>Lista de Usuarios</h1>

<<<<<<< HEAD:13.readusuarios.php
=======
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

if ($result->num_rows > 0) {

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
                <a class='btn editar' href='13.formeditarusuario.php?CI=$CI'>Editar</a>
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

>>>>>>> 19750247a25495b946007d7f962f839b51e61ea1:11.readusuario.php
</div>
</body>
</html>