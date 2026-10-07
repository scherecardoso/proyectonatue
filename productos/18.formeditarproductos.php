
<?php
// Inicia o recupera la sesión para poder verificar el rol del usuario.
session_start();

// El formulario solo está disponible para vendedores y administradores.
if ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador') {
    // Si el rol no está autorizado, se redirige al inicio de sesión.
    header("Location: ../pagina/login.php");
    exit();
}

// Credenciales y nombre de la base de datos usada por el proyecto.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se establece la conexión con el servidor MySQL.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Se detiene la ejecución si no fue posible conectarse a la base de datos.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Código recibido en la URL para identificar el producto solicitado.
$codigo_original = $_GET['codigo'];

// Consulta los datos del producto que se mostrarán en los campos de edición.
$sql = "SELECT * FROM productos WHERE codigo=$codigo_original";

// Ejecuta la consulta y guarda el conjunto de resultados.
$resultado = $conn->query($sql);

// Si existe el producto, copia sus datos a variables para rellenar el formulario.
if ($resultado->num_rows > 0) {

    // Lee la fila devuelta por la consulta y asigna cada dato correspondiente.
    while ($fila = $resultado->fetch_assoc()) {

        $codigo = $fila['codigo'];
        $nombre = $fila['nombre'];
        $descripcion = $fila['descripcion'];
        $precio = $fila['precio'];
        $costo = $fila['costo'];
        $stock = $fila['stock'];
    }
}

// Cierra la conexión una vez que los datos necesarios ya fueron obtenidos.
$conn->close();
?>

<!DOCTYPE html>
<!-- La página y sus textos están definidos en español. -->
<html lang="es">
<head>
<!-- Define la codificación y permite adaptar la página a pantallas móviles. -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Texto que identifica esta página en la pestaña del navegador. -->
<title>Editar Producto</title>

<!-- Biblioteca de iconos usada para ilustrar los campos del formulario. -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<!-- jQuery y el complemento que valida los campos antes de enviar el formulario. -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>

<style>

/* Reinicia espacios predeterminados y unifica el cálculo de dimensiones. */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

/* Coloca el formulario en el centro de la pantalla y define el fondo. */
body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#ffffff;
    padding:20px;
}

/* Panel que agrupa el icono, el encabezado y los campos de edición. */
.contenedor{
    width:380px;
    padding:25px;
    border-radius:18px;
    background:rgba(255,255,255,0.6);
    border:2px solid #f8c6e5;
}

/* Alinea el icono decorativo y agrega espacio debajo. */
.logo{
    text-align:center;
    margin-bottom:10px;
}

/* Tamaño y color del icono que representa un producto. */
.logo i{
    font-size:55px;
    color:#f5a3d5;
}

/* Centra el título y el texto descriptivo del formulario. */
.titulo{
    text-align:center;
    margin-bottom:20px;
}

/* Estilos del título principal. */
.titulo h2{
    font-size:22px;
    color:#222;
    margin-bottom:8px;
}

/* Estilos del texto que indica el propósito de esta página. */
.titulo p{
    font-size:13px;
    color:#222;
}

/* Agrupa cada icono con su campo de entrada y separa los campos. */
.campo{
    position:relative;
    display:block;
    margin-bottom:12px;
}

/* Ubica el icono dentro del campo de entrada. */
.campo i{
    position:absolute;
    left:12px;
    top:12px;
    color:#f5a3d5;
}

/* Define el tamaño, el relleno y los bordes de los campos editables. */
.campo input{
    width:100%;
    padding:10px 10px 10px 38px;
    border:1px solid #f5a3d5;
    border-radius:12px;
    outline:none;
    font-size:14px;
    color:#444;
}

/* Apariencia y dimensiones del botón para enviar los cambios. */
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

/* Cambio visual aplicado al botón cuando el puntero pasa sobre él. */
button:hover{
    transform:scale(1.03);
    background:#f765c6;
}

/* Formato de los mensajes de error que genera la validación. */
label.error{
    color:#a01045;
    font-size:13px;
    margin-bottom:10px;
    margin-left:15px;
}

/* Borde destacado para los campos que no pasan la validación. */
input.error{
    border:1px solid #a01045;
}

</style>
</head>

<body>

<!-- Contenedor principal del formulario de edición del producto. -->
<div class="contenedor">

    <!-- Icono decorativo relacionado con productos y cajas. -->
    <div class="logo">
        <i class="fa-solid fa-box-open"></i>
    </div>

    <!-- Título de la página y explicación breve para el usuario. -->
    <div class="titulo">
        <h2>Editar Producto</h2>
        <p>Actualiza la información del producto</p>
    </div>

    <!-- Envía los datos por POST al archivo encargado de actualizar el producto. -->
    <form action="../productos/19.actualizarproductos.php" method="post" id="valieditarpro">

        <!-- Mantiene el código anterior para identificar el registro que se actualizará. -->
        <input type="hidden" name="codigo_original" value="<?= htmlspecialchars($codigo_original, ENT_QUOTES, 'UTF-8') ?>">

        <!-- Campo editable del código del producto, cargado con el valor actual. -->
        <label class="campo">
            <i class="fa-solid fa-barcode"></i>
            <input type="number" name="codigo" value="<?= htmlspecialchars($codigo, ENT_QUOTES, 'UTF-8') ?>" placeholder="Código">
        </label>

        <!-- Campo editable para el nombre del producto. -->
        <label class="campo">
            <i class="fa-solid fa-box"></i>
            <input type="text" name="nombre" value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>" placeholder="Nombre del producto">
        </label>

        <!-- Campo editable para la descripción del producto. -->
        <label class="campo">
            <i class="fa-solid fa-file-lines"></i>
            <input type="text" name="descripcion" value="<?= htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8') ?>" placeholder="Descripción">
        </label>

        <!-- Campo editable para el precio del producto. -->
        <label class="campo">
            <i class="fa-solid fa-dollar-sign"></i>
            <input type="number" name="precio" value="<?= htmlspecialchars($precio, ENT_QUOTES, 'UTF-8') ?>" placeholder="Precio">
        </label>

        <!-- Campo editable para el costo del producto. -->
        <label class="campo">
            <i class="fa-solid fa-money-bill"></i>
            <input type="number" name="costo" value="<?= htmlspecialchars($costo, ENT_QUOTES, 'UTF-8') ?>" placeholder="Costo">
        </label>

        <!-- Campo editable para las unidades disponibles en inventario. -->
        <label class="campo">
            <i class="fa-solid fa-warehouse"></i>
            <input type="number" name="stock" value="<?= htmlspecialchars($stock, ENT_QUOTES, 'UTF-8') ?>" placeholder="Stock">
        </label>

        <!-- Envía el formulario para procesar y guardar los cambios. -->
        <button type="submit">Actualizar producto</button>

    </form>
</div>

<script>

// Espera a que la página esté cargada antes de configurar las comprobaciones.
$(document).ready(function(){

    // Activa la validación del formulario antes de que se envíe.
    $("#valieditarpro").validate({

        // Reglas: todos los datos deben ingresarse y los campos indicados deben ser numéricos.
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

        // Textos en español que explican al usuario cómo corregir cada campo.
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
```
