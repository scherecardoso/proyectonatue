<?php
session_start();
?>
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
    "coment"
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

 .caja-correo {
  position: absolute;
  top: 55%;      
  left:10%;
  display: flex;
  gap: 15px;          

}

.input-correo {
  border-radius: 50px;
  border: 1px solid rgba(255, 255, 255, 0.666);
  background-color: rgba(255, 255, 255, 0.308);
  color: #ffffff;
  font-size: 18px;
  text-align: center;
  width: 500px;
  height: 80px;
}

.boton-enviar {
  width: 100px;
  height: 80px;
  border-radius: 50px;
  border: 1px solid rgba(255, 255, 255, 0.666);
  background-color: rgba(255, 255, 255, 0.308);
  cursor: pointer;
 
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

.comentario{
  grid-area: coment;
  border-radius: 30px;
  background: #F1F1F1;
  height: 350px;
  width: 500px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 25px;
  text-align: center;
  margin: auto;
  border: 1px solid #DADADA;
}

.contenido-comentario {
  width: auto;
  margin: 0;
  padding: 0;
  font-size: 30px;
  font-family: 'Playfair Display', serif;
  font-weight: 600;
  color: #4F4F4F;
}

.icono-comentario {
  width: 70px;
  height: 70px;
  border: 1px solid #C7C7C7;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #FFFFFF;
  transition: 0.3s ease;
}

.icono-comentario a {
  color: #666666;
  font-size: 28px;
}

.icono-comentario:hover {
  background-color: #E2E2E2;
  transform: scale(1.05);
}

@media (max-width: 768px) {

  body {
    display: block;
    margin: 0;
    overflow-x: hidden;
  }
  .banner-img {
    width: 100%;
    height: auto;
    display: block;
  }
  .img-logo {
    width: 180px;
    height: auto;
    top: 0;
    margin: 20px auto;
    background: transparent;
  }

  .img-logo img {
    width: 100%;
    height: auto;
  }

  .caja-correo {
    position: absolute;
    width: 100%;
    left: 0;
    top: 65%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    padding: 0 15px;
    box-sizing: border-box;
  }

  .input-correo {
    width: 70%;
    height: 50px;
    font-size: 14px;
  }

  .boton-enviar {
    width: 70px;
    height: 50px;
  }
  .titulo-productos {
    position: relative;
    width: 100%;
    height: auto;
    left: 0;
    top: 0;
    margin: 40px 0 20px;
    text-align: center;
    font-size: 25px;
    background-color: white;
  }

  .titulo-productos h2 {
    font-size: 28px;
    margin: 0;
  }

  .productos {
    position: relative;
    top: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    padding: 20px 20px 60px;
    background-color: white;
  }

  .producto {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .rectangulo-titulo {
    width: 90%;
    max-width: 300px;
    height: auto;
    min-height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 22px;
    background-color: white;
  }

  .rectangulo-titulo p {
    margin: 10px 0;
  }

  .cuadro-grande {
    width: 90%;
    max-width: 320px;
    height: 400px;
    border-radius: 50px;
  }

  .cuadro-grande img {
    width: 100%;
    height: 100%;
    border-radius: 50px;
    object-fit: cover;
  }

  .rectangulo-info {
    width: 90%;
    max-width: 300px;
    height: auto;
    min-height: 95px;
    padding: 10px;
    box-sizing: border-box;
    text-align: center;
    font-size: 18px;
  }

  .rectangulo-info p {
    margin: 10px;
  }

  .contenido {
    width: 100%;
    height: auto;
    min-height: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
    padding: 50px 20px;
    box-sizing: border-box;
    text-align: center;
  }

  .texto-contenido {
    width: 100%;
    padding: 0;
    margin: 0;
    font-size: 16px;
    line-height: 1.7;
    text-align: justify;
    box-sizing: border-box;
  }

  .img-contenido {
    width: 90%;
    max-width: 320px;
    height: 320px;
    border-radius: 40px;
    object-fit: cover;
  }

  .comentario {
    width: 90%;
    max-width: 500px;
    height: auto;
    min-height: 280px;
    margin: 40px auto;
    padding: 30px 20px;
    box-sizing: border-box;
    gap: 20px;
  }

  .contenido-comentario {
    width: 100%;
    font-size: 24px;
    text-align: center;
  }

  .contenido-comentario p {
    margin: 0;
  }

  .icono-comentario {
    width: 65px;
    height: 65px;
  }

  .icono-comentario a {
    font-size: 25px;
  }
}


</style>
</head>


<body>

<?php include("../includes/header.php"); ?>
  <section>
    <img src="../img/banner4 - Copy.png" alt="Banner" class="banner-img" id="banner">
  </section>


  <div class="titulo-productos"><h2>Productos Destacados</h2></div>

  <section class="productos">

    <div class="producto">
    <div class="rectangulo-titulo"><p><center>Crema Facial</center></p></div>
    <div class="cuadro-grande">
    <img src="../img/zproducto1.jpg" alt=""></div>
    <div class="rectangulo-info"><center><p>Hidrata,protege y mantiene el equilibrio de la humedad del rostro para una piel saludable </p></center></div></div>

    <div class="producto">
    <div class="rectangulo-titulo"><p><center>Retinol</center></p></div>
    <div class="cuadro-grande">
    <img src="../img/zproducto2.jpg" alt=""></div>
    <div class="rectangulo-info"><center><p>Reduce arrugas, manchas y acne mejorando la textura de la piel</p></center></div></div>

    <div class="producto">
    <div class="rectangulo-titulo"><p><center>Crema Corporal </center></p></div>
    <div class="cuadro-grande">
    <img src="../img/zproducto3.png" alt=""></div>
    <div class="rectangulo-info"><center><p>Hidrata, suaviza y protege la piel del cuerpo evitando resequedad para prevenir irritaciones </p></center></div></div>

    <div class="producto">
    <div class="rectangulo-titulo"><center><p>Base en polvo</p></center></div>
    <div class="cuadro-grande">
    <img src="../img/zproducto4.png" alt=""></div>
    <div class="rectangulo-info"><center><p>Ayuda a unificar el tono de la piel, dando un acabado mate al rostro que cubre imperfecciones y sella el maquillaje liquido</p></center></div></div>
</section>


<section class="contenido">
  <div class="texto-contenido">
    <p>En Natue creemos en una belleza responsable y en equilibrio con la naturaleza.
      Nuestro propósito es promover un estilo de vida sostenible, impulsando el cuidado
      personal que también protege el medio ambiente.
      Trabajamos para crear conciencia sobre el impacto de nuestras decisiones diarias
      y fomentar prácticas que contribuyan al bienestar de las personas y del planeta.</p></div>
    <img src="../img/nos.png" alt="Orgánico y natural" class="img-contenido">
</section>

<section class="comentario">
  
  <div class="contenido-comentario">
    <p>Déjanos tus comentarios</p>
  </div>

  <div class="icono-comentario">
    <a href="comentario.php">
      <i class="fa-regular fa-comment-dots"></i>
    </a>
  </div>

</section>
<?php include("../includes/footer.php"); ?>
</body>
</html>