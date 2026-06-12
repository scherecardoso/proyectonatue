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
    "titulo1"
    "caja1"
    "titulo2"
    "caja2"
    "titulo3"
    "caja3"
    "titulo4"
    "caja4"
    "titulo5"
    "caja5";
 gap: 10px;

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




h2 {
    font-size: 28px;
}


h3 {
    color:black;
}


#titulo1 { 
    grid-area: titulo1; 
}

#titulo2 { 
    grid-area: titulo2; 
}

#titulo3 { 
    grid-area: titulo3; 
}
#titulo4 { 
    grid-area: titulo4; 
}
#titulo5 {
    grid-area: titulo5; 
}


.caja {
    display: flex;
    gap: 25px;
    overflow-x: auto;
    padding: 20px;
}


#caja1 { 
    grid-area: caja1; 
}

#caja2 {
    grid-area: caja2; 
}

#caja3 { 
    grid-area: caja3; 
}
#caja4 { 
    grid-area: caja4; 
}
#caja5 { 
    grid-area: caja5; 
}


.producto {
    min-width: 350px;
    border-radius: 18px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color:black;
}
.producto:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.producto img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 15px;
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

  }
.caja{
    gap: 15px;
    padding: 10px;
    margin-top:0px;
}

.producto{
    min-width: 220px;
    padding: 10px;
    border-radius: 15px;
}

.producto img{
    height: 250px;
    border-radius: 12px;
}

.producto h3{
    font-size: 14px;


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
   <li><a href="02.inicio.php">Inicio</a></li>
   <li><a href="03.productos.php" >Cuidado</a></li>
   <li><a href="04.productos2.php"class="activo">Cosmeticos</a></li>
   <li><a href="05.Acercade.php">Nosotros</a></li>
   </ul>
  </nav>


  <div class="iconos-barra">
   <a href="09.register.php"><i class="fa-solid fa-user"></i> <span style="font-size:14px; margin-left:5px;"></span></a>
   <a href="formProductos.php"><i class="fa-solid fa-bag-shopping"></i></a>
  </div>
</header>


<h2 id="titulo1"></h2>
<div class="caja" id="caja1">

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr1.jpeg" alt="" class="">
    <h3>Desmaquillante de Chic</h3>
    <h3>Codigo: PRD-023</h3>
    <h3>Precio: 28 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr34.jpeg" alt="" class="">
    <h3>Desmaquillante de Manzanilla y Avena</h3>
    <h3>Codigo: PRD-024</h3>
    <h3>Precio: 30 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr33.jpeg" alt="" class="">
       <h3>Desmaquillante de Uva Morada</h3>
    <h3>Codigo: PRD-025</h3>
    <h3>Precio: 32 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr31.jpeg" alt="" class="">
    <h3>Desmaquillante de Pepino</h3>
    <h3>Codigo: PRD-026</h3>
    <h3>Precio: 27 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr32.jpeg" alt="" class="">
    <h3>Desmaquillante Leche de Coco</h3>
    <h3>Codigo: PRD-027</h3>
    <h3>Precio: 29 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr30.jpeg" alt="" class="">
    <h3>Desmaquillante de Agua de Rosas</h3>
    <h3>Codigo: PRD-028</h3>
    <h3>Precio: 28 Bs</h3></div>
    </a>
   
</div>

<h2 id="titulo2"></h2>
<div class="caja" id="caja2">

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr12.jpeg" alt="" class="">
    <h3>Balsamo de Castaña</h3>
    <h3>Codigo: PRD-029</h3>
    <h3>Precio: 20 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr27.jpeg" alt="" class="">
    <h3>Balsamo de Frambuesa</h3>
    <h3>Codigo: PRD-030</h3>
    <h3>Precio: 20 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr28.jpeg" alt="" class="">
    <h3>Balsamo de Maracuya</h3>
    <h3>Codigo: PRD-031</h3>
    <h3>Precio: 20 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr29.jpeg" alt="" class="">
    <h3>Balsamo de Vainilla y Coco</h3>
    <h3>Codigo: PRD-032</h3>
    <h3>Precio: 22 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr26.jpeg" alt="" class="">
    <h3>Balsamo de Frutilla</h3>
    <h3>Codigo: PRD-033</h3>
    <h3>Precio: 20 Bs</h3></div>
    </a>

</div>


<h2 id="titulo3"></h2>
<div class="caja" id="caja3">

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr13.jpeg" alt="" class="">
    <h3>Perfume Solido de Orquidea</h3>
    <h3>Codigo: PRD-034</h3>
    <h3>Precio: 35 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr35.jpeg" alt="" class="">
    <h3>Perfume Solido de Bergamota</h3>
    <h3>Codigo: PRD-035</h3>
    <h3>Precio: 35 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr36.jpeg" alt="" class="">
    <h3>Perfume Solido de Frutilla y Petalos de Rosa</h3>
    <h3>Codigo: PRD-036</h3>
    <h3>Precio: 38 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr37.jpeg" alt="" class="">
    <h3>Perfume Solido de Vainilla y Flores Blancas</h3>
    <h3>Codigo: PRD-037</h3>
    <h3>Precio: 38 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr39.jpeg" alt="" class="">
    <h3>Perfume Solido de Jazmin</h3>
    <h3>Codigo: PRD-038</h3>
    <h3>Precio: 35 Bs</h3></div>
    </a>

</div>


<h2 id="titulo4"></h2>
<div class="caja" id="caja4">

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr17.jpeg" alt="" class="">
    <h3>Polvo Maiz Morado</h3>
    <h3>Codigo: PRD-039</h3>
    <h3>Precio: 18 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr40.jpeg" alt="" class="">
    <h3>Polvo Arcilla Rosada</h3>
    <h3>Codigo: PRD-040</h3>
    <h3>Precio: 20 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr42.jpeg" alt="" class="">
    <h3>Polvo Te Verde Molido</h3>
    <h3>Codigo: PRD-041</h3>
    <h3>Precio: 18 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr41.jpeg" alt="" class="">
    <h3>Polvo Avena Coloidal</h3>
    <h3>Codigo: PRD-042</h3>
    <h3>Precio: 17 Bs</h3></div>
    </a>

    <a href="formProductos.php"><div class="producto"><img src="./img/zpr43.jpeg" alt="" class="">
    <h3>Polvo de Remolacha</h3>
    <h3>Codigo: PRD-043</h3>
    <h3>Precio: 18 Bs</h3></div>
    </a>

</div>

</body>
</html>