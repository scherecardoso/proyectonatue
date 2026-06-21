<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Flores de Kantuta - Natue</title>

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
        <img src="../img/zpr21.jpeg" alt="Flores de Kantuta">
    </div>

    <div class="info-producto">

        <h1>Flores de Kantuta</h1>

        <p class="codigo"><strong>Código:</strong> PRD-006</p>

        <p class="precio">35 Bs</p>

        <div class="descripcion">
           <p> 
           Gracias a su agradable textura, este sérum ayuda a mantener la piel
            con una apariencia más luminosa y equilibrada. Es ideal para quienes
             desean incorporar un producto inspirado en ingredientes naturales
              dentro de su rutina de cuidado personal.
           </p>
        </div>

        <div class="caracteristicas">

            <h2>Beneficios</h2>

            <ul>
              <li>Proporciona una sensación refrescante.</li>
              <li>Ayuda a conservar la suavidad de la piel.</li>
              <li>Aporta un aspecto más luminoso y uniforme.</li>
              <li>Textura ligera para uso cotidiano.</li> 
              <li>Favorece una apariencia saludable del rostro.</li>
              <li>Fácil de integrar en la rutina facial diaria.</li>
            </ul>

            <h2>Modo de uso</h2>

            <p>
                Aplicar unas gotas sobre la piel limpia y seca. Extender suavemente 
                por el rostro y cuello hasta que el producto se absorba por completo. 
                Puede utilizarse por la mañana o por la noche.
            </p>

        </div>

        <a href="../pagina/03.productos.php" class="boton">Volver</a>
        <a href="../pedidos/1.formpedidos.php" class="boton">Agregar a carrito</a>

    </div>

</div>

</body>
</html>