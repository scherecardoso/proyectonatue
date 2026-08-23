<?php
session_start();

if ($_SESSION['rol'] != 'vendedor') {
    header("Location: ../pagina/login.php");
    exit();
}
?>
<?php
    
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

    if ($conn->connect_error) {
        echo "hubo un error :(";
    }
    $codigo=$_GET['codigo'];
    $sql ="SELECT * FROM productos WHERE codigo=$codigo";
    $resultado = $conn->query($sql);
    if($resultado->num_rows > 0){
        while($fila=$resultado->fetch_assoc()){
            $nombreproducto = $fila['nombreproducto'];
            $descripcion = $fila['descripcion'];
            $precio = $fila['precio'];
            $stock = $fila['stock'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>
<body>
    <?php include("../includes/header.php"); ?>
    <form id="formeditarproducto" action="../productos/19.actualizarproductos.php" method="post">
        <label for="codigo">Nombre:</label>
        <input type="hidden" name="codigo" value='<?=$codigo?>'>
        <input type="text" name="nombreproducto" value='<?=$nombreproducto?>'><br>
        <label for="descripcion">Descripcion:</label>
        <input type="text" name="descripcion" value='<?=$descripcion?>'><br>
        <label for="precio">Precio:</label>
        <input type="text" name="precio" value='<?=$precio?>'><br>
        <label for="stock">Stock:</label>
        <input type="text" name="stock" value='<?=$stock?>'><br>
        <input type="submit">
        
    </form>
<script>
$(document).ready(function(){

    $("#formeditarproducto").validate({

        rules:{
            nombreproducto:{
                required:true,
                minlength:3
            },
            descripcion:{
                required:true,
                minlength:5
            },
            precio:{
                required:true,
                number:true,
                min:0.01
            },
            stock:{
                required:true,
                digits:true,
                min:0
            }
        },

        messages:{
            nombreproducto:{
                required:"El nombre del producto es obligatorio",
                minlength:"El nombre debe tener al menos 3 caracteres"
            },
            descripcion:{
                required:"La descripción es obligatoria",
                minlength:"La descripción debe tener al menos 5 caracteres"
            },
            precio:{
                required:"El precio es obligatorio",
                number:"El precio debe ser un número válido",
                min:"El precio debe ser mayor a 0"
            },
            stock:{
                required:"El stock es obligatorio",
                digits:"El stock debe ser un número entero",
                min:"El stock no puede ser negativo"
            }
        }

    });

});
</script>
</body>
</html>