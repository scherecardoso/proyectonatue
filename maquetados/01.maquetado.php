<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Boceto - Natue</title>

    <style>

        /* ==========================================
           CONFIGURACIÓN GENERAL
        ========================================== */

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;

            background-color: #f2f2f2;

            font-family: Arial, sans-serif;

            color: #666666;
        }


        /* ==========================================
           CONTENEDOR PRINCIPAL
        ========================================== */

        .pagina {
            width: 100%;
            max-width: 1400px;

            margin: 0 auto;

            background-color: #ffffff;
        }


        /* ==========================================
           HEADER
        ========================================== */

        .header {
            height: 90px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 15px 40px;

            background-color: #e8e8e8;

            border-bottom: 2px solid #d2d2d2;
        }


        /* Logo */

        .logo {
            width: 150px;
            height: 45px;

            background-color: #d5d5d5;

            border-radius: 8px;
        }


        /* Menú */

        .menu {
            display: flex;

            gap: 15px;
        }


        .menu-caja {
            width: 80px;
            height: 30px;

            background-color: #eeeeee;

            border-radius: 6px;
        }


        /* Carrito */

        .carrito {
            width: 45px;
            height: 40px;

            background-color: #d0d0d0;

            border-radius: 7px;
        }


        /* ==========================================
           BANNER
        ========================================== */

        .banner {
            width: 100%;
            height: 380px;

            display: flex;
            align-items: center;
            justify-content: center;

            background-color: #f5f5f5;

            border-bottom: 2px solid #dddddd;
        }


        .banner-texto {
            width: 400px;
            height: 80px;

            background-color: #dddddd;

            border-radius: 12px;
        }


        /* ==========================================
           TÍTULO
        ========================================== */

        .titulo {
            padding: 45px 20px 25px;

            text-align: center;
        }


        .titulo-caja {
            width: 300px;
            height: 45px;

            margin: auto;

            background-color: #e5e5e5;

            border-radius: 10px;
        }


        /* ==========================================
           PRODUCTOS
        ========================================== */

        .productos {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 25px;

            padding: 30px 50px 70px;
        }


        /* Tarjeta */

        .producto {
            min-height: 450px;

            padding: 15px;

            background-color: #fafafa;

            border: 2px solid #e0e0e0;

            border-radius: 18px;
        }


        /* Nombre */

        .producto-nombre {
            width: 80%;
            height: 40px;

            margin: 0 auto 15px;

            background-color: #dedede;

            border-radius: 8px;
        }


        /* Imagen */

        .producto-imagen {
            width: 100%;
            height: 270px;

            background-color: #f0f0f0;

            border-radius: 15px;
        }


        /* Descripción */

        .producto-descripcion {
            width: 90%;
            height: 65px;

            margin: 15px auto 0;

            background-color: #e5e5e5;

            border-radius: 10px;
        }


        /* ==========================================
           SECCIÓN INFORMACIÓN
        ========================================== */

        .contenido {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 60px;

            padding: 80px 90px;

            background-color: #f7f7f7;
        }


        /* Texto */

        .texto {
            width: 50%;
        }


        .texto-titulo {
            width: 250px;
            height: 40px;

            margin-bottom: 25px;

            background-color: #dddddd;

            border-radius: 8px;
        }


        .texto-linea {
            width: 100%;
            height: 18px;

            margin-bottom: 12px;

            background-color: #e9e9e9;

            border-radius: 5px;
        }


        .texto-linea.corta {
            width: 75%;
        }


        .texto-linea.muy-corta {
            width: 55%;
        }


        /* Imagen */

        .contenido-imagen {
            width: 420px;
            height: 420px;

            background-color: #eeeeee;

            border-radius: 30px;

            border: 3px solid #d8d8d8;
        }


        /* ==========================================
           COMENTARIOS
        ========================================== */

        .comentario {
            width: 500px;
            min-height: 280px;

            margin: 70px auto;

            padding: 35px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            background-color: #f5f5f5;

            border: 2px solid #dddddd;

            border-radius: 25px;
        }


        .comentario-titulo {
            width: 280px;
            height: 45px;

            background-color: #dcdcdc;

            border-radius: 8px;

            margin-bottom: 30px;
        }


        .comentario-boton {
            width: 65px;
            height: 65px;

            background-color: #bdbdbd;

            border-radius: 50%;

            border: 4px solid #eeeeee;
        }


        /* ==========================================
           FOOTER
        ========================================== */

        .footer {
            min-height: 180px;

            padding: 35px 50px;

            background-color: #dedede;

            display: flex;

            justify-content: space-between;

            gap: 30px;
        }


        .footer-caja {
            width: 30%;
            height: 100px;

            background-color: #c8c8c8;

            border-radius: 10px;
        }


        /* ==========================================
           RESPONSIVE - TABLET
        ========================================== */

        @media (max-width: 1000px) {

            .productos {
                grid-template-columns:
                    repeat(2, 1fr);

                padding: 30px;
            }


            .contenido {
                padding: 60px 40px;

                gap: 35px;
            }


            .contenido-imagen {
                width: 350px;
                height: 350px;
            }
        }


        /* ==========================================
           RESPONSIVE - CELULAR
        ========================================== */

        @media (max-width: 650px) {

            .header {
                height: auto;

                padding: 15px;

                flex-wrap: wrap;

                gap: 15px;
            }


            .logo {
                width: 120px;
            }


            .menu {
                order: 3;

                width: 100%;

                justify-content: center;
            }


            .menu-caja {
                width: 55px;
            }


            .banner {
                height: 220px;
            }


            .banner-texto {
                width: 70%;
                height: 60px;
            }


            .titulo {
                padding: 30px 15px 20px;
            }


            .titulo-caja {
                width: 230px;
                height: 40px;
            }


            .productos {
                grid-template-columns: 1fr;

                padding: 20px;

                gap: 25px;
            }


            .producto {
                width: 100%;

                min-height: auto;
            }


            .producto-imagen {
                height: 280px;
            }


            .contenido {
                flex-direction: column;

                padding: 50px 25px;

                gap: 35px;
            }


            .texto {
                width: 100%;
            }


            .contenido-imagen {
                width: 90%;
                height: 300px;
            }


            .comentario {
                width: 85%;

                min-height: 230px;

                margin: 50px auto;
            }


            .footer {
                flex-direction: column;

                padding: 25px;

                gap: 15px;
            }


            .footer-caja {
                width: 100%;
                height: 60px;
            }

        }

    </style>

