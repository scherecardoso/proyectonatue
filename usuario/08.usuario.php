<?php
session_start();
?>
<?php

$conexion = new mysqli("localhost","root","","shena");
$nombre_usuario = $_SESSION['nombre'];
$sqlPedidos = "SELECT COUNT(*) AS total FROM pedidos  WHERE nombre='$nombre_usuario'";
$resultadoPedidos = $conexion->query($sqlPedidos);
$filaPedidos = $resultadoPedidos->fetch_assoc();
$totalpedido = $filaPedidos['total'];

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
        "menu info act"
        "pie pie pie";
    gap: 10px;
    height: 100vh;
    background: #ffffff;
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
    width: 305px;
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
    height: 250px;
    width: 930px;
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
  color: black;
}

i{
    color:black;
}

.menu a{
    text-decoration: none;
    color: black;
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
    <div class="titulo-menu">MENU USUARIO</div>
    <div><i class="fa-solid fa-house"></i> Inicio</div>
    <div><i class="fa-solid fa-user"></i> Mi Perfil</div>
    <div><a href="../carrito/micarrito.php"><i class="fas fa-shopping-cart"></i> Mi Carrito</a></div>
    <div><a href="../pedidos/mispedidos.php"><i class="fa-solid fa-bag-shopping"></i> Mis Pedidos</div>
    <div><i class="fa-solid fa-heart"></i> Favoritos</div>
    <div><i class="fa-solid fa-location-dot"></i> Direcciones</div>
    <div><i class="fa-solid fa-credit-card"></i> Pagos</div>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><a href="../auth/26.cerrarsesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></div>
</aside>

<<<<<<< Updated upstream
<main class="info">
<section class="bienvenida"><div class="circulo"><img src="../img/sheshe.png"></div>
<div class="texto"><h2>BIENVENIDA <?php echo $_SESSION['nombre']; ?></h2>
<p>Aquí puedes revisar tus pedidos, favoritos y administrar tu cuenta.</p></div></section>
=======
<main class="contenido">
<section class="bienvenida">
<div class="foto"><img src="../img/sheshe.png"></div>
<div class="texto">
    <h2>BIENVENIDA <?php echo $_SESSION['nombre']; . $_SESSION['estado']; ?></h2>
    <p>Aquí puedes revisar tus pedidos, favoritos y administrar tu cuenta.</p>
</section>
>>>>>>> Stashed changes



<section class="cards">
    <article class="card"><div class="icono"><i class="fa-solid fa-cart-shopping"></i></div><h3><?php echo $totalpedido; ?></h3><p>Pedidos</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-heart"></i></div><h3>8</h3><p>Favoritos</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-star"></i></div><h3>5</h3><p>Reseñas</p></article>
</section>

<section class="contenido">
    <section class="resumen"><h3 class="titulo-caja">MIS PEDIDOS</h3>
<table class="tabla-pedidos">

<tr>
    <th>Pedido</th>
    <th>Fecha</th>
    <th>Estado</th>
</tr>

<?php

$conexion = new mysqli("localhost","root","","shena");

if($conexion->connect_error){
    die("Error de conexión");
}

$nombre_usuario = $_SESSION['nombre'];

$pedidos = $conexion->query(" SELECT * FROM pedidos WHERE nombre='$nombre_usuario' ORDER BY id DESC");

if($pedidos->num_rows > 0){

    while($pedido = $pedidos->fetch_assoc()){
?>

<tr>
    <td><?php echo $pedido['id']; ?></td>
    <td><?php echo $pedido['fecha']; ?></td>
    <td><?php echo $pedido['estado']; ?></td>
</tr>

<?php
    }

}else{
?>

<tr>
    <td colspan="3">No tienes pedidos registrados</td>
</tr>

<?php
}

$conexion->close();
?>

</table>

</section>
</main>

</body>
</html>