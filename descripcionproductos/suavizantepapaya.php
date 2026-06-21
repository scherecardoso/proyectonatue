<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Suavizante de Papaya - Natue</title>

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
        <img src=".././img/zpr3.jpeg" alt="Suavizante de Papaya">
    </div>

    <div class="info-producto">

            <h1>Suavizante de Papaya</h1>
<p class="codigo"><strong>Código:</strong> PRD-013</p>

<p class="precio">30 Bs</p>

<div class="descripcion">
    <p>
        Gracias a su textura ligera y fácil aplicación, este producto se integra 
        perfectamente en la rutina diaria, aportando una sensación de frescura y 
        bienestar. Su uso frecuente ayuda a mantener la piel con una apariencia cuidada y confortable.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
       <li>Ayuda a mantener la piel suave al tacto.</li> 
       <li>Aporta una sensación de frescura y comodidad.</li> 
       <li>Textura agradable y fácil de aplicar.</li> 
       <li>Ideal para complementar el cuidado diario.</li> 
       <li>Contribuye a una apariencia más cuidada.</li> 
       <li>Inspirado en ingredientes de origen natural.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>
        Aplicar una cantidad adecuada sobre la piel limpia y distribuir de 
        manera uniforme con suaves movimientos. Utilizar regularmente como 
        parte de la rutina de cuidado personal.
    </p>

        </div>

        <a href="../03.productos.php" class="boton">Volver</a>
         <a href="../28.micarrito.php" class="boton">Agregar a carrito</a>
    </div>

</div>

</body>
</html>