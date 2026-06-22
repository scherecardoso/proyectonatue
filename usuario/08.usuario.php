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
    "menu contenido"
    "pie pie";
    height:100vh;
    background:#fff;
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
@media (max-width: 768px){

    body{
        grid-template-columns: 1fr;
        grid-template-areas:
        "barra"
        "contenido"
        "pie";
        height: auto;
    }


    .menu{
        display: none;
    }
    .contenido{
        width: 100%;
        padding: 15px;
    }

    .bienvenida{
        flex-direction: column;
        height: auto;
        text-align: center;
        padding: 25px;
        gap: 20px;
    }

    .foto{
        width: 120px;
        height: 120px;
    }

    .texto h2{
        font-size: 28px;
    }

    .texto p{
        font-size: 16px;
    }

    .cards{
        flex-direction: column;
    }

    .card{
        width: 100%;
        height: auto;
        padding: 25px;
    }

    .card h3{
        font-size: 24px;
    }

    .pedidos{
        padding: 20px;
        overflow-x: auto;
    }

    table{
        min-width: 500px;
    }

    th,
    td{
        padding: 10px;
        font-size: 14px;
    }

}
</style> 
</head>

<body>
<?php include("../includes/header.php"); ?>
<aside class="menu">
    <h3>MENU USUARIO</h3>
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

<main class="contenido">
<section class="bienvenida">
<div class="foto"><img src="../img/sheshe.png"></div>
<div class="texto">
    <h2>BIENVENIDA <?php echo $_SESSION['nombre']; ?></h2>
    <p>Aquí puedes revisar tus pedidos, favoritos y administrar tu cuenta.</p>
</section>



<section class="cards">
    <article class="card"><div class="icono"><i class="fa-solid fa-cart-shopping"></i></div><h3><?php echo $totalpedido; ?></h3><p>Pedidos</p></article>
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
    <td>#PRD-<?php echo str_pad($pedido['id'],3,'0',STR_PAD_LEFT); ?></td>
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
<?php include("../includes/footer.php"); ?>
</body>
</html>