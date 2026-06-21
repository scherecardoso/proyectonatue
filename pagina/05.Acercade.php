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
    "mision"
    "vision"
    "equipo"
    "valores"
    "pie";
  }
.contenido{
  display:flex; 
  flex-direction:column; 
  align-items:center; 
  gap:60px; 
  padding:80px 0;
}
.contenido h1{
    font-family:'Playfair Display', serif;
    font-size:52px;
    margin-bottom:20px;
}
.contenido p {
  text-align: center;
  max-width: 700px;
  line-height: 1.6;
  font-size: 18px;
}

.bloque-nosotros{
  width: 100%;
  text-align: center;
  background-color: white;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 60px 20px;
}



.bloque-nosotros p{
  max-width: 800px;
  line-height: 1.6;
  font-size: 18px;
}



.bloque {
  display: flex;
  justify-content: space-between;
  gap: 40px;
  width: 85%;
  margin: auto;
}

.mision, .vision {
  width: 50%;
  background: white;
  padding: 40px;
  border-radius: 25px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}



    .bloque-texto {
      width: 50%;
      font-family: 'Open Sans', sans-serif;
      font-size: 20px;
      position: relative;
      left: 30px;
    }

.bloque-texto h2{
  font-family: 'Playfair Display', serif;
  color: #caa3a9;
}

.bloque-texto h2::after{
  content:"";
  display:block;
  width:35px;
  height:2px;
  background:#d8bfc4;
  margin-top:8px;
}


.valores{
  grid-area: valores;
  width:85%;
  margin: 0 auto;
  padding:50px;
  border-radius:25px;
  background:white;
  text-align:center;
}

.valores h2{
  font-family:'Playfair Display', serif;
}

.valores-grid{
  display:grid;
  grid-template-columns: repeat(4, 1fr);
  gap:25px;
  margin-top:30px;
}

.valor{
  background:white;
  padding:25px;
  border-radius:20px;
  box-shadow:0 5px 15px rgba(0,0,0,0.05);
  transition:0.3s;
}

.valor:hover{
  transform:translateY(-5px);
}

.valor i{
  font-size:22px;
  color:pink;
  margin-bottom:10px;
}
.equipo{
  grid-area: equipo;
  width:85%;
  text-align:center;
  margin: 40px auto;
}

.equipo h2{
  font-family:'Playfair Display', serif;
}

.equipo-grid{
  display:grid;
  grid-template-columns: repeat(4, 1fr);
  gap:25px;
  margin-top:30px;
}

.miembro{
  background:white;
  padding:20px;
  border-radius:20px;
  box-shadow:0 5px 15px rgba(0,0,0,0.05);
  transition:0.3s;
}



.miembro img{
  width:100%;
  height: 76%;
  border-radius:100%;
  margin-bottom:10px;
}

.miembro h4{
  margin:5px 0;
}

.miembro p{
  color:#888;
  font-size:14px;
}

@media (max-width: 768px) {
  .bloque{
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
<?php include("../includes/header.php");?>
<section class="contenido" style="display:flex; flex-direction:column; align-items:center; gap:60px; padding:60px 0;">

<h1>Nosotros</h1>

  <p>NATUE es una marca boliviana de cosméticos naturales 
    creada por jóvenes emprendedores, comprometida con el 
    cuidado del medio ambiente y la belleza auténtica. 
    Buscamos inspirar a las personas a valorar lo natural, 
    promover el talento local y construir una Bolivia más
     consciente y sostenible.</p>

</h1>
<div class="bloque">

  <div class="mision">
    <h2>MISIÓN</h2>
    <p>En NATUE creamos cosméticos naturales y accesibles con ingredientes bolivianos, cuidando la salud y el medio ambiente. Buscamos reflejar la belleza de la naturaleza y el talento joven, impulsando el emprendimiento y el desarrollo sostenible en Bolivia. Cada producto representa nuestro compromiso con un futuro más consciente y responsable.</p>
  </div>

    <div class="vision">
      <h2>VISIÓN</h2>
      <p>En NATUE soñamos con ser una marca boliviana reconocida por cosméticos naturales que realzan la belleza auténtica y cuidan el medio ambiente. Queremos crecer con esfuerzo y responsabilidad, usando los recursos de nuestra tierra de forma sostenible. Aspiramos a ser un ejemplo de emprendimiento joven que inspire a crear proyectos y construir una Bolivia más consciente y unida con la naturaleza.</p>
  
  </div>
</section>
<section class="equipo">

  <h2>Nuestro equipo</h2>

  <div class="equipo-grid">

    <div class="miembro">
      <img src="../img/.angie.png">
      <h4>Angie Alba</h4>
      <p>Representante Legal</p>
    </div>

    <div class="miembro">
      <img src="../img/.jess.png">
      <h4>Jessenia Copa</h4>
      <p>Jefa de Desarrollo</p>
    </div>

    <div class="miembro">
      <img src="../img/.sheshe.png">
      <h4>Scherezade Cardozo</h4>
      <p>Jefa de Base de Datos</p>
    </div>

    <div class="miembro">
      <img src="../img/.nahia.png">
      <h4>Nahia Agreda</h4>
      <p>Jefa de Control</p>
    </div>

  </div>

</section>
<section class="valores">

  <h2>Nuestros valores</h2>

  <div class="valores-grid">

    <div class="valor">
      <i class="fa-solid fa-leaf"></i>
      <h4>Ingredientes naturales</h4>
      <p>Fórmulas suaves y efectivas</p>
    </div>

    <div class="valor">
      <i class="fa-solid fa-paw"></i>
      <h4>Cruelty free</h4>
      <p>No testeamos en animales</p>
    </div>

    <div class="valor">
      <i class="fa-solid fa-recycle"></i>
      <h4>Eco friendly</h4>
      <p>Envases responsables</p>
    </div>

    <div class="valor">
      <i class="fa-solid fa-droplet"></i>
      <h4>Cuidado consciente</h4>
      <p>Bienestar para tu piel</p>
    </div>

  </div>

</section>
<?php include("../includes/footer.php");?>
</body>
</html>