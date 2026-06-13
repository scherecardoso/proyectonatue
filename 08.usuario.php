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

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    display:grid;
    grid-template-columns:220px 1fr;
    grid-template-rows:70px 1fr;
    grid-template-areas:
    "barra barra"
    "menu contenido";
    height:100vh;
    background:#fff;
}



header{
    grid-area:barra;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:0 60px;
    border-bottom:2px solid #ff5ca8;
    background:#fff;
}

.logo{
    font-size:28px;
    color:black;
    font-weight:bold;
}

.iconos{
    display:flex;
    gap:25px;
}

.iconos a{
    color:#444;
    font-size:20px;
    text-decoration:none;
}



.menu{
    grid-area:menu;
    border-right:1px solid #eee;
    padding:20px;
    display:flex;
    flex-direction:column;
    gap:12px;
}

.menu h3{
    color:#ff5ca8;
    margin-bottom:15px;
}

.menu div{
    padding:14px;
    border-radius:12px;
    cursor:pointer;
    transition:.3s;
}

.menu div:hover{
    background:#ffdcec;
    color:#ff5ca8;
}



.contenido{
    grid-area:contenido;
    padding:30px;
}



.bienvenida{
    width:100%;
    height:220px;
    background:#fdeff6;
    border-radius:30px;
    display:flex;
    align-items:center;
    padding:40px;
    gap:30px;
}

.foto{
    width:160px;
    height:160px;
    border-radius:50%;
    overflow:hidden;
    background:#fff;
}

.foto img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.texto h2{
    font-size:38px;
    color:#333;
}

.texto p{
    margin-top:10px;
    color:#666;
    font-size:18px;
}



.cards{
    margin-top:30px;
    display:flex;
    gap:20px;
}

.card{
    flex:1;
    height:180px;
    border-radius:25px;
    background:#fff;
    border:1px solid #eee;
    box-shadow:0 5px 18px rgba(0,0,0,0.05);
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    gap:10px;
}

.icono{
    width:55px;
    height:55px;
    border-radius:50%;
    background:#ffdcec;
    display:flex;
    justify-content:center;
    align-items:center;
}

.icono i{
    color:#ff5ca8;
    font-size:22px;
}

.card h3{
    font-size:30px;
}

.card p{
    color:#777;
}




.pedidos{
    margin-top:35px;
    background:#fff;
    border-radius:30px;
    border:1px solid #eee;
    box-shadow:0 5px 18px rgba(0,0,0,0.05);
    padding:30px;
}

.titulo{
    color:#ff5ca8;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:14px;
    text-align:left;
}

th{
    color:#555;
}

td{
    color:#777;
}

</style>
</head>

<body>


<header>
    <div class="logo">Natué</div>
    <div class="iconos"><a href="formUsuarios"><i class="fa-solid fa-user"></i></a>
    <a href="16.formproductos.php"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</header>



<aside class="menu">
    <h3>MENU USUARIO</h3>
    <div><i class="fa-solid fa-house"></i> Inicio</div>
    <div><i class="fa-solid fa-user"></i> Mi Perfil</div>
    <div><i class="fa-solid fa-bag-shopping"></i> Mis Pedidos</div>
    <div><i class="fa-solid fa-heart"></i> Favoritos</div>
    <div><i class="fa-solid fa-location-dot"></i> Direcciones</div>
    <div><i class="fa-solid fa-credit-card"></i> Pagos</div>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</div>
</aside>

<main class="contenido">
<section class="bienvenida">
<div class="foto"><img src="sheshe.png"></div>
    <div class="texto"><h2>BIENVENIDA</h2><p>Aquí puedes revisar tus pedidos,favoritos y administrar tu cuenta.</p></div>
</section>



<section class="cards">
    <article class="card"><div class="icono"><i class="fa-solid fa-cart-shopping"></i></div><h3>12</h3><p>Pedidos</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-heart"></i></div><h3>8</h3><p>Favoritos</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-star"></i></div><h3>5</h3><p>Reseñas</p></article>
</section>

<section class="pedidos">
    <h2 class="titulo">MIS PEDIDOS</h2>
<table>
   <tr>
        <th>Pedido</th>
        <th>Fecha</th>
        <th>Estado</th>
    </tr>

    <tr>
        <td>#NT-001</td>
        <td>12/05/25</td>
        <td>Entregado</td>
    </tr>

    <tr>
        <td>#NT-002</td>
        <td>18/05/25</td>
        <td>En camino</td>
    </tr>

    <tr>
        <td>#NT-003</td>
        <td>23/05/25</td>
        <td>Procesando</td>
    </tr>
</table>

</section>
</main>
</body>
</html>