</head>


<body>


<div class="pagina">


    <!-- ==========================================
         HEADER
    ========================================== -->

    <header class="header">

        <div class="logo"></div>

        <nav class="menu">

            <div class="menu-caja"></div>

            <div class="menu-caja"></div>

            <div class="menu-caja"></div>

            <div class="menu-caja"></div>

        </nav>

        <div class="carrito"></div>

    </header>



    <!-- ==========================================
         BANNER
    ========================================== -->

    <section class="banner">

        <div class="banner-texto"></div>

    </section>



    <!-- ==========================================
         TÍTULO
    ========================================== -->

    <section class="titulo">

        <div class="titulo-caja"></div>

    </section>



    <!-- ==========================================
         PRODUCTOS
    ========================================== -->

    <section class="productos">


        <div class="producto">

            <div class="producto-nombre"></div>

            <div class="producto-imagen"></div>

            <div class="producto-descripcion"></div>

        </div>


        <div class="producto">

            <div class="producto-nombre"></div>

            <div class="producto-imagen"></div>

            <div class="producto-descripcion"></div>

        </div>


        <div class="producto">

            <div class="producto-nombre"></div>

            <div class="producto-imagen"></div>

            <div class="producto-descripcion"></div>

        </div>


        <div class="producto">

            <div class="producto-nombre"></div>

            <div class="producto-imagen"></div>

            <div class="producto-descripcion"></div>

        </div>


    </section>



    <!-- ==========================================
         INFORMACIÓN
    ========================================== -->

    <section class="contenido">


        <div class="texto">

            <div class="texto-titulo"></div>

            <div class="texto-linea"></div>

            <div class="texto-linea"></div>

            <div class="texto-linea"></div>

            <div class="texto-linea corta"></div>

            <div class="texto-linea"></div>

            <div class="texto-linea muy-corta"></div>

        </div>


        <div class="contenido-imagen"></div>


    </section>



    <!-- ==========================================
         COMENTARIOS
    ========================================== -->

    <section class="comentario">

        <div class="comentario-titulo"></div>

        <div class="comentario-boton"></div>

    </section>



    <!-- ==========================================
         FOOTER
    ========================================== -->

    <footer class="footer">

        <div class="footer-caja"></div>

        <div class="footer-caja"></div>

        <div class="footer-caja"></div>

    </footer>


</div>


</body>
</html>
