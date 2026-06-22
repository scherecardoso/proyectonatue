<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Perfume de Frutilla y Petalos de Rosas - Natue</title>

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

<?php include("../includes/header.php"); ?>

<div class="contenedor">

    <div class="imagen-producto">
        <img src=".././img/zpr36.jpeg" alt="Perfume de Frutilla y Petalos de Rosas">
    </div>

    <div class="info-producto">

            <h1>Perfume de Frutilla y Petalos de Rosas</h1>

<p class="codigo"><strong>Código:</strong> PRD-036</p>

<p class="precio">38 Bs</p>

<div class="descripcion">
    <p>
        El perfume sólido de frutilla y pétalos de rosa Natue combina un aroma
        dulce con notas florales suaves, creando una fragancia delicada y
        agradable que acompaña la piel durante el día.
    </p>

    <p>
        Su mezcla equilibrada entre lo frutal y lo floral lo convierte en una
        opción ideal para quienes buscan un perfume ligero pero con personalidad,
        fácil de llevar en cualquier momento.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
       <li>Aroma dulce con toque floral.</li>
       <li>Fragancia suave y femenina.</li>
       <li>No contiene alcohol.</li>
       <li>Formato sólido práctico.</li>
       <li>Ideal para uso diario.</li>
       <li>Aplicación discreta y cómoda.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>
        Aplicar en puntos de pulso como muñecas, cuello o detrás de las orejas
        para activar la fragancia.
    </p>

</div>

</body>
</html>