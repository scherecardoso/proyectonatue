<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentario enviado</title>
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
         "banner"
         "coment"
         "pie";
         gap: 10px;

}

        .contenedor {
            margin-left: 35%;
            margin-top: 5%;
            width: 500px;
            max-width: 90%;
            background-color: white;
            padding: 50px;
            border-radius: 25px;
            text-align: center;
            
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            margin-top: 0;
            margin-bottom: 15px;
            color: #222;
        }

        p {
            color: #666;
            font-size: 17px;
            margin-bottom: 30px;
        }

        .a {
            display: inline-block;
            background-color: #222;
            color: white;
            text-decoration: none;
            padding: 14px 30px;
            border-radius: 12px;
            transition: 0.3s;
        }

        .a:hover {
            transform: scale(1.05);
        }

    </style>
</head>

<body>
<?php include("../includes/header.php"); ?>
    <div class="contenedor">

        <h1>¡Gracias por tu comentario!</h1>

        <p>
            Tu comentario o sugerencia fue recibido correctamente.
        </p>

        <?php
        $asunto=$_POST["asunto"];
        $coment=$_POST["coment"];

        $archivo=fopen("recepcion.txt" , "a");
        fwrite($archivo,"ASUNTO:".PHP_EOL);
        fwrite($archivo,"$asunto".PHP_EOL);
        fwrite($archivo,"COMENTARIO:".PHP_EOL);
        fwrite($archivo,$coment.PHP_EOL);

        echo "<a href='revisar.php'>Ver comentarios</a>";
        ?>

    </div>

</body>
</html>