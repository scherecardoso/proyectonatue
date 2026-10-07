<?php
// Inicia o recupera la sesión para validar el acceso a esta página.
session_start();

// Permite el acceso únicamente a los roles reconocidos por el sistema.
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor", "usuario"])) {
    // Los usuarios sin permiso deben iniciar sesión.
    header("Location: ../pagina/login.php");
    exit();
}

// Conecta con la base de datos que contiene la información de los usuarios.
$conexion = new mysqli("localhost", "root", "", "shena");

// Interrumpe la ejecución si la conexión con la base de datos falla.
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recupera el CI guardado en la sesión para identificar la cuenta activa.
$ci_usuario = $_SESSION['CI'] ?? '';

// Sin un CI no se puede consultar el perfil, así que se redirige al login.
if ($ci_usuario === '') {
    header("Location: ../pagina/login.php");
    exit();
}

// Selecciona solo los campos que se mostrarán en la página del perfil.
$sql = "SELECT CI, nombre, direccion, celular, rol, imagen_perfil FROM usuario WHERE CI = ?";

// La consulta preparada enlaza el CI como parámetro en lugar de concatenarlo al SQL.
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $ci_usuario);
$stmt->execute();

// Obtiene la fila del usuario en formato de arreglo asociativo.
$resultado = $stmt->get_result();
$datosUsuario = $resultado->fetch_assoc();

// Libera la consulta y cierra la conexión una vez recuperados los datos.
$stmt->close();
$conexion->close();

// Informa si no existe un registro para el CI de la sesión.
if (!$datosUsuario) {
    die("Usuario no encontrado");
}

// Usa la imagen guardada o la imagen predeterminada si el usuario aún no tiene una.
$imagenPerfil = !empty($datosUsuario['imagen_perfil'])
    ? $datosUsuario['imagen_perfil']
    : 'imgperfil.avif';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Carga las fuentes decorativas y los iconos usados en el diseño del perfil. -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
<style>

/* Diseño general: cuadrícula para la barra superior, el menú y el contenido. */
body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 330px minmax(0, 1fr);
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "barra barra"
        "menu info";
    gap: 10px;
    min-height: 100vh;
    background: #ffffff;
    overflow-x: hidden;
}


/* Contenedor del contenido del perfil dentro del área principal de la cuadrícula. */
.perfil-contenedor {
    grid-area: info;
    width: 100%;
    min-width: 0;
    padding: 35px 30px;
    box-sizing: border-box;
}

/* Tarjeta que reúne la sección de foto y la información personal. */
.perfil-principal {
    width: 100%;
    max-width: 950px;
    margin: 0 auto;
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 40px;
    padding: 50px 40px;
    box-sizing: border-box;
    position: relative;
}

/* Botón superpuesto en la tarjeta para ir a la edición de datos personales. */
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

/* Columna que centra la foto, el nombre y el botón para cambiar la imagen. */
.perfil-foto-seccion {
    flex: 1 1 250px;
    min-width: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* Marco circular que contiene y recorta la foto del usuario. */
.foto-perfil {
    width: 100%;
    max-width: 230px;
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

/* La imagen llena el marco sin perder sus proporciones. */
.foto-perfil img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Presentación del nombre debajo de la fotografía. */
.nombre-perfil {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #000000;
    margin-bottom: 18px;
    text-align: center;
    word-break: break-word;
}

/* Botón que abre el formulario para subir una nueva foto. */
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

/* Columna que contiene los datos de la cuenta. */
.info-card {
    flex: 1 1 340px;
    min-width: 0;
    box-sizing: border-box;
}

/* Título de la sección de información personal. */
.info-titulo {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    margin: 0 0 25px 0;
    color: #ff5ca8;
}

/* Cada fila agrupa un icono, una etiqueta y el valor de un dato. */
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

/* Tamaño y alineación común para los iconos de los datos. */
.info-dato i {
    width: 45px;
    min-width: 45px;
    text-align: center;
    color: #020202;
    font-size: 23px;
}

.info-dato > div {
    min-width: 0;
}

/* Estilo de la etiqueta que indica qué dato se muestra. */
.info-dato .etiqueta {
    font-family: 'Quicksand', sans-serif;
    font-size: 15px;
    color: #ff5ca8;
    display: block;
}

/* Estilo del valor; los textos largos pueden ajustarse a varias líneas. */
.info-dato .valor {
    font-family: 'Quicksand', sans-serif;
    font-size: 18px;
    color: #333;
    display: block;
    margin-top: 3px;
    word-break: break-word;
}

/* Capa oscura que cubre la página mientras se cambia la foto. */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

/* Panel del cuadro de diálogo con el formulario de carga. */
.modal-content {
    background-color: #fefefe;
    margin: 15vh auto;
    padding: 30px;
    border-radius: 15px;
    border: 1px solid #efefef;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
}

/* Control para cerrar el cuadro de diálogo. */
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

/* Presentación del selector de archivos de imagen. */
.modal-content input[type="file"] {
    width: 100%;
    margin: 15px 0;
    padding: 10px;
    border: 1px solid #efefef;
    border-radius: 8px;
    box-sizing: border-box;
}

/* Estilo del botón que envía la imagen seleccionada. */
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


/* En pantallas medianas, apila las áreas del menú y el contenido. */
@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto;
        grid-template-areas:
            "barra"
            "menu"
            "info";
        gap: 0;
    }

    .perfil-contenedor {
        padding: 30px 20px 40px;
    }
}


