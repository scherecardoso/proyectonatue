<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Polvo de Maiz Morado - Natue</title>

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
        <img src=".././img/zpr17.jpeg" alt="Polvo de Maiz Morado">
    </div>

    <div class="info-producto">

            <h1>Polvo de Maiz Morado</h1>

<p class="codigo"><strong>Código:</strong> PRD-039</p>

<p class="precio">18 Bs</p>

<div class="descripcion">
    <p>
        El polvo de maíz morado Natue está inspirado en un ingrediente andino
        tradicional, utilizado en el cuidado natural de la piel por su textura
        suave y su origen vegetal.
    </p>

    <p>
        Ayuda a aportar una sensación de limpieza ligera, dejando la piel con
        un acabado más equilibrado y agradable al tacto.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
       <li>Ayuda a absorber exceso de grasa.</li>
       <li>Textura fina y suave.</li>
       <li>Aporta sensación de piel limpia.</li>
       <li>Uso cosmético natural.</li>
       <li>Ideal para mascarillas caseras.</li>
       <li>Deja acabado ligero en la piel.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>Mezclar con agua u otro ingrediente natural hasta formar una pasta y aplicar sobre la piel.</p>

</div>

</body>
</html>