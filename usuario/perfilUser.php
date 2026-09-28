<?php
session_start();

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor", "usuario"])) {
    header("Location: ../pagina/login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$ci_usuario = $_SESSION['CI'] ?? '';

if ($ci_usuario === '') {
    header("Location: ../pagina/login.php");
    exit();
}

$sql = "SELECT CI, nombre, direccion, celular, rol, imagen_perfil FROM usuario WHERE CI = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $ci_usuario);
$stmt->execute();

$resultado = $stmt->get_result();
$datosUsuario = $resultado->fetch_assoc();

$stmt->close();
$conexion->close();

if (!$datosUsuario) {
    die("Usuario no encontrado");
}

$imagenPerfil = !empty($datosUsuario['imagen_perfil'])
    ? $datosUsuario['imagen_perfil']
    : 'imgperfil.avif';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
<style>

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


.perfil-contenedor {
    grid-area: info;
    width: 100%;
    min-width: 0;
    padding: 35px 30px;
    box-sizing: border-box;
}

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

.perfil-foto-seccion {
    flex: 1 1 250px;
    min-width: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

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

.foto-perfil img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.nombre-perfil {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
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

.info-card {
    flex: 1 1 340px;
    min-width: 0;
    box-sizing: border-box;
}

.info-titulo {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
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

<?php include("../includes/header.php"); ?>
<?php include("../includes/includeuser.php"); ?>

<div class="perfil-contenedor">
    <div class="perfil-principal">
        <button type="button" class="btn-editar-lateral" onclick="window.location.href='../usuario/18.editarperfil.php'">
            <i class="fa-solid fa-pen-to-square"></i>
            Editar
        </button>

        <div class="perfil-foto-seccion">
            <div class="foto-perfil">
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

<div id="modalImagen" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>

        <h3>Cambiar foto de perfil</h3>

        <form action="../perfil/actualizarimgperfil.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="imagen" accept="image/*" required>
            <button type="submit">Subir imagen</button>
        </form>
    </div>
</div>

<script>
function abrirModal() {
    document.getElementById("modalImagen").style.display = "block";
}

function cerrarModal() {
    document.getElementById("modalImagen").style.display = "none";
}

window.onclick = function(event) {
    const modal = document.getElementById("modalImagen");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>