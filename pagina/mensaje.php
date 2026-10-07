<!DOCTYPE html>
<!-- Documento HTML que muestra la confirmación después de enviar un comentario. -->
<html lang="en">
<head>
    <!-- Configuración básica de caracteres y adaptación a pantallas móviles. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título que aparece en la pestaña del navegador. -->
    <title>Comentario enviado</title>

    <!-- Fuentes externas usadas para los títulos y el texto de la página. -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">

    <style>

        /* Incluye el padding y los bordes dentro del tamaño total de cada elemento. */
        * {
            box-sizing: border-box;
        }

        /* Centra vertical y horizontalmente la tarjeta y define el fondo general. */
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7f5f2;
            font-family: 'Open Sans', sans-serif;
        }

        /* Tarjeta blanca que contiene el mensaje de confirmación y el enlace. */
        .contenedor {
            width: 500px;
            max-width: 90%;
            background-color: white;
            padding: 50px;
            border-radius: 25px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        /* Estilo del encabezado principal de agradecimiento. */
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 15px;
            color: #222;
        }

        /* Estilo del texto que confirma la recepción del comentario. */
        p {
            color: #666;
            font-size: 17px;
            margin-bottom: 30px;
        }

        /* Apariencia del enlace para consultar los comentarios recibidos. */
        a {
            display: inline-block;
            background-color: #222;
            color: white;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 12px;
            transition: 0.3s;
        }

        /* Efecto visual que se aplica al pasar el cursor sobre el enlace. */
        a:hover {
            transform: scale(1.05);
        }

    </style>
</head>

<body>

    <!-- Contenedor principal de la confirmación. -->
    <div class="contenedor">

        <!-- Encabezado y texto informativo que se muestran al visitante. -->
        <h1>¡Gracias por tu comentario!</h1>

        <p>
            Tu comentario o sugerencia fue recibido correctamente.
        </p>

        <?php
        // Se leen del formulario los valores enviados mediante el método POST.
        $asunto=$_POST["asunto"];
        $coment=$_POST["coment"];

        // Se abre el archivo de recepción en modo de añadido para conservar los comentarios anteriores.
        $archivo=fopen("recepcion.txt" , "a");
        // Se guarda el asunto, seguido del comentario, cada uno en líneas separadas.
        fwrite($archivo,"ASUNTO:".PHP_EOL);
        fwrite($archivo,"$asunto".PHP_EOL);
        fwrite($archivo,"COMENTARIO:".PHP_EOL);
        fwrite($archivo,$coment.PHP_EOL);

        // Se muestra un enlace para ir a la página donde se pueden revisar los comentarios.
        echo "<a href='revisar.php'>Ver comentarios</a>";
        ?>

    </div>

</body>
</html>