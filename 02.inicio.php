<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

<style>
body {
 display: grid;
 margin: 0;
 font-family: Arial, sans-serif;
 grid-template-columns: 1fr;   
 grid-template-areas:
    "barra"
    "banner"
    "nompro"
    "productos"
    "contenido"
    "pie";
 gap: 10px;

}

h2 {
    font-size: 28px;
}

h3{
    color: #000000;
}
  
.banner {
  grid-area: banner;
  background-color: pink;
  position: relative;
  }

.banner-img {
  width: 100%;
  height: auto;
  display: block;
}

.img-logo {
  position: relative;
  top: 200px;
  margin-left: 10%;
  background-color: #000;
  width: 300px;
  height: 100px;

}

.imagenes img:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.productos {
  grid-area: productos;
  display: flex;
  justify-content: space-evenly;
  align-items: flex-start;
  padding: 100px 0;
  background-color: #ffffff;
  position: relative;
  top: 200px;
  border-radius: 20%;
}
.titulo-productos {
 
  position: relative;
  width: 550px;
  height: 60px;
  background-color: #ffffff;
  top: 150px;
  justify-content: center;
  align-items: center;
  left: 35%;
  font-family: 'Playfair Display', serif;
  font-size: 35px; 
  color: #000;
  border-radius: 20%;
}


.rectangulo-titulo {
  width: 300px;
  height: 50px;
  background-color: #ffffff;
  border-radius: 20px;
  font-family: Tenor Sans, sans-serif;
  font-size: 28px;
}

.cuadro-grande {
  width: 350px;
  height: 480px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 80px;
}
.cuadro-grande img {
  width: 100%;
  height: 100%;
  border-radius: 80px;
  object-fit: cover;
}

.cuadro-grande:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.rectangulo-info {
  width: 300px;
  height: 95px;
  background-color: #ffffff;
  border-radius: 20px;
  font-family: Tenor Sans, sans-serif;
  font-size: 20px;
}


.contenido {
  grid-area: contenido;
  background-color: rgb(255, 255, 255);
  height: 900px;
  display: flex;
  align-items: center;
  gap: 50px;

}

.texto-contenido {
  width: 50%;
  padding-left: 50px;
  margin-top: -78px;
  margin-left: 20px;
  justify-content: space-between;
  font-size: 20px;
  font-family:'Open Sans';
  font-weight: 400;
  line-height: 1.7;
  font-size: 20px;
}  

.img-contenido {
  width: 550px;
  height: 550px;
  border-radius: 50px;
  }

.img-contenido:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}



@media (max-width: 768px) {

  .carrusel {
    height: auto;
  }

.banner-img {
  width: 100%;
  height: auto;
  display: block;
}

  .img-logo {
    width: 180px;
    height: auto;
    top: 80px;
    margin: auto;
    background: transparent;
  }

  .img-logo img {
    width: 100%;
    height: auto;
  }

  .titulo-productos {
    width: 100%;
    left: 0;
    top: 50px;
    text-align: center;
    font-size: 25px;
    height: auto;
  }


  .titulo-productos h2{
    font-size: 28px;
  }
  .productos {
    flex-direction: column;
    align-items: center;
    gap: 50px;
    top: 50px;
    padding: 50px 20px;
  }


  .producto {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }


  .rectangulo-titulo {
    width: 90%;
    text-align: center;
    font-size: 22px;
  }


  .cuadro-grande {
    width: 90%;
    max-width: 320px;
    height: 400px;
  }


  .rectangulo-info {
    width: 90%;
    height: auto;
    padding: 10px;
    text-align: center;
  }
  .contenido {
    flex-direction: column;
    height: auto;
    padding: 40px 20px;
    text-align: center;
    gap: 30px;
  }


  .texto-contenido {
    width: 100%;
    padding: 0;
    margin: 0;
    font-size: 16px;
    text-align: justify;
  }


  .img-contenido {
    width: 90%;
    max-width: 320px;
    height: auto;
  }
}


</style>
</head>


<body>

<?php include("header.php"); ?>

  <section class="carrusel"><img src="./img/banner4 - Copy.png" alt="Banner" class="banner-img" id="banner">
   
  </section>


  <div class="titulo-productos"><h2>Productos Destacados</h2></div>

  <section class="productos">

    <div class="producto">
    <div class="rectangulo-titulo"><p><center>Crema Facial</center></p></div>
    <div class="cuadro-grande">
    <img src="./img/zproducto1.jpg" alt=""></div>
    <div class="rectangulo-info"><center><p>Hidrata,protege y mantiene el equilibrio de la humedad del rostro para una piel saludable </p></center></div></div>

    <div class="producto">
    <div class="rectangulo-titulo"><p><center>Retinol</center></p></div>
    <div class="cuadro-grande">
    <img src="./img/zproducto2.jpg" alt=""></div>
    <div class="rectangulo-info"><center><p>Reduce arrugas, manchas y acne mejorando la textura de la piel</p></center></div></div>

    <div class="producto">
    <div class="rectangulo-titulo"><p><center>Crema Corporal </center></p></div>
    <div class="cuadro-grande">
    <img src="./img/zproducto3.png" alt=""></div>
    <div class="rectangulo-info"><center><p>Hidrata, suaviza y protege la piel del cuerpo evitando resequedad para prevenir irritaciones </p></center></div></div>

    <div class="producto">
    <div class="rectangulo-titulo"><center><p>Base en polvo</p></center></div>
    <div class="cuadro-grande">
    <img src="./img/zproducto4.png" alt=""></div>
    <div class="rectangulo-info"><center><p>Ayuda a unificar el tono de la piel, dando un acabado mate al rostro que cubre imperfecciones y sella el maquillaje liquido</p></center></div></div>
</section>


<section class="contenido">
  <div class="texto-contenido">
    <p>En Natue creemos en una belleza responsable y en equilibrio con la naturaleza.
      Nuestro propósito es promover un estilo de vida sostenible, impulsando el cuidado
      personal que también protege el medio ambiente.
      Trabajamos para crear conciencia sobre el impacto de nuestras decisiones diarias
      y fomentar prácticas que contribuyan al bienestar de las personas y del planeta.</p></div>
    <img src="./img/nos.png" alt="Orgánico y natural" class="img-contenido">
</section>

<?php include("footer.php"); ?>
</body>
</html>