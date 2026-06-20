<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title></title> 

 <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

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

.contenedor{
    width:500px;
    background:white;
    padding:40px;
    border-radius:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    border:2px solid #f8c6e5;
}

.menu-registro{
    display:flex;
    justify-content:center;
    gap:40px;
    margin-bottom:40px;
}

.menu-registro a{
    text-decoration:none;
    color:#777;
    font-size:18px;
}

.menu-registro .activo{
    color:#111;
    border-bottom:2px solid #111;
    padding-bottom:8px;
}

h2{
    text-align:center;
    font-size:42px;
    font-family:serif;
    color:#222;
    margin-bottom:10px;
}

form{
    display:flex;
    flex-direction:column;
}

input{
    width:100%;
    height:58px;
    color: #777;
    border:1px solid #f5a3d5;
    border-radius:40px;
    display:flex;
    align-items:center;
    padding:20px;
    margin-bottom:18px;
    background:#fafafa;
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
    transform: scale(1.03);
    background:#f765c6;
}

@media(max-width:768px){

    .contenedor{
        width:100%;
        max-width:430px;
        padding:30px;
    }

    h2{
        font-size:35px;
    }

    input{
        height:54px;
    }

}

label.error{
    color:#a01045;
    font-size:13px;
   
    margin-bottom:10px;
    margin-left:15px;
}

input.error{
    border:1px solid #a01045;
}

select {
    width:100%;
    height:58px;
    color: #777;
    border:1px solid #f5a3d5;
    border-radius:40px;
    display:flex;
    align-items:center;
    padding:20px;
    margin-bottom:18px;
    background:#fafafa;
}

</style>
</head>

<body>

<div class="contenedor">
    <div class="menu-registro">
    <a href="09.register.php">Iniciar sesión</a>
    <a href=" 10.formusuario.php" class="activo">Registrarse</a>
</div>

    <h2>Crear cuenta</h2>

    <form action="11.registrousuario.php" method="post" id="formusuarios">

    <input type="number" name="CI" placeholder="CI" required>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="email" name="direccion" placeholder="Correo electronico" required>
    <input type="number" name="celular" placeholder="Celular" required>

    <select name="rol">
         <option value="">Seleccione un rol</option>
        <option value="usuario">Usuario</option>
        <option value="vendedor">Vendedor</option>
        <option value="administrador">Administrador</option>
    </select>

    <input type="text" name="estado" placeholder="Estado" required>

    <button type="submit">Registrar</button>
</form>

</div>

<script>

$(document).ready(function(){

    $("#formusuarios").validate({

        rules:{
            CI:{
                required:true,
                number:true,
                minlength:6
            },
            nombre:{
                required:true
            },
            direccion:{
                required:true,
                email:true
            },
            celular:{
                required:true,
                number:true,
                minlength:8
            },
            rol:{
                required:true
            },
            estado:{
                required:true
            }
        },

        messages:{
            CI:{
                required:"Por favor, ingresa tu CI",
                number:"Solo se aceptan números",
                minlength:"El CI debe tener al menos 6 números"
            },
            nombre:{
                required:"El nombre es obligatorio"
            },
            direccion:{
                required:"Por favor, ingresa tu correo electrónico",
                email:"Por favor, ingresa un correo electrónico válido"
            },
            celular:{
                required:"Este campo no puede ir vacío",
                number:"Solo se aceptan números",
                minlength:"El celular debe tener al menos 8 números"
            },
            rol:{
                required:"Selecciona un rol para continuar"
            },
            estado:{
                required:"El campo es obligatorio"
            }
        }

    });

});
</script>

</body>
</html>