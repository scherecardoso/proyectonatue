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
  font-family: 'Open Sans', sans-serif;
  color: black;
  grid-template-areas:
    "barra"
    "banner"
    "nompro"
    "productos"
    "contenido"
    "pie";
  }


header {
  grid-area: barra;
  background-color: #ffffffb5;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 120px;
  top: 0;
  position: sticky;
  height: 60px;
  z-index: 100;
  }

.logo {
  font-family: 'Playfair Display', serif;
  font-size: 13px;
  color: #000000;
  margin: 0;
  }


nav {
  display: flex;
  align-items: center;
  gap: 40px;
  }


nav ul {
  list-style: none;
  display: flex;
  gap: 25px;

  }



nav a {
  text-decoration: none;
  color: #2b2b2b;
  font-weight: 500px;
  font-size: 15px;
  position: relative;
  }

nav a.activo:after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -6px;
  width: 100%;
  height: 1px;
  background-color: #333333;
  }

.iconos-barra {
  display: flex;
  align-items: center;
  gap: 25px;
  }

.iconos-barra a {
  color: #2b2b2b;
  text-decoration: none;
  font-size: 18px;
  position: relative;
  }

    .bloque {
      display: flex;
      align-items:relative;
      padding: 10px;
      gap: 40px;
      border: 2px solid #e5e5e5;
      border-radius: 25px;
      background: #ffffffa8;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 93%;
    }

    .bloque img {
      width: 550px;
      height: 450px;
      border-radius: 20px;
      left: 200px;
      position: relative;
    }

    .bloque-texto {
      width: 50%;
      font-family: 'Open Sans', sans-serif;
      font-size: 20px;
      position: relative;
      left: 30px;
    }


@media (max-width: 768px) {
  header {
    padding: 20px;
    gap: 0px;
    height: 130px; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
   
  }

  .iconos-barra {
    display: flex;
    flex-direction: row;
 
  }

  .iconos-barra a {
      display: flex;
    flex-direction: row;
    gap: -100px;

  }.bloque{
    flex-direction: column;
    width: 90%;
    padding: 20px;
    gap: 20px;
    align-items: center;
}

.bloque img{
    width: 100%;
    max-width: 300px;
    height: auto;
    left: 0;
}

.bloque-texto{
    width: 100%;
    left: 0;
    font-size: 16px;
    text-align: center;
}}

  </style>
</head>
<body>
<header>
  <div class="logo">
  <h1>Natué</h1>
  </div>

  <nav>
   <ul>
   <li><a href="02.inicio.php" >Inicio</a></li>
   <li><a href="03.productos.php">Cuidado</a></li>
   <li><a href="04.productos2.php">Cosmeticos</a></li>
   <li><a href="05.Acercade.php"class="activo">Nosotros</a></li>
   </ul>
  </nav>


  <div class="iconos-barra">
   <a href="09.register.php"><i class="fa-solid fa-user"></i> <span style="font-size:14px; margin-left:5px;"></span></a>
   <a href="formProductos.php"><i class="fa-solid fa-bag-shopping"></i></a>
  </div>
</header>
<section class="contenido" style="display:flex; flex-direction:column; align-items:center; gap:60px; padding:60px 0;">

  <div class="bloque">
    <div class="bloque-texto">
      <h2>MISIÓN</h2>
      <p>En NATUE trabajamos con dedicación para crear cosméticos naturales y accesibles, 
        elaborados con ingredientes de origen boliviano y procesos que respetan la salud 
        y el medio ambiente.
        nuestra misión es ofrecer productos de calidad que reflejen el amor por la naturaleza 
        y el talento de los jovenes bolivianos que los hacen posible.

        Buscamos impulsar el empoderamiento de la juventud brindando oportunidades de aprendizaje 
        y desarrollo a jovenes emprendedores, para que sean parte activa de la transformación 
        productiva del país.
        Cada producto NATUE representa un pequeño aporte hacia una Bolivia más fuerte, sostenible 
        y consciente, donde la belleza y el bienestar estén verdaderamente en nuestras manos.</p>
    </div>
    <img src="./img/mision.jpg">
  </div>

  <div class="bloque">
    <div class="bloque-texto">
      <h2>VISIÓN</h2>
      <p>En NATUE soñamos con convertirnos en una marca boliviana reconocida por crear cosméticos 
        naturales que resalten la belleza auténtica de las personas y promuevan el cuidado del 
        medio ambiente.
        Como una empresa que recién está surgiendo, nuestra visión es crecer paso a paso con 
        esfuerzo, compromiso y pasión , aprovechando los recursos naturales de nuestra tierra 
        de forma responsable.
        Queremos ser un ejemplo de emprendimiento joven y sostenible, que inspire a la comunidad 
        a creer en sus capacidades, a generar sus propios proyectos y a construir, junto a nosotros, 
        una nueva Bolivia en sus manos: más consciente, más bella y más unida con la naturaleza.</p>
    </div>
    <img src="./img/vision.png">
  </div>



</section>

</body>
</html>