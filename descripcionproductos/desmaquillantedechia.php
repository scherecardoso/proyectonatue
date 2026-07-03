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
        <img src=".././img/zpr1.jpeg" alt="Desmaquillante de Chía">
    </div>

    <div class="info-producto">

            <h1>JDesmaquillante de Chía</h1>

<p class="codigo"><strong>Código:</strong> PRD-023</p>

<p class="precio">28 Bs</p>

<div class="descripcion">
    <p>
        El desmaquillante de chía Natue ayuda a retirar el maquillaje de forma suave,
        mientras deja la piel con una sensación ligera y confortable. Su textura fluida
        permite una limpieza rápida sin necesidad de frotar demasiado.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
       <li>Remueve maquillaje de forma delicada.</li>
       <li>Ayuda a mantener la piel hidratada.</li>
       <li>No deja sensación grasosa.</li>
       <li>Ideal para uso diario.</li>
       <li>Textura ligera y fresca.</li>
       <li>Apto para piel sensible.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>
        Aplicar con un algodón sobre el rostro y ojos hasta retirar el maquillaje.
        No necesita enjuague.
    </p>

</div>

<a href="../03.productos.php" class="boton">Volver</a>
<a href="../28.micarrito.php" class="boton">Agregar a carrito</a>

</body>
</html>