<?php
session_start();

if ($_SESSION['rol'] != "administrador") {
    echo "Acceso denegado";
    exit();
}
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

  header {
    padding: 20px;
    gap: 0px;
    height: 130px; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
   
  }

  nav {
    width: 100%;
    justify-content: center;
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

<header>
    <div class="logo"><h1>Natué</h1></div>

<nav>
    <ul>
    <li><a href="02.inicio.php">Inicio</a></li>
    <li><a href="03.productos.php">Cuidado</a></li>
    <li><a href="04.productos2.php">Cosmeticos</a></li>
    <li><a href="05.acercade.php">Nosotros</a></li>
    </ul>
</nav>


  <div class="iconos-barra">
    <a href="10.formusuarios.php"><i class="fa-solid fa-user"></i> <span style="font-size:14px; margin-left:5px;"></span></a>
    <a href="16.formproductos.php"><i class="fa-solid fa-bag-shopping"></i></a>
  </div>
</header>


<aside class="menu">
    <div class="titulo-menu">MENU ADMINISTRADOR</div>
    <div><i class="fa-solid fa-house"></i> Inicio</div>
    <a href="13.readusuario.php"><div><i class="fa-solid fa-users"></i> Gestión de Usuarios</div></a>
    <div><i class="fa-solid fa-shield-halved"></i> Roles y Permisos</div>
    <div><i class="fa-solid fa-box"></i> Gestión de Productos</div>
    <div><i class="fa-solid fa-chart-line"></i> Reportes</div>
    <a href="14.readproducto.php"><div><i class="fa-solid fa-cart-shopping"></i> Ventas y Pedidos</div></a>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><i class="fa-solid fa-clock-rotate-left"></i> Actividad</div>
    <div><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</div>
</aside>

<main class="info">
    <seccion class="bienvenida"><div class="circulo"><img src="./img/sheshe.png" alt=""></div>
    <div class="texto"><h2>BIENVENIDO</h2><p>Desde aquí puedes administrar y supervisar todas las operaciones del sistema</p></div></seccion>


<seccion class="cards">
    <article class="card"><div class="icono"><i class="fa-solid fa-users"></i></div><h3>24</h3><p>Usuarios Registrados</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-shield"></i></div><h3>2</h3><p>Roles Activos</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-box"></i></div><h3>156</h3><p>Productos Registrados</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-cart-shopping"></i></div><h3>128</h3><p>Pedidos este mes</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-dollar-sign"></i></div><h3>$3.805</h3><p>Ventas este mes</p></article>
</seccion>


<section class="contenido">
  <section class="resumen">
  <h3 class="titulo-caja">RESUMEN DE VENTAS</h3>
</section>

<section class="pedidos"><h3 class="titulo-caja">PEDIDOS RECIENTES</h3>
  <table class="tabla-pedidos">
      <tr>
        <th>Pedido</th>
        <th>Cliente</th>
        <th>Fecha</th>
        <th>Estado</th>
      </tr>

      <tr>
        <td>#PRD-023</td>
        <td>Roxana Lopez</td>
        <td>14/05/25</td>
        <td>Entregado</td>
      </tr>

      <tr>
        <td>#PRD-025</td>
        <td>Maria Eunice</td>
        <td>18/05/25</td>
        <td>Entregado</td>
      </tr>

      <tr>
        <td>#PRD-030</td>
        <td>Lucia Mendoza</td>
        <td>23/05/25</td>
        <td>Entregado</td>
      </tr>

      <tr>
        <td>#PRD-018</td>
        <td>Sofia Suarez</td>
        <td>31/05/25</td>
        <td>En proceso</td>
      </tr>
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


</body>
</html>