<?php
session_start();
if ($_SESSION['rol'] != "administrador") {
    echo "Acceso denegado";
    exit();
}

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}

$totalUsuarios = $conn->query(
    "SELECT COUNT(*) AS total FROM usuario"
)->fetch_assoc()['total'];

$totalProductos = $conn->query(
    "SELECT COUNT(*) AS total FROM productos"
)->fetch_assoc()['total'];
?>
?>
<!DOCTYPE html>
<html lang="en">
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
        "menu info act"
        "pie pie pie";
    gap: 10px;
    height: 100vh;
    background: #ffffff
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


.info {
    grid-area: info;
    display: grid;
    grid-template-areas:
        "bienvenida"
        "cards"
        "contenido";
    grid-template-rows: auto auto 1fr;
    gap: 20px;
    padding: 10px;
    margin-top: 25px;
}


.bienvenida {
    grid-area: bienvenida;
    background: #fdeff6;
    height: 220px;
    width: 900px;
    left: 20%;
    position: absolute;
    border-radius: 33px;
    margin-left: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    font-family: 'Playfair Display', serif;
    color: #2b2b2b;
    gap: 15px;
    justify-content: flex-start;
    padding: 20px 40px;
}


.circulo {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: white;
    border: 3px solid #cfcfcf;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.circulo img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
}

.cards {
    grid-area: cards;
    display: flex;
    gap: 10px;
    margin-top: 250px;
    margin-left: 175px;
}

.card {
    width: 205px;
    height: 225px;
    background-color: #ffffffe3;
    border-radius: 25px;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
}

.icono {
    width: 50px;
    height: 50px;
    background: #ffdcec;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icono i {
    color: #ff5ca8;
    font-size: 20px;
}


.card h3 {
    margin: 0;
    font-size: 28px;
    color: #000;
}

.card p {
    margin: 0;
    font-size: 14px;
    color: #777;
}


.contenido {
    grid-area: contenido;
    display: grid;
    grid-template-areas: "resumen pedidos";
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-top: 560px;
    margin-left: 177px;
    position: absolute;
}

.resumen {
    grid-area: resumen;
    background: #ffffff;
    height: 450px;
    width: 530px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    display: flex;
    flex-direction: column;  
    align-items: center;   
    justify-content: flex-start; 
    padding-top: 20px;
    color: #ff78b8;
    font-size: 28px;
}

.pedidos {
    grid-area: pedidos;
    background: #ffffff;
    height: 450px;
    width: 530px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;  
    align-items: center;   
    justify-content: flex-start; 
    padding-top: 20px;
    color: #ff78b8;
    font-size: 28px;
}

.act {
    grid-area: act;
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 10px;
    margin-top: 30px;
    margin-left: 1270px;
    border-radius: 25%;
    position: absolute;
}

.acciones {
    background: #ffffff;
    width: 290px;
    height: 320px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 25px;
}

.resumen-sistema {
    background: #ffffff;
    width: 290px;
    height: 320px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;

    display: flex;
    flex-direction: column;

    align-items: flex-start;
    justify-content: flex-start;

    padding: 25px;
}

.actividad {
    background: #ffffff;
    width: 290px;
    height: 320px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;

    display: flex;
    flex-direction: column;

    align-items: flex-start;
    justify-content: flex-start;

    padding: 25px;
}

.titulo-caja{
  color:#ff78b8;
  font-size:28px;
  margin-bottom:20px;
}


.tabla-pedidos{
  width:90%;
  margin:auto;
  border-collapse:collapse;
  font-size:16px;
  color:#555;
}

.tabla-pedidos th{
  text-align:left;
  padding:10px;
}

.tabla-pedidos td{
  padding:10px;
}


.lista-acciones{
  list-style:none;
  display:flex;
  flex-direction:column;
  gap:25px;
  padding:20px 35px;
  font-size:18px;
  color:#444;
}

.lista-acciones i{
  color:#ff78b8;
  margin-right:12px;
}



.lista-sistema{
  list-style:none;
  padding:20px 35px;
}

.lista-sistema li{
  display:flex;
  justify-content:space-between;
  margin-bottom:22px;
  font-size:18px;
  color:#444;
}



.lista-actividad{
  list-style:none;
  display:flex;
  flex-direction:column;
  gap:25px;
  padding:20px 35px;
  font-size:17px;
  color:#444;
}

