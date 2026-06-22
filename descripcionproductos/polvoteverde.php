<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Polvo Te Verde - Natue</title>

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
        <img src=".././img/zpr42.jpeg" alt="Polvo Te Verde">
    </div>

    <div class="info-producto">

            <h1>Polvo Te Verde</h1>

<p class="codigo"><strong>Código:</strong> PRD-041</p>

<p class="precio">18 Bs</p>

<div class="descripcion">
    <p>
        El té verde molido Natue es un ingrediente natural utilizado en rutinas
        de cuidado facial por su textura fina y su origen vegetal.
    </p>

    <p>
        Aporta una sensación de limpieza suave, ideal para complementar
        mascarillas y tratamientos caseros.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
       <li>Ayuda a limpiar la piel suavemente.</li>
       <li>Origen vegetal natural.</li>
       <li>Textura fina para mezclas cosméticas.</li>
       <li>Aporta sensación refrescante.</li>
       <li>Ideal para mascarillas caseras.</li>
       <li>Uso facial o corporal.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>Mezclar con agua, miel o arcillas para formar una mascarilla natural.</p>

</div>

</body>
</html>