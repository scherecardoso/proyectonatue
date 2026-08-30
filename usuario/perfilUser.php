
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

$nombre_usuario = $_SESSION['nombre'];

$sqlPedidos = "SELECT COUNT(*) AS total FROM pedidos WHERE nombre='$nombre_usuario'";
$resultadoPedidos = $conexion->query($sqlPedidos);
$filaPedidos = $resultadoPedidos->fetch_assoc();
$totalpedido = $filaPedidos['total'];
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
    background: #ffdcec;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icono i {
    color: #ff5ca8;
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
    color: black;
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
    height: 430px;
    background: white;
    border-radius: 25px;
    border: 1px solid #f3dce7;
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
    box-shadow: 0 5px 18px rgba(255, 92, 168, 0.20);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 20px;
}


.foto-perfil img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.nombre-perfil {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: #333;
    margin: 0;
    text-align: center;
}

.info-card {
    width: 1000px;
    height: 430px;
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
    color: #ff5ca8;
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


</style>

</head>


<body>


<?php include("../includes/header.php"); ?>
<?php include("../includes/includeUser.php"); ?>


<div class="perfil-contenedor">
    <div class="perfil-card">
        <div class="foto-perfil">
            <img src="../img/imgperfil.avif" alt="Foto de perfil">
        </div>
        <div class="nombre-perfil">
        </div>
    </div>

    <div class="info-card">
        <h2 class="info-titulo">
            Información personal
        </h2>
  
        <div class="info-dato">

            <i class="fa-solid fa-id-card"></i>
            <div>
                <span class="etiqueta">
                    CI
                </span>

                <span class="valor">
                    7834562
                </span>

            </div>

        </div>
        <div class="info-dato">
            <i class="fa-solid fa-user"></i>

            <div>

                <span class="etiqueta">
                    Nombre
                </span>

                <span class="valor">
                    Valentina
                </span>

            </div>

        </div>

        <div class="info-dato">

            <i class="fa-solid fa-envelope"></i>

            <div>
                <span class="etiqueta">
                    Correo electrónico
                </span>

                <span class="valor">
                    valentina@gmail.com
                </span>

            </div>

        </div>
        <div class="info-dato">

            <i class="fa-solid fa-phone"></i>

            <div>

                <span class="etiqueta">
                    Celular
                </span>

                <span class="valor">
                    71234567
                </span>

            </div>

        </div>

        <div class="info-dato">

            <i class="fa-solid fa-user-shield"></i>

            <div>

                <span class="etiqueta">
                    Rol
                </span>

                <span class="valor">
                    Usuario
                </span>

            </div>

        </div>


        </div>


            </div>

        </div>


    </div>

</div>


</body>

</html>