/* En pantallas más estrechas, coloca la foto encima de la información. */
@media (max-width: 850px) {
    .perfil-principal {
        flex-direction: column;
        flex-wrap: nowrap;
        align-items: stretch;
        gap: 25px;
        padding: 70px 30px 35px;
    }

    .perfil-foto-seccion {
        flex: none;
        width: 100%;
    }

    .info-card {
        flex: none;
        width: 100%;
    }

    .info-titulo {
        text-align: center;
        font-size: 25px;
        margin-bottom: 15px;
    }
}


/* Reduce márgenes, espacios y tamaños para facilitar el uso en móviles. */
@media (max-width: 600px) {
    .perfil-contenedor {
        padding: 15px 10px 30px;
    }

    .perfil-principal {
        padding: 65px 15px 25px;
        border-radius: 16px;
    }

    .btn-editar-lateral {
        top: 15px;
        right: 15px;
        padding: 8px 14px;
        font-size: 13px;
    }

    .foto-perfil {
        max-width: 170px;
    }

    .nombre-perfil {
        font-size: 24px;
    }

    .info-titulo {
        font-size: 22px;
    }

    .info-dato {
        gap: 10px;
        padding: 10px;
    }

    .info-dato i {
        width: 32px;
        min-width: 32px;
        font-size: 19px;
    }

    .info-dato .etiqueta {
        font-size: 13px;
    }

    .info-dato .valor {
        font-size: 16px;
    }

    .modal-content {
        margin: 20vh auto;
        padding: 22px;
    }
}


/* Ajustes adicionales para teléfonos de ancho muy reducido. */
@media (max-width: 400px) {
    .foto-perfil {
        max-width: 140px;
    }

    .nombre-perfil {
        font-size: 21px;
    }

    .info-dato .valor {
        font-size: 15px;
    }
}
</style>
</head>
<body>

<!-- Incluye la barra superior y el menú de navegación para la cuenta activa. -->
<?php include("../includes/header.php"); ?>
<?php include("../includes/includeuser.php"); ?>

<!-- Tarjeta principal del perfil con accesos de edición, foto y datos. -->
<div class="perfil-contenedor">
    <div class="perfil-principal">
        <!-- Abre la página de edición de los datos personales. -->
        <button type="button" class="btn-editar-lateral" onclick="window.location.href='../usuario/18.editarperfil.php'">
            <i class="fa-solid fa-pen-to-square"></i>
            Editar
        </button>

        <!-- Muestra la foto actual, el nombre y la acción para cambiar la foto. -->
        <div class="perfil-foto-seccion">
            <div class="foto-perfil">
                <!-- Escapa el nombre de archivo antes de incluirlo en el atributo HTML. -->
                <img src="../img_perfil/<?php echo htmlspecialchars($imagenPerfil); ?>" alt="Foto de perfil">
            </div>

            <div class="nombre-perfil">
                <?php echo htmlspecialchars($datosUsuario['nombre']); ?>
            </div>

            <button type="button" class="btn-editar-perfil" onclick="abrirModal()">
                <i class="fa-solid fa-edit"></i>
                Cambiar foto
            </button>
        </div>

        <!-- Presenta los datos recuperados de la cuenta en filas fáciles de leer. -->
        <div class="info-card">
            <h2 class="info-titulo">Información personal</h2>

            <div class="info-dato">
                <i class="fa-solid fa-id-card"></i>
                <div>
                    <span class="etiqueta">CI</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['CI']); ?></span>
                </div>
            </div>

            <div class="info-dato">
                <i class="fa-solid fa-user"></i>
                <div>
                    <span class="etiqueta">Nombre</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['nombre']); ?></span>
                </div>
            </div>

            <div class="info-dato">
                <i class="fa-solid fa-envelope"></i>
                <div>
                    <span class="etiqueta">Correo electrónico</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['direccion']); ?></span>
                </div>
            </div>

            <div class="info-dato">
                <i class="fa-solid fa-phone"></i>
                <div>
                    <span class="etiqueta">Celular</span>
                    <span class="valor"><?php echo htmlspecialchars($datosUsuario['celular']); ?></span>
                </div>
            </div>

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

<!-- Cuadro de diálogo oculto inicialmente para seleccionar y subir una foto. -->
<div id="modalImagen" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>

        <h3>Cambiar foto de perfil</h3>

        <!-- Envía el archivo al proceso que actualiza la imagen del perfil. -->
        <form action="../perfil/actualizarimgperfil.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit">Subir imagen</button>
        </form>
    </div>
</div>

<script>
// Muestra el cuadro de diálogo al pulsar el botón para cambiar la foto.
function abrirModal() {
    document.getElementById("modalImagen").style.display = "block";
}

// Oculta el cuadro de diálogo al pulsar su control de cierre.
function cerrarModal() {
    document.getElementById("modalImagen").style.display = "none";
}

// También permite cerrar el cuadro al pulsar en el fondo fuera del panel.
window.onclick = function(event) {
    const modal = document.getElementById("modalImagen");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>