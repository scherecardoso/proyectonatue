<?php
session_start();
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
    margin:0;
    font-family:'Open Sans', sans-serif;
    background:#f8f8f8;
}

.contenedor{
    max-width:1200px;
    margin:60px auto;
    padding:20px;
    display:flex;
    gap:50px;
    align-items:center;
}

.imagen-producto{
    flex:1;
}

.imagen-producto img{
    width:100%;
    max-width:500px;
    border-radius:25px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.info-producto{
    flex:1;
}

.info-producto h1{
    font-family:'Playfair Display', serif;
    font-size:42px;
    margin-bottom:15px;
}

.codigo{
    font-size:20px;
    margin-bottom:10px;
}

.precio{
    font-size:32px;
    font-weight:bold;
    color:#2d2d2d;
    margin-bottom:25px;
}

.descripcion{
    line-height:1.8;
    font-size:18px;
    text-align:justify;
}

.caracteristicas{
    margin-top:25px;
}

.caracteristicas h2{
    font-family:'Playfair Display', serif;
}

.caracteristicas ul{
    line-height:2;
}

.boton{
    display:inline-block;
    margin-top:30px;
    padding:15px 35px;
    background:#000;
    color:white;
    text-decoration:none;
    border-radius:30px;
}

@media(max-width:768px){

    .contenedor{
        flex-direction:column;
        text-align:center;
    }

    .descripcion{
        text-align:left;
    }

    .info-producto h1{
        font-size:32px;
    }
}

</style>
</head>
<body>

<?php include("../includes/header.php"); ?>

<div class="contenedor">

    <div class="imagen-producto">
        <img src="../img/zpr19.jpeg" alt="Serum de Tamarindo">
    </div>

    <div class="info-producto">

        <h1>Serum de Tamarindo</h1>

<p class="codigo"><strong>Código:</strong> PRD-003</p>

<p class="precio">48 Bs</p>

<div class="descripcion">
    <p>
        El Sérum de Tamarindo Natue está elaborado con extracto natural
        de tamarindo, conocido por sus propiedades hidratantes y
        antioxidantes que ayudan a mantener la piel fresca, suave y saludable.
        Su fórmula ligera permite una rápida absorción, brindando hidratación
        sin dejar sensación grasosa.
    </p>

    <p>
        Gracias a sus nutrientes naturales, este sérum contribuye a mejorar
        la textura de la piel, aportando luminosidad y ayudando a protegerla
        de los efectos causados por factores externos. Con el uso diario,
        la piel luce más revitalizada, uniforme y con una apariencia radiante.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
        <li>Hidratación profunda y duradera.</li>
        <li>Ayuda a suavizar la textura de la piel.</li>
        <li>Aporta luminosidad natural.</li>
        <li>Contiene antioxidantes de origen natural.</li>
        <li>Favorece una apariencia fresca y revitalizada.</li>
        <li>Textura ligera y rápida absorción.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>
        Aplicar de 2 a 3 gotas sobre el rostro limpio y seco.
        Masajear suavemente con movimientos circulares hasta su
        completa absorción. Utilizar por la mañana y por la noche
        para mejores resultados.
    </p>

</div>

        <a href="../pagina/03.productos.php" class="boton">Volver</a>
        <form action="../carrito/agregarcarrito.php" method="POST">

    <input type="hidden" name="codigo" value="3">
    <input type="hidden" name="cantidad" value="1">
    <input type="hidden" name="precio" value="48">

    <input type="submit" value="Agregar al Carrito"class="boton">

    </div>

</div>

</body>
</html>
