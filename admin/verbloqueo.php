
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #F3ECE8;
        font-family: Arial, sans-serif;
    }

    .mensaje {
        width: 90%;
        max-width: 520px;
        padding: 45px 40px;
        text-align: center;
        background: #F8E4E8;
        border-radius: 22px;
        box-shadow: 0 10px 30px rgba(91, 67, 62, 0.12);
        border: 1px solid #D9BFC0;
    }

    .icono {
        width: 75px;
        height: 75px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #EAD6D2;
        color: #A87578;
        font-size: 30px;
    }

    .detalle {
        width: 45px;
        height: 2px;
        margin: 0 auto 20px;
        background: #C08D91;
    }

    h2 {
        margin: 0 0 15px;
        color: #80575B;
        font-size: 25px;
        font-weight: 600;
    }

    p {
        margin: 0;
        color: #5E5150;
        font-size: 16px;
        line-height: 1.7;
    }

    a {
        display: inline-block;
        margin-top: 18px;
        padding: 9px 24px;
        background-color: #CFA6A4;
        color: #FFFFFF;
        text-decoration: none;
        border: 1px solid #B98D8C;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        transition: 0.3s;
    }

    a:hover {
        background-color: #B98D8C;
    }
</style>


<div class="mensaje">

    <div class="icono">
        <i class="fa-solid fa-lock"></i>
    </div>

    <div class="detalle"></div>

    <h2>Tu cuenta está temporalmente bloqueada</h2>

    <p>
        Lo sentimos, en este momento no puedes acceder a tu cuenta.
        Si necesitas ayuda o consideras que se trata de un error,
        comunícate con NATUÉ para recibir ayuda.
        <br>

        <a href="../pagina/005.contactanos.php">Contáctanos</a>
    </p>

</div>
</body>
</html>