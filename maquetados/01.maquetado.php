<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>


body {
  margin: 0;
  font-family: 'Open Sans', sans-serif;
  color: black;
  display: grid;
  grid-template-areas:
    "barra"
    "banner"
    "imagenes"
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
  position: sticky;
  top: 0;
  height: 80px;
  z-index: 100;
  }

.logo h1 {
  font-family: 'Playfair Display', serif;
  font-size: 36px;
  color: #2b2b2b;
  font-weight: 500;
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
  margin: 0;
  padding: 0;
  }

nav a {
  text-decoration: none;
  color: #2b2b2b;
  font-weight: 500;
  font-size: 15px;
  position: relative;
  transition: color 0.3s ease;
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
  transition: color 0.3s ease;
  }

.banner {
  grid-area: banner;
  background-color: pink;
  height: 900px;
  position: relative;
  }

.banner img {
  height: 100%;
  position: absolute;
  z-index: 1;
  }

.img-logo {
  width: 360px;
  height: 300px;
  top: 60px;
  position: absolute;
  left: 170px;
  background-color: #000000;
  }

.boton {
  position: absolute;
  top: 450px;
  left: 350px;
  background-color: rgba(255, 255, 255, 0.308);
  padding: 30px 90px;
  text-decoration: none;
  font-weight: 500px;
  border: 1px solid #ffffffa7;
  border-radius: 50px;
  transition: all 0.3s ease;
  font-size: 25px;
  color: #ffffff;
  letter-spacing: 1px;
  z-index: 2;
  }

.boton:hover {
  background-color: #fff;
  color: white;
  }

.imagenes {
  grid-area: imagenes;
  display: flex;
  justify-content: space-evenly;
  align-items: flex-start;
  position: relative;
  width: 100%;
  height: 600px;
  margin: 0 auto;
  background-color: #ffffff;
  top: 90px;
  }

.imagenes img {
  width: 350px;
  height: 390px;
  object-fit: cover;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 8px;
  background-color: #ff9d9d;
  }

.contenido {
  grid-area: contenido;
  background-color: rgb(255, 255, 255);
  height: 700px;
  display: flex;
  align-items: center;
  gap: 50px; 
}

.texto-contenido {
  width: 50%; 
  padding-left: 50px;
  margin-top: -78px;
}  

.img-contenido {
  width: 550px;
  height: 550px;
  object-fit: cover;
  top: 50px;
  position: relative;
  left: 90px;
  background-color: #eda5a5;
  }

footer {
  grid-area: pie;
  background-color: rgb(240, 194, 204);
  padding: 60px 8% 25px;
  }

.contenedor-pie {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 40px;
  margin-bottom: 40px;
  }

.seccion-pie {
  flex: 1;
  min-width: 250px;
  }

.seccion-pie h4 {
  font-family: 'Playfair Display', serif;
  font-size: 18px;
  color: #000000;
  margin-bottom: 10px;
  font-weight: 600;
  }

.seccion-pie p {
  color: #000000;
  line-height: 1.6;
  font-size: 14px;
  }

.iconos-redes {
  display: flex;
  gap: 20px;
  margin-top: 10px;
  }

.iconos-redes a {
  color: #2b2b2b;
  font-size: 18px;
  transition: color 0.3s ease;
  }

.formulario-correo {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 15px;
  }


@media (max-width: 600px) {

  header {
    flex-direction: column;
    padding: 10px;
    height: 75px;
    gap: 10px;
    flex-wrap: nowrap;
  }

  .logo h1 {
    font-size: 20px;
  }

  nav {
    display: flex;
    align-items: center;
    gap: 40px;
  }  
  
  nav ul {
    flex-direction: column;
    gap: 3px;
    text-align: center;
  }

  nav a {
    font-size: 11px;
  }

  .iconos-barra {
    justify-content: right;
    gap: 5px;
  }

  .iconos-barra a {
    font-size: 10px;

  }

  .banner {
    height: 300px;
  }

  .banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .boton {
    top: 60%;
    left: 50%;
    transform: translateX(-50%);
    padding: 15px 40px;
    font-size: 18px;
  }

  .imagenes {
    flex-direction: column;
    align-items: center;
    width: 400px;
    height: 600px;
    gap: 20px;
    top: 40px;
  }

  .imagenes img {
    width: 80%;
    height: auto;
  }

  .contenido {
    flex-direction: column;
    align-items: center;
    text-align: center;
    height: auto;
    padding: 20px;
  }

  .texto-contenido {
    width: 90%;
    padding: 0;
    margin-top: 0;
  }

  .img-contenido {
    width: 80%;
    height: auto;
    left: 0;
  }

  footer {
    padding: 30px 5%;
  }


}
</style>
</head>
<body>


<header>
  <div class="logo">
  <h1></h1>
  </div>

  <nav>
   <ul>
   <li><a href="Inicio.html" class="activo"></a></li>
   <li><a href="Esencias.html"></a></li>
   <li><a href="Aceites.html"></a></li>
   <li><a href="Pedidos.html"></a></li>
   <li><a href="Contactanos.html"></a></li>
   </ul>
  </nav>
</header>



<section class="banner">
   <img class="banner">
   <a href="boton" class="boton"></a>
   </seccion>
</section>



<section class="imagenes">
   <img class="imagenes img">
   <img class="imagenes img">
   <img class="imagenes img">
   <img class="imagenes img">
</section>


<section class="contenido">
  <div class="texto-contenido">
  </div>

  <img class="img-contenido">
</section>
   


<footer>
  <div class="contenedor-pie">
  <div class="seccion-pie">
  </div>

  <div class="seccion-pie">

  <div class="pie-final">
  </div>
</footer>

</body>
</html>