
<?php
session_start();

if ($_SESSION['rol'] != "usuario") {
    header("Location: ../usuario/09.register.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre_usuario = $_SESSION['nombre'] ?? '';

// ===== CARGAR DATOS DEL USUARIO DESDE BD =====
$sql = "SELECT CI, nombre, direccion, celular, rol, imagen_perfil FROM usuario WHERE nombre=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $nombre_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$datosUsuario = $resultado->fetch_assoc();

$stmt->close();

// Si el usuario no se encuentra, usar valores por defecto
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

// Determinar qué imagen mostrar
$imagenPerfil = (!empty($datosUsuario['imagen_perfil'])) ? $datosUsuario['imagen_perfil'] : 'imgperfil.avif';

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
<style>

body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 198px 1fr 260px;

    grid-template-rows: 70px 1fr;
    grid-template-areas:
        "barra barra barra"
        "menu info act"
        "pie pie pie";

    gap: 10px;
    height: 100vh;
    background: #ffffff;
}

.icono {
    width: 50px;
    height: 50px;
    background: #fdfdfd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icono i {
    color: #f1ecef;
    font-size: 20px;
}

h2 {
    font-size: 35px;
}

p {
    font-size: 20px;
}

div {
    color: black;
}

i {
    color: white;
}

.menu a {
    text-decoration: none;
    color: black;
}
.perfil-contenedor {
    grid-area: info;
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 25px;
    padding-top: 35px;
    padding-left: 170px;
}

.perfil-card {
    width: 400px;
    background: white;
    border-radius: 25px;
    border: 1px solid #ffffff;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 45px;
    box-sizing: border-box;
}

.foto-perfil {
    width: 250px;
    height: 250px;
    border-radius: 50%;
    border: 5px solid white;
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
    color: #fffefe;
    margin: 0 0 15px 0;
    text-align: center;
}

.btn-editar-perfil {
    margin-bottom: 20px;
    padding: 10px 20px;
    background: #080808;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}

.btn-editar-perfil:hover {
    background: #030303;
    transform: scale(1.05);
}

.info-card {
    width: 1000px;
    background: white;
    border-radius: 25px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    padding: 30px;
    box-sizing: border-box;
}

.info-titulo {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    margin: 0 0 20px 0;
    color: #333;
}

.info-dato {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px 15px;
    margin-bottom: 8px;
    border-radius: 12px;
}

.info-dato i {
    width: 50px;
    text-align: center;
    color: #ffffff;
    font-size: 26px;
}

.info-dato .etiqueta {
    font-family: 'Quicksand', sans-serif;
    font-size: 12px;
    color: #999;
    display: block;
}

.info-dato .valor {
    font-family: 'Quicksand', sans-serif;
    font-size: 20px;
    color: #333;
    display: block;
    margin-top: 2px;
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
    width: 400px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
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
    border: 2px solid #020202;
    border-radius: 8px;
    box-sizing: border-box;
}

.modal-content button {
    width: 100%;
    padding: 12px;
    background: #fffdfd;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
    transition: 0.3s;
}


</style>

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/includeuser.php"); ?>

<div class="perfil-contenedor">
    <div class="perfil-card">
        <div class="foto-perfil">
            <img src="../img/<?php echo htmlspecialchars($imagenPerfil); ?>" alt="Foto de perfil">
        </div>
        <div class="nombre-perfil">
            <?php echo htmlspecialchars($datosUsuario['nombre']); ?>
        </div>
        <button type="button" class="btn-editar-perfil" onclick="abrirModal()">
            <i class="fa-solid fa-edit"></i> Cambiar foto
        </button>
    </div>

    <div class="info-card">
        <h2 class="info-titulo">
            Información personal
        </h2>

        <div class="info-dato">
            <i class="fa-solid fa-id-card"></i>
            <div>
                <span class="etiqueta">CI</span>
                <span class="valor">
                    <?php echo htmlspecialchars($datosUsuario['CI']); ?>
                </span>
            </div>
        </div>

        <div class="info-dato">
            <i class="fa-solid fa-user"></i>
            <div>
                <span class="etiqueta">Nombre</span>
                <span class="valor">
                    <?php echo htmlspecialchars($datosUsuario['nombre']); ?>
                </span>
            </div>
        </div>

        <div class="info-dato">
            <i class="fa-solid fa-envelope"></i>
            <div>
                <span class="etiqueta">Correo electrónico</span>
                <span class="valor">
                    <?php echo htmlspecialchars($datosUsuario['direccion']); ?>
                </span>
            </div>
        </div>

        <div class="info-dato">
            <i class="fa-solid fa-phone"></i>
            <div>
                <span class="etiqueta">Celular</span>
                <span class="valor">
                    <?php echo htmlspecialchars($datosUsuario['celular']); ?>
                </span>
            </div>
        </div>

        <div class="info-dato">
            <i class="fa-solid fa-user-shield"></i>
            <div>
                <span class="etiqueta">Rol</span>
                <span class="valor">
                    <?php echo htmlspecialchars($datosUsuario['rol']); ?>
                </span>
            </div>
        </div>
    </div>
</div>

<div id="modalImagen" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal()">&times;</span>
        <h3>Cambiar foto de perfil</h3>
        <form action="../usuario/actualizar_imagen_perfil.php" method="POST" enctype="multipart/form-data">
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
