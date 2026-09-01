```php
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

h3 {
    color: black;
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
    color: black;
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

.caja a {
    text-decoration: none;
    color: inherit;
}

/* FAVORITOS */

.form-favorito {
    margin-top: 10px;
}

.corazon {
    border: none;
    background: transparent;
    font-size: 30px;
    color: #ff5ca8;
    cursor: pointer;
    transition: 0.3s;
}

.corazon:hover {
    transform: scale(1.2);
    color: #ff2f8a;
}

@media (max-width: 768px) {

.caja {
    gap: 15px;
    padding: 10px;
    margin-top: 0px;
}

.producto {
    min-width: 220px;
    padding: 10px;
    border-radius: 15px;
}

.producto img {
    height: 250px;
    border-radius: 12px;
}

.producto h3 {
    font-size: 14px;
}

.corazon {
    font-size: 26px;
}

}

</style>
</head>

<body>

<?php include("../includes/header.php");?>

<h2 id="titulo1"></h2>

<!-- PRODUCTOS 23 AL 28 -->

<div class="caja" id="caja1">

    <div class="producto">
        <a href="../descripcionproductos/desmaquillantedechia.php">
            <img src="../img/zpr1.jpeg" alt="">
            <h3>Desmaquillante de Chia</h3>
            <h3>Codigo: PRD-023</h3>
            <h3>Precio: 28 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="23">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/desmaquillantemanzanillayav.php">
            <img src="../img/zpr34.jpeg" alt="">
            <h3>Desmaquillante de Manzanilla y Avena</h3>
            <h3>Codigo: PRD-024</h3>
            <h3>Precio: 30 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="24">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/desmaquillantedeuva.php">
            <img src="../img/zpr33.jpeg" alt="">
            <h3>Desmaquillante de Uva Morada</h3>
            <h3>Codigo: PRD-025</h3>
            <h3>Precio: 32 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="25">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/desmaquillantedepepino.php">
            <img src="../img/zpr31.jpeg" alt="">
            <h3>Desmaquillante de Pepino</h3>
            <h3>Codigo: PRD-026</h3>
            <h3>Precio: 27 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="26">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/desmaquillantedelechecoco.php">
            <img src="../img/zpr32.jpeg" alt="">
            <h3>Desmaquillante Leche de Coco</h3>
            <h3>Codigo: PRD-027</h3>
            <h3>Precio: 29 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="27">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/desmaquillantederosas.php">
            <img src="../img/zpr30.jpeg" alt="">
            <h3>Desmaquillante de Agua de Rosas</h3>
            <h3>Codigo: PRD-028</h3>
            <h3>Precio: 28 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="28">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>

</div>


<!-- PRODUCTOS 29 AL 33 -->

<div class="caja" id="caja2">

    <div class="producto">
        <a href="../descripcionproductos/balsamocastaña.php">
            <img src="../img/zpr12.jpeg" alt="">
            <h3>Balsamo de Castaña</h3>
            <h3>Codigo: PRD-029</h3>
            <h3>Precio: 20 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="29">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/balsamoframbuesa.php">
            <img src="../img/zpr27.jpeg" alt="">
            <h3>Balsamo de Frambuesa</h3>
            <h3>Codigo: PRD-030</h3>
            <h3>Precio: 20 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="30">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/balsamomaracuya.php">
            <img src="../img/zpr28.jpeg" alt="">
            <h3>Balsamo de Maracuya</h3>
            <h3>Codigo: PRD-031</h3>
            <h3>Precio: 20 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="31">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/balsamovainillaycoco.php">
            <img src="../img/zpr29.jpeg" alt="">
            <h3>Balsamo de Vainilla y Coco</h3>
            <h3>Codigo: PRD-032</h3>
            <h3>Precio: 22 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="32">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/balsamofrutilla.php">
            <img src="../img/zpr26.jpeg" alt="">
            <h3>Balsamo de Frutilla</h3>
            <h3>Codigo: PRD-033</h3>
            <h3>Precio: 20 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="33">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>

</div>


<!-- PRODUCTOS 34 AL 38 -->

<div class="caja" id="caja3">

    <div class="producto">
        <a href="../descripcionproductos/perfumeorquidea.php">
            <img src="../img/zpr13.jpeg" alt="">
            <h3>Perfume Solido de Orquidea</h3>
            <h3>Codigo: PRD-034</h3>
            <h3>Precio: 35 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="34">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/perfumebergamota.php">
            <img src="../img/zpr35.jpeg" alt="">
            <h3>Perfume Solido de Bergamota</h3>
            <h3>Codigo: PRD-035</h3>
            <h3>Precio: 35 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="35">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/perfumefrutillayrosas.php">
            <img src="../img/zpr36.jpeg" alt="">
            <h3>Perfume Solido de Frutilla y Petalos de Rosa</h3>
            <h3>Codigo: PRD-036</h3>
            <h3>Precio: 38 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="36">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/perfumevainillayflores.php">
            <img src="../img/zpr37.jpeg" alt="">
            <h3>Perfume Solido de Vainilla y Flores Blancas</h3>
            <h3>Codigo: PRD-037</h3>
            <h3>Precio: 38 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="37">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/perfumejazmin.php">
            <img src="../img/zpr39.jpeg" alt="">
            <h3>Perfume Solido de Jazmin</h3>
            <h3>Codigo: PRD-038</h3>
            <h3>Precio: 35 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="38">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>

</div>


<!-- PRODUCTOS 39 AL 43 -->

<div class="caja" id="caja4">

    <div class="producto">
        <a href="../descripcionproductos/polvomaiz.php">
            <img src="../img/zpr17.jpeg" alt="">
            <h3>Polvo Maiz Morado</h3>
            <h3>Codigo: PRD-039</h3>
            <h3>Precio: 18 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="39">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/polvoarcilla.php">
            <img src="../img/zpr40.jpeg" alt="">
            <h3>Polvo Arcilla Rosada</h3>
            <h3>Codigo: PRD-040</h3>
            <h3>Precio: 20 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="40">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/polvoteverde.php">
            <img src="../img/zpr42.jpeg" alt="">
            <h3>Polvo Te Verde</h3>
            <h3>Codigo: PRD-041</h3>
            <h3>Precio: 18 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="41">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/polvoavena.php">
            <img src="../img/zpr41.jpeg" alt="">
            <h3>Polvo Avena Coloidal</h3>
            <h3>Codigo: PRD-042</h3>
            <h3>Precio: 17 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="42">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>


    <div class="producto">
        <a href="../descripcionproductos/polvoremolacha.php">
            <img src="../img/zpr43.jpeg" alt="">
            <h3>Polvo de Remolacha</h3>
            <h3>Codigo: PRD-043</h3>
            <h3>Precio: 18 Bs</h3>
        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">
            <input type="hidden" name="codigo" value="43">
            <button class="corazon" type="submit">♡</button>
        </form>
    </div>

</div>

<?php include("../includes/footer.php");?>

</body>
</html>
```