.lista-actividad i{
  color:#ff78b8;
  margin-right:12px;
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

@media (max-width: 768px) {

  body{
    grid-template-columns: 1fr;
    grid-template-rows: auto;
    grid-template-areas:
      "barra"
      "info";
  }

  .menu,
  .act {
    display: none;
  }


  .bienvenida {
    position: static;
    width: 90%;
    height: auto;
    margin: 20px auto;
  
    flex-direction: column;
    text-align: center;
    padding: 20px;
  }

  .circulo {
    width: 120px;
    height: 120px;
  }

  .cards {
    margin: 20px 0;
    flex-wrap: wrap;
    justify-content: center;
  }

  .card {
    width: 45%;
  }

  .contenido {
    position: static;
    margin: 20px 0;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .resumen,
  .pedidos {
    width: 100%;
    height: auto;
  }

}
</style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<aside class="menu">
    <div class="titulo-menu">MENU ADMINISTRADOR</div>
    <div><i class="fa-solid fa-house"></i> Inicio</div>
    <a href="../usuario/13.formeditarusuario.php"><div><i class="fa-solid fa-users"></i> Gestión de Usuarios</div></a>
    <div><i class="fa-solid fa-shield-halved"></i> Roles y Permisos</div>
    <div><i class="fa-solid fa-box"></i> Gestión de Productos</div>
    <div><i class="fa-solid fa-chart-line"></i> Reportes</div>
    <a href="../productos/22.readproductos.php"><div><i class="fa-solid fa-cart-shopping"></i> Ventas y Pedidos</div></a>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><i class="fa-solid fa-clock-rotate-left"></i> Actividad</div>
    <div><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</div>
</aside>

<main class="info">
    <seccion class="bienvenida"><div class="circulo"><img src="./img/sheshe.png" alt=""></div>
    <div class="texto"><h2>BIENVENID@ <?php echo $_SESSION['nombre'];?></h2>
    <p>Desde aquí puedes administrar y supervisar todas las operaciones del sistema</p></div></seccion>


<section class="cards">
    <article class="card"><div class="icono"><i class="fa-solid fa-users"></i></div><h3><?php echo $totalUsuarios; ?></h3><p>Usuarios Registrados</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-shield"></i></div><h3>2</h3><p>Roles Activos</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-box"></i></div><h3><h3><?php echo $totalProductos; ?></h3></h3><p>Productos Registrados</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-cart-shopping"></i></div><h3><?php echo $totalUsuarios; ?></h3><p>Pedidos este mes</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-dollar-sign"></i></div><h3>$3.805</h3><p>Ventas este mes</p></article>
</section>


<section class="contenido">
  <section class="resumen">
  <h3 class="titulo-caja">RESUMEN DE VENTAS</h3>
</section>

<section class="pedidos"><h3 class="titulo-caja">PEDIDOS RECIENTES</h3>
  <table class="tabla-pedidos">
<?php
$pedidos = $conn->query("
    SELECT *
    FROM pedidos
    ORDER BY id DESC
    LIMIT 5
");

while($pedido = $pedidos->fetch_assoc()){
?>
<tr>
    <td><?php echo $pedido['nombre']; ?></td>
    <td><?php echo $pedido['fecha']; ?></td>
    <td><?php echo $pedido['estado']; ?></td>
    <td><?php echo $pedido['vendedor']; ?></td>
</tr>
<?php
}
?>

    </table>
  </section>
</section>

<aside class="act">
  <section class="acciones"><h3 class="titulo-caja">ACCIONES RAPIDAS</h3>
  <ul class="lista-acciones">
    <li><i class="fa-solid fa-user-plus"></i>Crear Usuario</li>
    <li><i class="fa-solid fa-shield-halved"></i>Asignar Rol</li>
    <li><i class="fa-solid fa-box"></i>Registrar Producto</li>
    <li><i class="fa-solid fa-chart-column"></i>Ver Reportes</li>
  </ul>
  </section>

  <section class="resumen-sistema">
    <h3 class="titulo-caja">RESUMEN DEL SISTEMA</h3>
    <ul class="lista-sistema">
    <li><span>Usuarios activos</span><strong>18</strong></li>
    <li><span>Productos activos</span><strong>156</strong></li>
    <li><span>Pedidos este mes</span><strong>128</strong></li>
    <li><span>Ventas este mes</span><strong>$3.850</strong></li></ul>
  </section>

 
  <section class="actividad">
    <h3 class="titulo-caja">ACTIVIDAD RECIENTE</h3>
    <ul class="lista-actividad">
      <li><i class="fa-solid fa-user"></i>Nuevo usuario creado</li>
      <li><i class="fa-solid fa-box"></i>Producto registrado</li>
      <li><i class="fa-solid fa-cart-shopping"></i>Pedido actualizado</li>
      <li><i class="fa-solid fa-chart-line"></i>Reporte generado</li>
    </ul>
  </section>
</aside>
</main>
</body>
</html>