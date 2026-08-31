<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta bloqueada</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"> 
 
<style> 
    body { 
        margin: 0; 
        min-height: 100vh; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        background: #FAF9F7; 
        font-family: Arial, sans-serif; 
    } 
 
    .mensaje { 
        width: 90%; 
        max-width: 520px; 
        padding: 45px 40px; 
        text-align: center; 
        background: #FFFFFF; 
        border-radius: 22px; 
        box-shadow: 0 10px 30px rgba(180, 170, 160, 0.15); 
        border: 1px solid #EEEAE6; 
        animation: aparecer 0.7s ease; 
    } 
 
    .perrito { 
        width: 380px; 
        height: 160px; 
        object-fit: contain; 
        margin-bottom: 10px; 
        border-radius: 15px; 
    } 
 
    .icono { 
        width: 75px; 
        height: 75px; 
        margin: 0 auto 20px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        border-radius: 50%; 
        background: #F3EEE9; 
        color: #9B8F86; 
        font-size: 30px; 
        animation: movimiento 2s infinite ease-in-out; 
    } 
 
    @keyframes movimiento { 
        0%, 100% { 
            transform: rotate(0deg); 
        } 
 
        25% { 
            transform: rotate(-8deg); 
        } 
 
        75% { 
            transform: rotate(8deg); 
        } 
    } 
 
    .detalle { 
        width: 45px; 
        height: 2px; 
        margin: 0 auto 20px; 
        background: #C9BDB3; 
    } 
 
    h2 { 
        margin: 0 0 15px; 
        color: #5F5650; 
        font-size: 25px; 
        font-weight: 600; 
    } 
 
    p { 
        margin: 0; 
        color: #827872; 
        font-size: 16px; 
        line-height: 1.7; 
    } 
 
    a { 
        display: inline-block; 
        margin-top: 18px; 
        padding: 9px 24px; 
        background-color: #D8CBC2; 
        color: #5F5650; 
        text-decoration: none; 
        border: 1px solid #D0C2B8; 
        border-radius: 8px; 
        font-size: 15px; 
        font-weight: 600; 
        transition: 0.3s; 
    } 
 
    a:hover { 
        background-color: #CBBCAF; 
        transform: scale(1.05); 
    } 
 
    @keyframes aparecer { 
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        } 
 
        to { 
            opacity: 1; 
            transform: translateY(0); 
        } 
    } 
 
</style> 
 
</head> 
 
<body> 
 
<div class="mensaje"> 
 
    <img src="../img/perrito-triste.gif" alt="Perrito triste" class="perrito"> 
 
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