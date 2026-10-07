
<?php
// Se inicia la sesión para verificar el acceso del usuario a esta vista.
session_start();

// Se valida que el usuario autenticado sea administrador; en caso contrario, se lo redirige al login.
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador") {
    header("Location: ../pagina/login.php");
    exit();
}

// Configuración de la conexión a la base de datos.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se establece la conexión con MySQL.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se detiene la ejecución y se muestra el error.
if ($conn->connect_error) {
    die("Error de conexión");
}

// Se procesa el formulario cuando se envía por POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Se reciben los datos enviados desde el formulario.
    $CI = $_POST['CI'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $celular = $_POST['celular'];
    $rol = $_POST['rol'];

    // Consulta preparada para insertar al nuevo usuario con estado activo y una imagen predeterminada.
    $sql = "INSERT INTO usuario (CI, nombre, direccion, celular, rol, estado, imagen_perfil)
            VALUES (?, ?, ?, ?, ?, 'activo', 'imgperfil.avif')";

    $stmt = $conn->prepare($sql);

    if ($stmt) {

        // Se enlazan los valores para evitar inyección SQL.
        $stmt->bind_param("issis", $CI, $nombre, $direccion, $celular, $rol);

        if ($stmt->execute()) {

            // Si el registro fue exitoso, se redirige a la vista de usuarios.
            header("Location: ../usuario/12.readusuarios.php");
            exit();

        } else {
            $error = "No se pudo crear el usuario.";
        }

        $stmt->close();

    } else {
        $error = "Error al preparar la consulta.";
    }
}

// Cierre de la conexión al finalizar el proceso.
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Crear usuario</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
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
    position:relative;
    width:500px;
    background:white;
    padding:40px;
    border-radius:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    border:2px solid #f8c6e5;
}

.btn-volver{
    position:absolute;
    top:18px;
    left:20px;
    color: #ff5ca8;
    text-decoration:none;
    font-size:14px;
    font-weight:bold;
}

.btn-volver:hover{
    color:#f06ac3;
}

h2{
    text-align:center;
    font-size:42px;
    font-family:'Playfair Display', serif;
    color:#222;
    margin-bottom:30px;
}

form{
    display:flex;
    flex-direction:column;
}

input,
select{
    width:100%;
    height:58px;
    color:#777;
    border:1px solid #f5a3d5;
    border-radius:40px;
    padding:0 20px;
    margin-bottom:18px;
    background:#fafafa;
    outline:none;
}

select{
    cursor:pointer;
}

input:focus,
select:focus{
    border-color:#f06ac3;
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
    margin-bottom:10px;
    margin-left:15px;
}

input.error,
select.error{
    border:1px solid #a01045;
}

.error-servidor{
    color:#a01045;
    text-align:center;
    margin-bottom:20px;
    font-size:14px;
}

@media(max-width:768px){

    .contenedor{
        width:100%;
        max-width:430px;
        padding:30px;
        margin:20px;
    }

    h2{
        font-size:35px;
    }

    input,
    select{
        height:54px;
    }

}

</style>
</head>

<body>

<!-- Contenedor principal de la vista para crear usuarios. -->
<div class="contenedor">

    <!-- Botón para volver a la vista del administrador. -->
    <a href="../admin/06.admin.php" class="btn-volver">← Volver</a>

    <!-- Título de la sección. -->
    <h2>Crear usuario</h2>

    <?php if (isset($error)) { ?>
        <div class="error-servidor">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <!-- Formulario para registrar un nuevo usuario. -->
    <form method="post" id="formusuarios">

        <input type="number" name="CI" placeholder="CI" required>

        <input type="text" name="nombre" placeholder="Nombre" required>

        <input type="email" name="direccion" placeholder="Correo electrónico" required>

        <input type="number" name="celular" placeholder="Celular" required>

        <select name="rol" required>
            <option value="">Seleccionar rol</option>
            <option value="administrador">Administrador</option>
            <option value="vendedor">Vendedor</option>
            <option value="usuario">Usuario</option>
        </select>

        <button type="submit">Crear usuario</button>

    </form>

</div>

<script>

// Se inicializa la validación del formulario con jQuery Validate.
$(document).ready(function(){

    $("#formusuarios").validate({

        rules:{
            CI:{
                required:true,
                number:true,
                minlength:6,
                maxlength:12
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
                minlength:8,
                maxlength:8
            },

            rol:{
                required:true
            }
        },

        messages:{
            CI:{
                required:"Por favor, ingresa el CI",
                number:"Solo se aceptan números",
                minlength:"El CI debe tener al menos 6 números",
                maxlength:"El CI no puede tener más de 12 números"
            },

            nombre:{
                required:"El nombre es obligatorio"
            },

            direccion:{
                required:"Por favor, ingresa el correo electrónico",
                email:"Por favor, ingresa un correo electrónico válido"
            },

            celular:{
                required:"El celular es obligatorio",
                number:"Solo se aceptan números",
                minlength:"El celular debe tener 8 números",
                maxlength:"El celular debe tener 8 números"
            },

            rol:{
                required:"Por favor, selecciona un rol"
            }
        }

    });

});

</script>

</body>
</html>
