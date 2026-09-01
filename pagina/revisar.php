<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #FAF9F7;
            font-family: 'Open Sans', sans-serif;
            padding: 60px 20px;
        }

        .contenedor {
            width: 90%;
            max-width: 850px;
            margin: auto;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 40px;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 600;
            color: #5F5650;
            margin: 0;
        }

        .descripcion {
            color: #938983;
            font-size: 16px;
            margin-top: 10px;
        }

        .linea {
            width: 50px;
            height: 3px;
            background: #D8CBC2;
            margin: 20px auto;
            border-radius: 10px;
        }

        .comentario {
            background: #FFFFFF;
            padding: 30px 35px;
            margin-bottom: 20px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(150, 140, 130, 0.10);
            border: 1px solid #F0ECE8;
        }

        .asunto-titulo {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 600;
            color: #5F5650;
            margin-bottom: 8px;
        }

        .asunto {
            font-size: 16px;
            color: #827872;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .comentario-titulo {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 600;
            color: #5F5650;
            margin-bottom: 8px;
        }

        .texto-comentario {
            color: #827872;
            font-size: 16px;
            line-height: 1.7;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <div class="encabezado">

        <h1>Comentarios</h1>

        <div class="linea"></div>

        <div class="descripcion">
            Opiniones y sugerencias recibidas de nuestros usuarios.
        </div>

    </div>

    <?php

    $archivo = fopen("recepcion.txt", "r");

    while(!feof($archivo)){

        $titulo1 = fgets($archivo);
        $asunto = fgets($archivo);
        $titulo2 = fgets($archivo);
        $comentario = fgets($archivo);

        if($asunto != ""){

            echo '<div class="comentario">';

            echo '<div class="asunto-titulo">Asunto</div>';
            echo '<div class="asunto">'.nl2br($asunto).'</div>';

            echo '<div class="comentario-titulo">Comentario o sugerencia</div>';
            echo '<div class="texto-comentario">'.nl2br($comentario).'</div>';

            echo '</div>';

        }

    }

    fclose($archivo);

    ?>

</div>

</body>
</html>