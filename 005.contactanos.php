<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contáctanos - Natue</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Open Sans', sans-serif;
    background-color:#f8f8f8;
}

.contacto{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:50px 20px;
}

.contacto h1{
    font-family:'Playfair Display', serif;
    font-size:48px;
    margin-bottom:20px;
}

.contacto p{
    font-size:18px;
    margin-bottom:50px;
    max-width:700px;
    line-height:1.6;
}

.iconos{
    display:flex;
    gap:80px;
    flex-wrap:wrap;
    justify-content:center;
}

.tarjeta{
    background:white;
    width:250px;
    padding:40px 20px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition:0.3s;
}

.tarjeta:hover{
    transform:translateY(-10px);
}

.tarjeta i{
    font-size:60px;
    color:#222;
    margin-bottom:20px;
}

.tarjeta h3{
    margin-bottom:10px;
    font-family:'Playfair Display', serif;
}

.tarjeta a{
    text-decoration:none;
    color:#444;
}

</style>
</head>
<body>

<?php include("header.php"); ?>

<section class="contacto">

    <h1>Contáctanos</h1>

    <p>
        Estamos disponibles para ayudarte. Puedes comunicarte con nosotros
        mediante nuestras redes sociales, WhatsApp o visitarnos en nuestra ubicación.
    </p>

    <div class="iconos">

        <div class="tarjeta">
            <a href="https://www.instagram.com/natue_cpp/" target="_blank">
                <i class="fab fa-instagram"></i>
                <h3>Instagram</h3>
                <p>@natue_cpp</p>
            </a>
        </div>

        <div class="tarjeta">
            <a href="https://wa.link/fm1yti" target="_blank">
                <i class="fa-brands fa-whatsapp"></i>
                <h3>WhatsApp</h3>
                <p>Escríbenos</p>
            </a>
        </div>

        <div class="tarjeta">
            <a href="https://maps.app.goo.gl/2hDiP1BoJQG7hdNK6" target="_blank">
                <i class="fa-solid fa-location-dot"></i>
                <h3>Ubicación</h3>
                <p>Ver en Google Maps</p>
            </a>
        </div>

    </div>

</section>
</body>
</html>