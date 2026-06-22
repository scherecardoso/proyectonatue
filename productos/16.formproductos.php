<?php
session_start();

if ($_SESSION['rol'] != 'vendedor') {
    header("Location: ../pagina/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    width:360px;
    padding:25px;
    border-radius:18px;
    background:rgba(255,255,255,0.6);
    border:2px solid #f8c6e5;
}

h2{
    text-align:center;
    font-size:22px;
    color:#222;
    margin-bottom:10px;
}

p{
    text-align:center;
    font-size:13px;
    color:#222;
    margin-bottom:20px;
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
}

button:hover{
    transform: scale(1.03);
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
<?php include("../includes/header.php"); ?>
<div class="contenedor">

    <h2>Registro</h2>
    <p>Datos del producto</p>

    <form action="../productos/23.registroproductos.php" method="post" id="valipro">

        <label class="campo">
            <i class="fa-solid fa-barcode"></i>
            <input type="number" name="codigo" placeholder="Código">
        </label>

        <label class="campo">
            <i class="fa-solid fa-box"></i>
            <input type="text" name="nombre" placeholder="Nombre">
        </label>

        <label class="campo">
            <i class="fa-solid fa-file"></i>
            <input type="text" name="descripcion" placeholder="Descripción">
        </label>

        <label class="campo">
            <i class="fa-solid fa-dollar-sign"></i>
            <input type="number" name="precio" placeholder="Precio">
        </label>

        <label class="campo">
            <i class="fa-solid fa-money-bill"></i>
            <input type="number" name="costo" placeholder="Costo">
        </label>

        <label class="campo">
            <i class="fa-solid fa-warehouse"></i>
            <input type="text" name="stock" placeholder="Stock">
        </label>

        <button type="submit">Guardar</button>

    </form>
</div>

<script>
    $(document).ready(function(){

    $("#valipro").validate({

        rules:{
            codigo:{
                required:true,
                number:true
            },
            nombre:{
                required:true
            },
            descripcion:{
                required:true
            },
            precio:{
                required:true,
                number:true
            },
            costo:{
                required:true,
                number:true
            },
            stock:{
                required:true
            }
        },

        messages:{
            codigo:{
                required:"Es obligatorio poner el codigo",
                number:"Solo se aceptan números"
            },
            nombre:{
                required:"El nombre del producto es obligatorio"
            },
            descripcion:{
                required:"La descripcion no puede ir vacía"
            },
            precio:{
                required:"Debe poner el precio del producto",
                number:"Solo se aceptan números"
            },
            costo:{
                required:"El costo es obligatorio",
                number:"Solo se aceptan números"
            },
            stock:{
                required:"El campo es obligatorio"
            }
        }

    });

});
</script>

</body>
</html>