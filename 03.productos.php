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
    "caja5"
    "pie";
 gap: 10px;

}

h2 {
    font-size: 28px;
}

h3{
    color: #000000;
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

<?php include("header.php");?>
<h2 id="titulo1"></h2>
<div class="caja" id="caja1">
    <a href="descripcionproductos/serumdecoco.php"><div class="producto"><img src="./img/zpr2.jpeg" alt="" class=""  >
      <h3>Serum de Coco</h3>
      <h3>Codigo:PRD-001</h3>   
      <h3>Precio:45Bs</h3>
      </div>
      </a>
      
    <a href="descripcionproductos/despigmentanteachachairu.php"><div class="producto"><img src="./img/zpr6.jpeg" alt="" class="">
    <h3>Despigmentante de Achachairu</h3>
    <h3>Codigo: PRD-002</h3>
    <h3>Precio: 55 Bs</h3></div>
    </a>

     <a href="descripcionproductos/serumtamarindo.php"><div class="producto"><img src="./img/zpr19.jpeg" alt="" class="">
    <h3>Serum de Tamarindo</h3>
    <h3>Codigo: PRD-003</h3>
    <h3>Precio: 48 Bs</h3></div>
    </a>

     <a href="descripcionproductos/aceitecacao.php"><div class="producto"><img src="./img/zpr16.jpeg" alt="" class="">
    <h3>Aceite Antiestres de Cacao</h3>
    <h3>Codigo: PRD-004</h3>
    <h3>Precio: 40 Bs</h3></div>
    </a>

     <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr18.jpeg" alt="" class="">
    <h3>Serum de Chirimoya</h3>
    <h3>Codigo: PRD-005</h3>
    <h3>Precio: 47 Bs</h3></div>
    </a>

     <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr21.jpeg" alt="" class="">
    <h3>Flores de Kantuta</h3>
    <h3>Codigo: PRD-006</h3>
    <h3>Precio: 35 Bs</h3></div>
    </a>

   <a href="16.formproductos.php"> <div class="producto"><img src="./img/zpr22.jpeg" alt="" class="">
    <h3>Aceite de Copaiba</h3>
    <h3>Codigo: PRD-007</h3>
    <h3>Precio: 50 Bs</h3></div>
   </a>
</div>

<h2 id="titulo2"></h2>
<div class="caja" id="caja2">
     <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr11.jpeg" alt="" class="">
    <h3>Gel de Quinua</h3>
    <h3>Codigo: PRD-008</h3>
    <h3>Precio: 33 Bs</h3></div>
</a>

     <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr5.jpeg" alt="" class="">
    <h3>Gel de Pepino</h3>
    <h3>Codigo: PRD-009</h3>
    <h3>Precio: 30 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr7.jpeg" alt="" class="">
    <h3>Gel de Sabila</h3>
    <h3>Codigo: PRD-010</h3>
    <h3>Precio: 28 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr14.jpeg" alt="" class="">
    <h3>Aceite de Coco</h3>
    <h3>Codigo: PRD-011</h3>
    <h3>Precio: 38 Bs</h3></div>
    </a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr24.jpeg" alt="" class="">
    <h3>Bruma de Eucalipto</h3>
    <h3>Codigo: PRD-012</h3>
    <h3>Precio: 32 Bs</h3></div>
</div>

<h2 id="titulo3"></h2>
<div class="caja" id="caja3">
    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr3.jpeg" alt="" class="">
    <h3>Suavizante de Papaya</h3>
    <h3>Codigo: PRD-013</h3>
    <h3>Precio: 30 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr4.jpeg" alt="" class="">
    <h3>Balsamo de Matico</h3>
    <h3>Codigo: PRD-014</h3>
    <h3>Precio: 42 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr8.jpeg" alt="" class="">
    <h3>Crema de Maracuya y Sabila</h3>
    <h3>Codigo: PRD-015</h3>
    <h3>Precio: 37 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr23.jpeg" alt="" class="">
    <h3>Exfoliente de Cafe</h3>
    <h3>Codigo: PRD-016</h3>
    <h3>Precio: 34 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr25.jpeg" alt="" class="">
    <h3>Crema Matificante</h3>
    <h3>Codigo: PRD-017</h3>
    <h3>Precio: 39 Bs</h3></div>
</a>
</div>

<h2 id="titulo4"></h2>
<div class="caja" id="caja4">
    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr9.jpeg" alt="" class="">
    <h3>Jabon de Semilla de Tarwi</h3>
    <h3>Codigo: PRD-018</h3>
    <h3>Precio: 18 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr44.jpeg" alt="" class="">
    <h3>Jabon de Avena y Miel</h3>
    <h3>Codigo: PRD-019</h3>
    <h3>Precio: 20 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr45.jpeg" alt="" class="">
    <h3>Jabon de Rosa Mosqueta</h3>
    <h3>Codigo: PRD-020</h3>
    <h3>Precio: 22 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr46.jpeg" alt="" class="">
    <h3>Jabon de Curcuma y Manzanilla</h3>
    <h3>Codigo: PRD-021</h3>
    <h3>Precio: 20 Bs</h3></div>
</a>

    <a href="16.formproductos.php"><div class="producto"><img src="./img/zpr47.jpeg" alt="" class="">
    <h3>Jabon de Carbon Activado</h3>
    <h3>Codigo: PRD-022</h3>
    <h3>Precio: 22 Bs</h3></div>
</a>
</div>
<?php include("footer.php");?>
</body>
</html>