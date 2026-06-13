<?php
$direccion="localhost";
$usuario="root";
$contra="";
$baseDeDatos="shena";

$conn = new mysqli($direccion, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "No se conecto a la base de datos."
}

$CI=$_POST['CI']:
$sql= "SELECT * FROM usuario WHERE CI='$CI'"; 
$resultado= $conn->query($sql);
if ($resultado->num_rows>0){
    while($fila=$resultado->fetch_assoc()){
        $CI=$fila['CI'];
        $nombre=$fila['nombre'];
        $direccion=$fila['direccion'];
        $celular=$fila['celular'];
        $rol=$fila['rol'];
        $estado=$fila['estado'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Usuario</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#ffffff;
}

.contenedor{
    width:380px;
    padding:25px;
    border-radius:18px;
    background:rgba(255,255,255,0.6);
    border:2px solid #f8c6e5;
}

.logo{
    text-align:center;
    margin-bottom:10px;
}

.logo i{
    font-size:55px;
    color:#f5a3d5;
}

.titulo{
    text-align:center;
    margin-bottom:20px;
}

.titulo h2{
    font-size:22px;
    color:#222;
    margin-bottom:8px;
}

.titulo p{
    font-size:13px;
    color:#222;
}

.campo{
    position:relative;
    display:block;
    margin-bottom:12px;
}

.campo i{
    position:absolute;
    left:12px;
    top:12px;
    color:#f5a3d5;
}

.campo input{
    width:100%;
    padding:10px 10px 10px 38px;
    border:1px solid #f5a3d5;
    border-radius:12px;
    outline:none;
    font-size:14px;
    color:#444;
}

button{
    width:100%;
    padding:10px;
    border:1px solid #f34bb3;
    border-radius:12px;
    background:#f06ac3;
    color:#fff;
    margin-top:10px;
    cursor:pointer;
    font-size:14px;
}

button:hover{
    transform:scale(1.03);
    background:#f765c6;
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

    <div class="logo">
        <i class="fa-solid fa-user-pen"></i>
    </div>

    <div class="titulo">
        <h2>Editar Usuario</h2>
        <p>Actualiza la información del usuario</p>
    </div>

<<<<<<< HEAD:14.formeditarusuario.php
    <form action="15.actualizarusuario.php" method="post" id="valieditarus">
=======
    <form action="14.actualizarusuario.php" method="post" id="valieditarus">
>>>>>>> 19750247a25495b946007d7f962f839b51e61ea1:13.formeditarusuario.php

       <label class="campo">
        <i class="fa-solid fa-user-pen"></i>
        <input type="hidden" name="CI" value=<?=$CI?> placeholder="Cédula de identidad">
       </label> 

        <label class="campo">
            <i class="fa-solid fa-user"></i>
            <input type="text" name="nombre" value=<?=$nombre?> placeholder="Nombre completo" required>
        </label>

        <label class="campo">
            <i class="fa-solid fa-location-dot"></i>
            <input type="text" name="direccion" value=<?=$direccion?> placeholder="Dirección" required>
        </label>

        <label class="campo">
            <i class="fa-solid fa-phone"></i>
            <input type="number" name="celular" value=<?=$celular?> placeholder="Celular" required>
        </label>

        <label class="campo">
            <i class="fa-solid fa-briefcase"></i>
            <input type="text" name="rol" value=<?=$rol?> placeholder="Rol" required>
        </label>

        <label class="campo">
            <i class="fa-solid fa-circle-check"></i>
            <input type="text" name="estado" value=<?=$estado?> placeholder="Estado" required>
        </label>

    <button>Actualizar usuario</button>

    </form>
</div>

<script>

$(document).ready(function(){

    $("#valieditarus").validate({

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