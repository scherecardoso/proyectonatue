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
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f7f5f2;
            font-family: 'Open Sans', sans-serif;
        }

        .botonvolver {
            position: fixed;
            top: 25px;
            left: 25px;
            padding: 14px 28px;
            background-color: #737477;
            color: white;
            border: none;
            border-radius: 14px;
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.18);
            transition: 0.3s;
            text-decoration:none;
        }

        .botonvolver:hover {
            background-color: #997a95;
            transform: translateY(-3px);
            box-shadow: 0 9px 22px rgba(0, 0, 0, 0.22);
        }

        form {
            width: 500px;
            max-width: 90%;
            background-color: white;
            padding: 45px;
            border-radius: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            position: relative;
        }

        .titulo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .titulo img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            border-radius: 15px;
        }

        .titulo h1 {
            font-family: 'Playfair Display', serif;
            text-align: center;
            font-size: 30px;
            margin: 0;
            color: #4F4F4F;
        }

        .descripcion {
            text-align: center;
            margin-bottom: 30px;
            color: #777777;
            font-size: 14px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 15px;
            font-weight: 500;
            color: #555555;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 14px;
            margin-bottom: 25px;
            border: 1px solid #d5d5d5;
            border-radius: 12px;
            font-family: 'Open Sans', sans-serif;
            font-size: 15px;
            outline: none;
            background-color: #fafafa;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #999999;
            background-color: white;
        }

        textarea {
            height: 140px;
            resize: none;
        }

        .botones {
            display: flex;
            gap: 15px;
        }

        input[type="submit"],
        input[type="reset"] {
            width: 50%;
            padding: 13px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-size: 15px;
            font-family: 'Open Sans', sans-serif;
            transition: 0.3s;
        }

        input[type="submit"] {
            background-color: #666666;
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #555555;
            transform: translateY(-2px);
        }

        input[type="reset"] {
            background-color: #eeeeee;
            color: #333333;
        }

        input[type="reset"]:hover {
            background-color: #dddddd;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {

            .botonvolver {
                top: 15px;
                left: 15px;
                padding: 12px 22px;
                font-size: 15px;
            }

            .titulo img {
                width: 65px;
                height: 65px;
            }

            .titulo h1 {
                font-size: 25px;
            }

            form {
                padding: 35px 25px;
                margin-top: 55px;
            }

        }

    </style>
</head>

<body>
    <a href="../pagina/02.inicio.php" class="botonvolver">← Volver</a>

    <form action="mensaje.php" method="POST">

        <div class="titulo">

            <img src="../img/perrito-comentario.jpg" alt="Perrito usando una computadora">

            <h1>Déjanos tu comentario</h1>

        </div>

        <p class="descripcion">
            Tu opinión es muy importante para nosotros.
        </p>

        <label>Asunto:</label>
        <input type="text" name="asunto">

        <label>Comentario o sugerencia:</label>
        <textarea name="coment"></textarea>

        <div class="botones">

            <input type="submit" value="Enviar">

            <input type="reset" value="Limpiar">

        </div>

    </form>

</body>
</html>
