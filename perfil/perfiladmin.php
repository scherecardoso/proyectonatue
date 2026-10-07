<?php
// Se inicia la sesión para verificar que el usuario actual tenga acceso autorizado.
// Si la sesión no existe o el rol no corresponde a administrador, se lo redirige al login.
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    // Si el usuario no es administrador, no puede entrar a esta vista.
    header("Location: ../pagina/login.php");
    exit();
}

// Se crea la conexión a la base de datos local del proyecto.
// La BD utilizada aquí es "shena", la misma que guarda los usuarios y sus datos.
$conexion = new mysqli("localhost", "root", "", "shena");

// Si la conexión falla, se corta la ejecución para evitar errores en la página.
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Se obtiene el nombre del usuario que inició sesión para buscar sus datos en la tabla "usuario".
$nombre_usuario = $_SESSION['nombre'] ?? '';

// Se consulta la información personal del administrador actual.
// Se selecciona el registro que coincida con el nombre guardado en la sesión.
$sql = "SELECT CI, nombre, direccion, celular, rol, imagen_perfil FROM usuario WHERE nombre=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $nombre_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$datosUsuario = $resultado->fetch_assoc();

// Se cierra la sentencia preparada para liberar recursos.
$stmt->close();

// Si no se encuentran datos del usuario, se asignan valores predeterminados.
// Esto evita que la vista falle si la fila no existe o no tiene información completa.
if (!$datosUsuario) {
    $datosUsuario = [
        'CI' => 'N/A',
        'nombre' => $nombre_usuario,
        'direccion' => 'No disponible',
        'celular' => 'No disponible',
        'rol' => $_SESSION['rol'],
        'imagen_perfil' => 'imgperfil.avif'
    ];
}

// Se define la imagen del perfil a mostrar.
// Si el usuario no tiene una foto guardada, se usa una imagen por defecto.
$imagenPerfil = (!empty($datosUsuario['imagen_perfil'])) ? $datosUsuario['imagen_perfil'] : 'imgperfil.avif';

// Se cierra la conexión después de obtener los datos necesarios.
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Se cargan fuentes que le dan estilo más elegante a la vista del perfil. -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

    <style>

        /*
            Este bloque CSS define la estructura general del perfil del administrador.
            La página usa un layout tipo dashboard con barra superior, menú lateral y contenido principal.
        */

        html {
            overflow-x: hidden;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            max-width: 100%;
            overflow-x: hidden;

            /* Se divide la pantalla en dos columnas principales: menú y contenido. */
            display: grid;
            grid-template-columns: 330px minmax(0, 1fr);
            grid-template-rows: auto 1fr;
            grid-template-areas:
                "barra barra"
                "menu  info";
            gap: 0;
        }

        @media (max-width: 1199px) {
            body {
                /* En pantallas pequeñas se convierte la estructura a una sola columna. */
                grid-template-columns: minmax(0, 1fr);
                grid-template-rows: auto auto 1fr;
                grid-template-areas:
                    "barra"
                    "menu"
                    "info";
            }
        }

        /*
            El contenedor principal del perfil se ubica en la zona de información central.
            Tiene un ancho máximo para que la vista se vea ordenada y legible.
        */
        .perfil-contenedor {
            grid-area: info;
            min-width: 0;
            box-sizing: border-box;
            padding: 35px clamp(15px, 4vw, 50px);
        }

        .perfil-principal {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 30px 5%;
            padding: clamp(20px, 5%, 45px);
            box-sizing: border-box;
            position: relative;
        }

        /* Botón para redirigir a la edición del perfil. */
        .btn-editar-lateral {
            position: absolute;
            top: 25px;
            right: 25px;
            padding: 9px 18px;
            background: #fb7cb7;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-editar-lateral:hover {
            background: #fd78b6;
            transform: scale(1.05);
        }

        /* Sección de la foto de perfil y nombre del usuario. */
        .perfil-foto-seccion {
            flex: 1 1 220px;
            min-width: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .foto-perfil {
            width: 100%;
            max-width: 220px;
            aspect-ratio: 1;
            height: auto;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 20px;
            position: relative;
        }

        .foto-perfil img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .nombre-perfil {
            font-family: 'Playfair Display', serif;
            font-size: clamp(22px, 2.5vw, 28px);
            color: #000000;
            margin-bottom: 18px;
            text-align: center;
            word-break: break-word;
        }

        .btn-editar-perfil {
            padding: 10px 20px;
            background: #fb7cb7;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-editar-perfil:hover {
            background: #fd78b6;
            transform: scale(1.05);
        }

        /*
            Bloque que organiza la información personal del usuario.
            Cada fila contiene un icono, una etiqueta y el valor correspondiente.
        */
        .info-card {
            flex: 2 1 300px;
            min-width: 0;
            box-sizing: border-box;
        }

        .info-titulo {
            font-family: 'Playfair Display', serif;
            font-size: clamp(22px, 2.5vw, 28px);
            margin: 0 0 25px 0;
            color: #ff5ca8;
        }

        .info-dato {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 12px;
            transition: 0.2s;
        }

        .info-dato:hover {
            background: #fff7fa;
        }

        .info-dato > div {
            min-width: 0;
        }

        .info-dato i {
            width: 45px;
            flex-shrink: 0;
            text-align: center;
            color: #020202;
            font-size: 23px;
        }

        .info-dato .etiqueta {
            font-family: 'Quicksand', sans-serif;
            font-size: 15px;
            color: #ff5ca8;
            display: block;
        }

        .info-dato .valor {
            font-family: 'Quicksand', sans-serif;
            font-size: 18px;
            color: #333;
            display: block;
            margin-top: 3px;
            word-break: break-word;
        }

        /*
            Estilos del modal para cambiar la imagen de perfil.
            Se usa una capa oscura de fondo y un contenedor centrado.
        */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow-y: auto;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10vh auto;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #efefef;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
        }

        .modal-content h3 {
            margin-top: 0;
            color: #333;
            font-family: 'Playfair Display', serif;
        }

        .modal-content input[type="file"] {
            width: 100%;
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #efefef;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .modal-content button {
            width: 100%;
            padding: 12px;
            background: #fd7eba;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: 0.3s;
        }

        .modal-content button:hover {
            background: #fd78b6;
        }

        /* Ajustes responsivos para pantallas medianas y pequeñas. */
        @media (max-width: 850px) {
            .perfil-principal {
                padding-top: 70px;
            }

            .info-card {
                flex-basis: 100%;
            }
        }

        @media (max-width: 600px) {
            .perfil-contenedor {
                padding: 20px 12px 30px;
            }

            .perfil-principal {
                padding: 65px 15px 25px;
                border-radius: 16px;
            }

            .btn-editar-lateral {
                top: 15px;
                right: 15px;
                padding: 8px 15px;
            }

            .foto-perfil {
                max-width: 170px;
            }

            .info-dato {
                gap: 10px;
                padding: 10px 8px;
            }

            .info-dato i {
                width: 32px;
                font-size: 20px;
            }

            .info-dato .valor {
                font-size: 16px;
            }

            .modal-content {
                padding: 22px;
            }
        }
    </style>
