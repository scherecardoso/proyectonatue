<?php
// Inicia la sesión para poder comprobar el rol del usuario que intenta acceder.
session_start();

// Solo los vendedores y administradores tienen permiso para editar productos.
// Si el usuario no tiene uno de esos roles, se le envía a la página de inicio de sesión.
if ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador') {
    header("Location: ../pagina/login.php");
    exit();
}
?>
<?php
// Datos de conexión al servidor MySQL y a la base de datos del proyecto.
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

// Se establece la conexión que se utilizará para consultar el producto.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si no se puede conectar, se detiene la ejecución y se informa del problema.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

    // Comprobación adicional de conexión antes de realizar la consulta.
    if ($conn->connect_error) {
        echo "hubo un error :(";
    }
    // Se obtiene de la URL el código del producto que se quiere editar.
    $codigo=$_GET['codigo'];
    // Se buscan los datos del producto cuyo código coincide con el recibido.
    $sql ="SELECT * FROM productos WHERE codigo=$codigo";
    $resultado = $conn->query($sql);
    // Si se encontró el producto, sus campos se guardan para mostrarlos en el formulario.
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
    <!-- Configuración básica para que el contenido se interprete correctamente y se adapte a pantallas pequeñas. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título que aparece en la pestaña del navegador. -->
    <title>Document</title>


</head>
<body>
    <!-- Se incluye la cabecera común del sitio. -->
    <?php include("../includes/header.php"); ?>
    <!-- Formulario que envía por POST los cambios al archivo encargado de actualizar el producto. -->
    <form id="formeditarproducto" action="../productos/19.actualizarproductos.php" method="post">
        <!-- El código viaja oculto para identificar qué registro se debe actualizar. -->
        <label for="codigo">Nombre:</label>
        <input type="hidden" name="codigo" value='<?=$codigo?>'>
        <!-- Campos rellenados inicialmente con los datos actuales del producto. -->
        <input type="text" name="nombreproducto" value='<?=$nombreproducto?>'><br>
        <label for="descripcion">Descripcion:</label>
        <input type="text" name="descripcion" value='<?=$descripcion?>'><br>
        <label for="precio">Precio:</label>
        <input type="text" name="precio" value='<?=$precio?>'><br>
        <label for="stock">Stock:</label>
        <input type="text" name="stock" value='<?=$stock?>'><br>
        <!-- Envía el formulario para guardar los cambios. -->
        <input type="submit">
        
    </form>
<script>
// Espera a que el documento esté listo antes de configurar la validación del formulario.
$(document).ready(function(){

    // Activa la validación del lado del navegador para los campos editables.
    $("#formeditarproducto").validate({

        // Reglas: los textos son obligatorios y tienen una longitud mínima;
        // el precio debe ser numérico y positivo, y el stock un entero no negativo.
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

        // Mensajes en español que se muestran cuando un campo no cumple sus reglas.
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