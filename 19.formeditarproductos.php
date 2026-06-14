<?php
    
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$codigo = $_GET['codigo'];

$sql ="SELECT * FROM productos WHERE codigo=$codigo";

$resultado = $conn->query($sql);

if($resultado->num_rows > 0){

    while($fila = $resultado->fetch_assoc()){

        $codigo = $fila['codigo'];
        $nombre = $fila['nombre'];
        $descripcion = $fila['descripcion'];
        $precio = $fila['precio'];
        $costo = $fila['costo'];
        $stock = $fila['stock'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Producto</title>

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
    padding:20px;
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
        <i class="fa-solid fa-box-open"></i>
    </div>

    <div class="titulo">
        <h2>Editar Producto</h2>
        <p>Actualiza la información del producto</p>
    </div>

    <form action="20.actualizarproductos.php" method="post" id="valieditarpro">

        <input type="hidden" name="codigo" value="<?=$codigo?>">

        <label class="campo">
            <i class="fa-solid fa-barcode"></i>
            <input type="number" name="codigo" value="<?=$codigo?>" placeholder="Código">
        </label>

        <label class="campo">
            <i class="fa-solid fa-box"></i>
            <input type="text" name="nombre" value="<?=$nombre?>" placeholder="Nombre del producto">
        </label>

        <label class="campo">
            <i class="fa-solid fa-file-lines"></i>
            <input type="text" name="descripcion" value="<?=$descripcion?>" placeholder="Descripción">
        </label>

        <label class="campo">
            <i class="fa-solid fa-dollar-sign"></i>
            <input type="number" name="precio" value="<?=$precio?>" placeholder="Precio">
        </label>

        <label class="campo">
            <i class="fa-solid fa-money-bill"></i>
            <input type="number" name="costo" value="<?=$costo?>" placeholder="Costo">
        </label>

        <label class="campo">
            <i class="fa-solid fa-warehouse"></i>
            <input type="number" name="stock" value="<?=$stock?>" placeholder="Stock">
        </label>

        <button>Actualizar producto</button>

    </form>
</div>

<script>

$(document).ready(function(){

    $("#valieditarpro").validate({

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
                required:true,
                number:true
            }
        },
        messages:{
            codigo:{
                required:"Este campo no puede ir vacío",
                number:"Solo se aceptan números"
            },
            nombre:{
                required:"El nombre es obligatorio"
            },
            descripcion:{
                required:"La descripción es obligatoria"
            },
            precio:{
                required:"El precio es obligatorio",
                number:"Solo se aceptan números"
            },
            costo:{
                required:"El costo es obligatorio",
                number:"Solo se aceptan números"
            },
            stock:{
                required:"El stock es obligatorio",
                number:"Solo se aceptan números"
            }
        }
    });
});
</script>

</body>
</html>