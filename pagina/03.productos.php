<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
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
    color: #000000;
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


/* TARJETA DEL PRODUCTO */

.producto {
    min-width: 350px;
    border-radius: 18px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: white;
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



/* ENLACE DEL PRODUCTO */

.producto a {
    text-decoration: none;
    color: black;
}


/* CORAZÓN */

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


.caja a {
    text-decoration: none;
    color: inherit;
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

<?php include("../includes/header.php"); ?>


<!-- ================================================= -->
<!-- PRODUCTOS 1 -->
<!-- ================================================= -->

<h2 id="titulo1"></h2>

<div class="caja" id="caja1">


    <!-- PRODUCTO 1 -->
    <div class="producto">

        <a href="../descripcionproductos/SDC.php">

            <img src="../img/zpr2.jpeg" alt="Serum de Coco">

            <h3>Serum de Coco</h3>
            <h3>Codigo: SDC-001</h3>
            <h3>Precio: 45 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="SDC-001">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 2 -->
    <div class="producto">

        <a href="../descripcionproductos/despigmentanteachachairu.php">

            <img src="../img/zpr6.jpeg" alt="Despigmentante de Achachairu">

            <h3>Despigmentante de Achachairu</h3>
            <h3>Codigo: PRD-002</h3>
            <h3>Precio: 55 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-002">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 3 -->
    <div class="producto">

        <a href="../descripcionproductos/serumtamarindo.php">

            <img src="../img/zpr19.jpeg" alt="Serum de Tamarindo">

            <h3>Serum de Tamarindo</h3>
            <h3>Codigo: PRD-003</h3>
            <h3>Precio: 48 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-003">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 4 -->
    <div class="producto">

        <a href="../descripcionproductos/aceitecacao.php">

            <img src="../img/zpr16.jpeg" alt="Aceite Antiestres de Cacao">

            <h3>Aceite Antiestres de Cacao</h3>
            <h3>Codigo: PRD-004</h3>
            <h3>Precio: 40 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-004">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 5 -->
    <div class="producto">

        <a href="../descripcionproductos/serumchirimoya.php">

            <img src="../img/zpr18.jpeg" alt="Serum de Chirimoya">

            <h3>Serum de Chirimoya</h3>
            <h3>Codigo: PRD-005</h3>
            <h3>Precio: 47 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-005">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 6 -->
    <div class="producto">

        <a href="../descripcionproductos/floreskantuta.php">

            <img src="../img/zpr21.jpeg" alt="Flores de Kantuta">

            <h3>Flores de Kantuta</h3>
            <h3>Codigo: PRD-006</h3>
            <h3>Precio: 35 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-006">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 7 -->
    <div class="producto">

        <a href="../descripcionproductos/aceitecopaiba.php">

            <img src="../img/zpr22.jpeg" alt="Aceite de Copaiba">

            <h3>Aceite de Copaiba</h3>
            <h3>Codigo: PRD-007</h3>
            <h3>Precio: 50 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-007">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>

</div>


<!-- ================================================= -->
<!-- PRODUCTOS 2 -->
<!-- ================================================= -->

<div class="caja" id="caja2">


    <!-- PRODUCTO 8 -->
    <div class="producto">

        <a href="../descripcionproductos/geldequinua.php">

            <img src="../img/zpr11.jpeg" alt="Gel de Quinua">

            <h3>Gel de Quinua</h3>
            <h3>Codigo: PRD-008</h3>
            <h3>Precio: 33 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-008">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 9 -->
    <div class="producto">

        <a href="../descripcionproductos/geldepepino.php">

            <img src="../img/zpr5.jpeg" alt="Gel de Pepino">

            <h3>Gel de Pepino</h3>
            <h3>Codigo: PRD-009</h3>
            <h3>Precio: 30 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-009">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 10 -->
    <div class="producto">

        <a href="../descripcionproductos/geldesabila.php">

            <img src="../img/zpr7.jpeg" alt="Gel de Sabila">

            <h3>Gel de Sabila</h3>
            <h3>Codigo: PRD-010</h3>
            <h3>Precio: 28 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-010">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 11 -->
    <div class="producto">

        <a href="../descripcionproductos/aceitedecoco.php">

            <img src="../img/zpr14.jpeg" alt="Aceite de Coco">

            <h3>Aceite de Coco</h3>
            <h3>Codigo: PRD-011</h3>
            <h3>Precio: 38 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-011">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 12 -->
    <div class="producto">

        <a href="../descripcionproductos/brumaeucalipto.php">

            <img src="../img/zpr24.jpeg" alt="Bruma de Eucalipto">

            <h3>Bruma de Eucalipto</h3>
            <h3>Codigo: PRD-012</h3>
            <h3>Precio: 32 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-012">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>

</div>


<!-- ================================================= -->
<!-- PRODUCTOS 3 -->
<!-- ================================================= -->

<div class="caja" id="caja3">


    <!-- PRODUCTO 13 -->
    <div class="producto">

        <a href="../descripcionproductos/suavizantepapaya.php">

            <img src="../img/zpr3.jpeg" alt="Suavizante de Papaya">

            <h3>Suavizante de Papaya</h3>
            <h3>Codigo: PRD-013</h3>
            <h3>Precio: 30 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-013">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 14 -->
    <div class="producto">

        <a href="../descripcionproductos/balsamomatico.php">

            <img src="../img/zpr4.jpeg" alt="Balsamo de Matico">

            <h3>Balsamo de Matico</h3>
            <h3>Codigo: PRD-014</h3>
            <h3>Precio: 42 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-014">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 15 -->
    <div class="producto">

        <a href="../descripcionproductos/cremamaracuyasabila.php">

            <img src="../img/zpr8.jpeg" alt="Crema de Maracuya y Sabila">

            <h3>Crema de Maracuya y Sabila</h3>
            <h3>Codigo: PRD-015</h3>
            <h3>Precio: 37 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-015">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 16 -->
    <div class="producto">

        <a href="../descripcionproductos/exfoliantecafe.php">

            <img src="../img/zpr23.jpeg" alt="Exfoliante de Cafe">

            <h3>Exfoliante de Cafe</h3>
            <h3>Codigo: PRD-016</h3>
            <h3>Precio: 34 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-016">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 17 -->
    <div class="producto">

        <a href="../descripcionproductos/cremamatificante.php">

            <img src="../img/zpr25.jpeg" alt="Crema Matificante">

            <h3>Crema Matificante</h3>
            <h3>Codigo: PRD-017</h3>
            <h3>Precio: 39 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-017">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>

</div>


<!-- ================================================= -->
<!-- PRODUCTOS 4 -->
<!-- ================================================= -->

<div class="caja" id="caja4">


    <!-- PRODUCTO 18 -->
    <div class="producto">

        <a href="../descripcionproductos/jabontarwi.php">

            <img src="../img/zpr9.jpeg" alt="Jabon de Semilla de Tarwi">

            <h3>Jabon de Semilla de Tarwi</h3>
            <h3>Codigo: PRD-018</h3>
            <h3>Precio: 18 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-018">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 19 -->
    <div class="producto">

        <a href="../descripcionproductos/jabonavenaymiel.php">

            <img src="../img/zpr44.jpeg" alt="Jabon de Avena y Miel">

            <h3>Jabon de Avena y Miel</h3>
            <h3>Codigo: PRD-019</h3>
            <h3>Precio: 20 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-019">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 20 -->
    <div class="producto">

        <a href="../descripcionproductos/jabonrosamosqueta.php">

            <img src="../img/zpr45.jpeg" alt="Jabon de Rosa Mosqueta">

            <h3>Jabon de Rosa Mosqueta</h3>
            <h3>Codigo: PRD-020</h3>
            <h3>Precio: 22 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-020">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 21 -->
    <div class="producto">

        <a href="../descripcionproductos/jaboncurcumaymanzanilla.php">

            <img src="../img/zpr46.jpeg" alt="Jabon de Curcuma y Manzanilla">

            <h3>Jabon de Curcuma y Manzanilla</h3>
            <h3>Codigo: PRD-021</h3>
            <h3>Precio: 20 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-021">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>


    <!-- PRODUCTO 22 -->
    <div class="producto">

        <a href="../descripcionproductos/jabondecarbon.php">

            <img src="../img/zpr47.jpeg" alt="Jabon de Carbon Activado">

            <h3>Jabon de Carbon Activado</h3>
            <h3>Codigo: PRD-022</h3>
            <h3>Precio: 22 Bs</h3>

        </a>

        <form class="form-favorito" action="../favoritos/agregar_favorito.php" method="POST">

            <input type="hidden" name="codigo" value="PRD-022">

            <button class="corazon" type="submit">
                ♡
            </button>

        </form>

    </div>

</div>


<?php include("../includes/footer.php"); ?>

</body>
</html>