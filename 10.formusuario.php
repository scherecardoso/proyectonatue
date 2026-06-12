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

</style>
</head>

<body>

<div class="contenedor">

    <div class="menu-registro">
    <a href="09.register.php">Iniciar sesión</a>

    <a href="10.formusuario.html" class="activo">Registrarse</a>
</div>

    <h2>Crear cuenta</h2>

    <form action="08.usuario.php" method="post" id="formusuarios">

        
        <input type="number" name="CI" placeholder="Carnet de Indentidad" required>

        <input type="text" name="nombre" placeholder="Nombre Completo" required>

        <input type="text" name="direccion" placeholder="Dirección" required>

        <input type="number" name="celular" placeholder="Celular" required>

        <input type="text" name="rol" placeholder="Rol" required>

        <input type="text" name="estado" placeholder="Estado" required>

        <button>Guardar usuario</button>

    </form>

</div>

<script>

$(document).ready(function(){

    $("#formusuarios").validate({

        rules:{
            CI:{
                required:true,
                number:true,
                minlength:8
            },
            nombre:{
                required:true
            },
            direccion:{
                required:true
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
                required:"Este campo no puede ir vacío",
                number:"Solo se aceptan números",
                minlength:"El CI debe tener al menos 8 números"
            },
            nombre:{
                required:"El nombre es obligatorio"
            },
            direccion:{
                required:"Este campo no puede ir vacío"
            },
            celular:{
                required:"Este campo no puede ir vacío",
                number:"Solo se aceptan números",
                minlength:"El celular debe tener al menos 8 números"
            },
            rol:{
                required:"El campo es obligatorio"
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