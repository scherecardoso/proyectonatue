<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Iniciar Sesión</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#f5f3f2;
}

.caja-login{
    width:500px;
    background:white;
    padding:40px;
    border-radius:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    border:2px solid #f8c6e5;
}

.menu-login{
    display:flex;
    justify-content:center;
    gap:40px;
    margin-bottom:40px;
}

.menu-login a{
    text-decoration:none;
    color:#777;
    font-size:18px;
}

.menu-login .activo{
    color:#111;
    border-bottom:2px solid #111;
    padding-bottom:8px;
}

.titulo{
    text-align:center;
    font-size:42px;
    font-family:serif;
    color:#222;
    margin-bottom:25px;
}

input{
    width:100%;
    height:58px;
    color:#777;
    border:1px solid #f5a3d5;
    border-radius:40px;
    padding:20px;
    margin-bottom:18px;
    background:#fafafa;
    outline:none;
    font-size:15px;
}

input::placeholder{
    color:#777;
}

button{
    width:100%;
    padding:16px;
    border:1px solid #f34bb3;
    border-radius:40px;
    background:#f06ac3;
    color:white;
    font-size:17px;
    cursor:pointer;
    margin-top:10px;
    transition:0.3s;
}

button:hover{
    transform:scale(1.03);
    background:#f765c6;
}

label.error{
    color:#a01045;
    font-size:13px;
    display:block;
    margin-top:-10px;
    margin-bottom:10px;
    margin-left:15px;
}

input.error{
    border:1px solid #a01045;
}

@media(max-width:768px){

    .caja-login{
        width:100%;
        max-width:430px;
        padding:30px;
    }

    .titulo{
        font-size:35px;
    }

    input{
        height:54px;
    }

}

</style>
</head>

<body>

<form class="caja-login" action="23.autenticar.php" method="post" id="iniciarsesion">

    <div class="menu-login">
        <a href="09.register.php" class="activo">Iniciar sesión</a>
        <a href="10.formusuario.php">Registrarse</a>
    </div>

    <h1 class="titulo">Bienvenida</h1>

    <input type="email" name="correo" placeholder="Correo electrónico" required>

    <input type="password" name="password" placeholder="Contraseña" required>

    <button type="submit">Ingresar</button>

</form>

<script>

$(document).ready(function(){

    $("#iniciarsesion").validate({

        rules:{
            correo:{
                required:true,
                email:true
            },
            password:{
                required:true,
                minlength:6
            }
        },

        messages:{
            correo:{
                required:"Por favor, ingresa tu correo electrónico",
                email:"Por favor, ingresa un correo electrónico válido"
            },
            password:{
                required:"Por favor, ingresa tu contraseña",
                minlength:"La contraseña debe tener al menos 6 caracteres"
            }
        }

    });

});

</script>

</body>
</html>