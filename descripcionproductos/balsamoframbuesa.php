<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Balsamo de Frambuesa - Natue</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">

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

<?php include("../header.php"); ?>

<div class="contenedor">

    <div class="imagen-producto">
        <img src=".././img/zpr27.jpeg" alt="Balsamo de Frambuesa">
    </div>

    <div class="info-producto">

            <h1>Balsamo de Frambuesa</h1>

<p class="codigo"><strong>Código:</strong> PRD-030</p>

<p class="precio">20 Bs</p>

<div class="descripcion">
    <p>
        El bálsamo de frambuesa Natue combina cuidado labial con un toque frutal
        ligero que hace más agradable su uso diario. Deja una sensación fresca y suave.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
       <li>Hidrata los labios de forma ligera.</li>
       <li>Aroma frutal suave.</li>
       <li>Ayuda a mantener la suavidad.</li>
       <li>No se siente pesado.</li>
       <li>Uso diario cómodo.</li>
       <li>Textura ligera y agradable.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>Aplicar una capa fina sobre los labios cuando se sientan secos.</p>

</div><div class="descripcion">
    <p>
        Gracias a su textura cremosa y confortable, se desliza fácilmente sobre los labios, 
        aportando una sensación inmediata de suavidad. Es ideal para quienes buscan mantener 
        sus labios con una apariencia saludable y bien cuidada durante todo el día.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
      <li>Ayuda a prevenir la resequedad labial.</li> 
      <li>Aporta suavidad y confort.</li> 
      <li>Forma una capa protectora sobre los labios.</li> 
      <li>Textura agradable y fácil de aplicar.</li> 
      <li>Ideal para uso diario.</li> 
      <li>Contribuye a mantener los labios con una apariencia saludable.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>
       Aplicar directamente sobre los labios las veces que sea necesario, 
       especialmente cuando se sientan secos o expuestos a condiciones climáticas adversas.
    </p>

        </div>

        <a href="../03.productos.php" class="boton">Volver</a>
         <a href="../28.micarrito.php" class="boton">Agregar a carrito</a>
    </div>

</div>

</body>
</html>