<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Despigmentante de Achachairu - Natue</title>

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
        <img src="../img/zpr6.jpeg" alt="Despigmentante de Achachairu">
    </div>

    <div class="info-producto">

            <h1>Despigmentante de Achachairú</h1>

<p class="codigo"><strong>Código:</strong> PRD-002</p>

<p class="precio">55 Bs</p>

<div class="descripcion">
    <p>
        El Despigmentante de Achachairú Natue está elaborado con extractos
        naturales de achachairú, conocidos por sus propiedades antioxidantes
        y regeneradoras que ayudan a mejorar el aspecto uniforme de la piel.
    </p>

    <p>
        Su fórmula contribuye a disminuir la apariencia de manchas causadas
        por el sol, la edad o el acné, brindando una piel más luminosa,
        suave y saludable con el uso constante.
    </p>
</div>

<div class="caracteristicas">

    <h2>Beneficios</h2>

    <ul>
        <li>Ayuda a reducir manchas y pigmentaciones.</li>
        <li>Favorece un tono de piel más uniforme.</li>
        <li>Aporta luminosidad natural al rostro.</li>
        <li>Contiene antioxidantes de origen natural.</li>
        <li>Contribuye a la regeneración de la piel.</li>
        <li>Apto para uso diario.</li>
    </ul>

    <h2>Modo de uso</h2>

    <p>
        Aplicar una pequeña cantidad sobre la piel limpia y seca,
        especialmente en las zonas con manchas. Masajear suavemente
        hasta su completa absorción. Utilizar preferentemente por la
        noche y complementar con protector solar durante el día.
    </p>

        </div>

        <a href="../pagina/03.productos.php" class="boton">Volver</a>
        <form action="../carrito/agregarcarrito.php" method="POST">

    <input type="hidden" name="codigo" value="2">
    <input type="hidden" name="cantidad" value="1">
    <input type="hidden" name="precio" value="55">

    <input type="submit" value="Agregar al Carrito"class="boton">

</form>
    </div>

</div>

</body>
</html>