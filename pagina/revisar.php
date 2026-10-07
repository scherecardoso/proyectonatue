<!-- Indica al navegador que este documento utiliza HTML5. -->
<!DOCTYPE html>
<!-- La página está escrita en español. -->
<html lang="en">
<head>
    <!-- Define la codificación para mostrar correctamente acentos y caracteres especiales. -->
    <meta charset="UTF-8">
    <!-- Ajusta el ancho de la página al tamaño de la pantalla del dispositivo. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Texto que aparece en la pestaña del navegador. -->
    <title>Comentarios</title>

    <!-- Fuentes externas usadas en los títulos y en el texto general. -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>

        /* Hace que el ancho y alto de los elementos incluyan el relleno y el borde. */
        * {
            box-sizing: border-box;
        }

        /* Estilos generales de toda la página. */
        body {
            margin: 0;
            min-height: 100vh;
            background: #FAF9F7;
            font-family: 'Open Sans', sans-serif;
            padding: 60px 20px;
        }

        /* Limita el ancho del contenido y lo centra horizontalmente. */
        .contenedor {
            width: 90%;
            max-width: 850px;
            margin: auto;
        }

        /* Agrupa y centra el título, la línea decorativa y la descripción. */
        .encabezado {
            text-align: center;
            margin-bottom: 35px;
        }

        /* Apariencia principal del título de la página. */
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 600;
            color: #5F5650;
            margin: 0;
        }

        /* Estilo del texto explicativo que aparece debajo del título. */
        .descripcion {
            color: #938983;
            font-size: 16px;
            margin-top: 10px;
        }

        /* Pequeña línea decorativa debajo del título. */
        .linea {
            width: 50px;
            height: 3px;
            background: #D8CBC2;
            margin: 20px auto;
            border-radius: 10px;
        }

        /* Botón que permite regresar a la página principal. */
        .volver {
            display: block;
            width: 280px;
            margin: 25px auto 35px;
            padding: 14px 20px;
            background: #5a5a63;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 6px 15px rgba(95, 111, 98, 0.25);
            transition: 0.3s;
        }

        /* Cambia el color y eleva el botón cuando el puntero pasa sobre él. */
        .volver:hover {
            background: #726572;
            transform: translateY(-3px);
            box-shadow: 0 9px 20px rgba(95, 111, 98, 0.30);
        }

        /* Tarjeta blanca que contiene cada opinión recibida. */
        .comentario {
            background: #FFFFFF;
            padding: 30px 35px;
            margin-bottom: 20px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(150, 140, 130, 0.10);
            border: 1px solid #F0ECE8;
        }

        /* Título visual que identifica la sección del asunto. */
        .asunto-titulo {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 600;
            color: #5F5650;
            margin-bottom: 8px;
        }

        /* Texto del asunto enviado por el usuario. */
        .asunto {
            font-size: 16px;
            color: #827872;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* Título visual que identifica el texto del comentario o sugerencia. */
        .comentario-titulo {
            font-family: 'Playfair Display', serif;
            font-size: 23px;
            font-weight: 600;
            color: #5F5650;
            margin-bottom: 8px;
        }

        /* Texto del comentario o sugerencia enviado por el usuario. */
        .texto-comentario {
            color: #827872;
            font-size: 16px;
            line-height: 1.7;
        }

        /* Ajusta tamaños y espacios para pantallas medianas y teléfonos. */
        @media (max-width: 768px) {

            body {
                padding: 40px 15px;
            }

            h1 {
                font-size: 32px;
            }

            .descripcion {
                font-size: 14px;
            }

            .volver {
                width: 90%;
                font-size: 15px;
                padding: 13px 15px;
            }

            .comentario {
                padding: 25px 22px;
            }

        }

    </style>

</head>

<body>

<!-- Contenedor central que agrupa todo el contenido visible de la página. -->
<div class="contenedor">

    <!-- Encabezado con el nombre de la sección y una breve descripción. -->
    <div class="encabezado">

        <h1>Comentarios</h1>

        <div class="linea"></div>

        <div class="descripcion">
            Opiniones y sugerencias recibidas de nuestros usuarios.
        </div>

    </div>

    <!-- Enlace de navegación para volver a la página principal del sitio. -->
    <a href="../pagina/index.php" class="volver">
        ← Volver a la página principal
    </a>

    <?php

    // Abre el archivo de texto que almacena las opiniones recibidas, en modo lectura.
    $archivo = fopen("recepcion.txt", "r");

    // Lee los registros hasta alcanzar el final del archivo.
    while(!feof($archivo)){

        // Cada registro está organizado en cuatro líneas: título, asunto, título y comentario.
        $titulo1 = fgets($archivo);
        $asunto = fgets($archivo);
        $titulo2 = fgets($archivo);
        $comentario = fgets($archivo);

        // Solo se muestra una tarjeta cuando la línea del asunto contiene información.
        if($asunto != ""){

            // Inicio de la tarjeta correspondiente a esta opinión.
            echo '<div class="comentario">';

            // Imprime la etiqueta y el asunto guardado en el archivo.
            echo '<div class="asunto-titulo">Asunto</div>';
            echo '<div class="asunto">'.nl2br($asunto).'</div>';

            // Imprime la etiqueta y el texto del comentario o sugerencia.
            echo '<div class="comentario-titulo">Comentario o sugerencia</div>';
            echo '<div class="texto-comentario">'.nl2br($comentario).'</div>';

            // Cierre de la tarjeta de esta opinión.
            echo '</div>';

        }

    }

    // Cierra el archivo después de terminar de leer todos sus registros.
    fclose($archivo);

    ?>

</div>

</body>
</html>