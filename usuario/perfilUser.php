<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "usuario") {
    header("Location: ../usuario/09.register.php");
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

if (!$datosUsuario) {
    $datosUsuario = [
        'CI' => 'N/A',
        'nombre' => $_SESSION['nombre'] ?? '',
        'direccion' => 'No disponible',
        'celular' => 'No disponible',
        'rol' => $_SESSION['rol'],
        'imagen_perfil' => 'imgperfil.avif'
    ];
}

$imagenPerfil = !empty($datosUsuario['imagen_perfil'])
    ? $datosUsuario['imagen_perfil']
    : 'imgperfil.avif';

$conexion->close();
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
    grid-template-columns: 198px minmax(0, 1fr) 300px;
    grid-template-rows: 70px 1fr;
    grid-template-areas:
        "barra barra barra"
        "menu info act";
    gap: 10px;
    min-height: 100vh;
    background: #ffffff;
    overflow-x: hidden;
}

.menu a {
    text-decoration: none;
    color: black;
}

.perfil-contenedor {
    flex: 1 1 58%;
    width: 58%;
    max-width: 1250px;
    margin: 0 0 0 2%;
    margin-left: 10%;
    padding: 35px 2% 35px;
    box-sizing: border-box;
}

.perfil-principal {
    width: 190%;
    height: 70%;
    min-height: 0;
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-wrap: wrap;
    gap: 5%;
    padding: 5%;
    box-sizing: border-box;
    align-items: center;
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
    flex: 1 1 30%;
    min-width: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.foto-perfil {
    width: 70%;
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
    flex: 1 1 55%;
    min-width: 260px;
    width: 55%;
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
    margin: 15% auto;
    padding: 30px;
    border-radius: 15px;
    border: 1px solid #efefef;
    width: 400px;
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

@media (max-width: 1100px) {
    .perfil-principal {
        gap: 4%;
        padding: 4%;
    }

    .foto-perfil {
        width: 65%;
    }
}

@media (max-width: 850px) {
    .perfil-principal {
        text-align: center;
    }

    .cajas-inferiores {
        flex-direction: column;
    }
}

@media (max-width: 600px) {
    .perfil-contenedor {
        width: 100%;
        padding: 15px 3% 30px;
    }

    .perfil-principal {
        padding: 6% 4%;
    }

    .caja-inferior {
        padding: 6%;
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