</head>

<body>

<?php
// Se incluyen los menús o headers que se reutilizan en la página del administrador.
// Esto ayuda a mantener el mismo diseño visual en todas las vistas del sistema.
include("../includes/header.php");
include("../includes/includeadmin.php");
?>

<!-- Se abre el contenedor de perfil principal del administrador. -->
<div class="perfil-contenedor">
    <div class="perfil-principal">

        <!-- Botón superior para editar la información general del perfil. -->
        <button type="button" class="btn-editar-lateral" onclick="window.location.href='../usuario/18.editarperfil.php'">
            <i class="fa-solid fa-pen-to-square"></i>
            Editar
        </button>

        <!-- Sección de foto y nombre del perfil. -->
        <div class="perfil-foto-seccion">
            <div class="foto-perfil">
                <img src="../img_perfil/<?php echo htmlspecialchars($imagenPerfil); ?>" alt="Foto de perfil">
            </div>

            <div class="nombre-perfil">
                <?php echo htmlspecialchars($datosUsuario['nombre']); ?>
            </div>

            <!-- Botón para abrir el modal de cambio de foto. -->
            <button type="button" class="btn-editar-perfil" onclick="abrirModal()">
                <i class="fa-solid fa-edit"></i>
                Cambiar foto
            </button>
        </div>

        <!-- Sección con la información personal del usuario. -->
        <div class="info-card">
            <h2 class="info-titulo">Información personal</h2>

            <!-- Fila del documento de identidad. -->
            <div class="info-dato">
                <i class="fa-solid fa-id-card"></i>
                <div>
                    <span class="etiqueta">CI</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['CI']); ?></span>
                </div>
            </div>

            <!-- Fila del nombre completo. -->
            <div class="info-dato">
                <i class="fa-solid fa-user"></i>
                <div>
                    <span class="etiqueta">Nombre</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['nombre']); ?></span>
                </div>
            </div>

            <!-- Fila de la dirección o correo según el modelo del proyecto. -->
            <div class="info-dato">
                <i class="fa-solid fa-envelope"></i>
                <div>
                    <span class="etiqueta">Correo electrónico</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['direccion']); ?></span>
                </div>
            </div>

            <!-- Fila del teléfono/celular. -->
            <div class="info-dato">
                <i class="fa-solid fa-phone"></i>
                <div>
                    <span class="etiqueta">Celular</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['celular']); ?></span>
                </div>
            </div>

            <!-- Fila del rol asignado en el sistema. -->
            <div class="info-dato">
                <i class="fa-solid fa-user-shield"></i>
                <div>
                    <span class="etiqueta">Rol</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['rol']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para subir una nueva imagen de perfil. -->
<div id="modalImagen" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>

        <h3>Cambiar foto de perfil</h3>

        <!-- El formulario envia la imagen a un archivo PHP que actualiza la foto en la BD. -->
        <form action="../perfil/actualizarimgperfil.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit">Subir imagen</button>
        </form>
    </div>
</div>

<script>
// Abre el modal para seleccionar una nueva foto de perfil.
function abrirModal() {
    document.getElementById("modalImagen").style.display = "block";
}

// Cierra el modal si el usuario cancela la acción o pulsa la X.
function cerrarModal() {
    document.getElementById("modalImagen").style.display = "none";
}

// Si el usuario hace clic fuera del modal, también se cierra la ventana emergente.
window.onclick = function(event) {
    const modal = document.getElementById("modalImagen");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>