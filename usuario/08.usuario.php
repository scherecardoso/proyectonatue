<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "usuario") {
    header("Location: ../usuario/09.register.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$nombre_usuario = $_SESSION['nombre'];

$sql = "SELECT imagen_perfil FROM usuario WHERE nombre = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $nombre_usuario);
$stmt->execute();

$resultado = $stmt->get_result();
$datosUsuario = $resultado->fetch_assoc();

$stmt->close();

$imagenPerfil = (!empty($datosUsuario['imagen_perfil']))
    ? $datosUsuario['imagen_perfil']
    : 'imgperfil.avif';

$sqlPedidos = "SELECT COUNT(*) AS total FROM pedidos WHERE nombre = ?";

$stmtPedidos = $conexion->prepare($sqlPedidos);
$stmtPedidos->bind_param("s", $nombre_usuario);
$stmtPedidos->execute();

$resultadoPedidos = $stmtPedidos->get_result();
$filaPedidos = $resultadoPedidos->fetch_assoc();

$totalpedido = $filaPedidos['total'];

$stmtPedidos->close();

$sqlListaPedidos = "
    SELECT id, fecha, estado
    FROM pedidos
    WHERE nombre = ?
    ORDER BY id DESC
";

$stmtLista = $conexion->prepare($sqlListaPedidos);
$stmtLista->bind_param("s", $nombre_usuario);
$stmtLista->execute();

$pedidos = $stmtLista->get_result();

?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

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
.info {
    grid-area: info;
    display: grid;
    grid-template-areas:
    "bienvenida"
    "cards"
    "contenido";
    grid-template-rows: auto auto 1fr;
    gap: 25px;
    padding: 25px 10px;
    min-width: 0;
    width: 100%;
}
.bienvenida {
    grid-area: bienvenida;
    width: 100%;
    max-width: 900px;
    min-height: 220px;
    border-radius: 33px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 25px;
    padding: 20px 40px;
    background: #fdeff6;
    font-size: 30px;
    font-family: 'Playfair Display', serif;
    color: #272020;
    margin: 0 auto;
    transform: translateX(-65px);
}
.circulo {
    width: 180px;
    height: 180px;
    min-width: 180px;
    border-radius: 50%;
    background: white;
    border: 3px solid #cfcfcf;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.circulo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.texto {
    min-width: 0;
}
.texto h2 {
    margin: 0 0 15px 0;
    font-size: 35px;
    line-height: 1.2;
}
.texto p {
    margin: 0;
    font-size: 20px;
    line-height: 1.5;
}
.cards {
    grid-area: cards;
    width: 100%;
    max-width: 980px;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 8%;
    margin: 0 auto;
    transform: translateX(-90px);
}
.card {
    width: 100%;
    min-height: 225px;
    background-color: #ffffffe3;
    border-radius: 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 5px 18px rgba(172, 126, 126, 0.05);
    border: 1px solid #efefef;
    text-align: center;
    padding: 20px;
}
.card a {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    height: 100%;
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
    color: #ff78b8;
    font-size: 20px;
}
.card h3 {
    margin: 0;
    font-size: 28px;
    color: #000;
}
.card p {
    margin: 0;
    font-size: 14px;
    color: #777;
}
.contenido {
    grid-area: contenido;
    width: 100%;
    max-width: 900px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: minmax(0, 1fr);
    gap: 25px;
    min-width: 0;
}
.resumen {
    width: 100%;
    min-height: 250px;
    background: #ffffff;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 20px;
    color: #ff78b8;
    font-size: 28px;
    overflow-x: auto;
    transform: translateX(-80px);
}
.pedidos {
    width: 100%;
    min-height: 450px;
    background: #ffffff;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 20px;
    color: #ff78b8;
    font-size: 28px;
}
.titulo-caja {
    color: #ff78b8;
    font-size: 28px;
    margin: 0 0 20px 0;
    text-align: center;
}
.tabla-pedidos {
    width: 90%;
    margin: auto;
    border-collapse: collapse;
    font-size: 16px;
    color: #555;
    min-width: 500px;
}
.tabla-pedidos th {
    text-align: left;
    padding: 10px;
    border-bottom: 1px solid #eeeeee;
}
.tabla-pedidos td {
    padding: 10px;
    border-bottom: 1px solid #f3f3f3;
}
.act {
    grid-area: act;
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 10px;
    margin-top: 2px;
    margin-left: -90%;
    width: 85%;
    max-width: 300px;
    justify-self: start;
    border-radius: 25px;
}
.cuadrado-vertical {
    width: 210%;
    height: 62%;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    border-radius: 25px;
    box-sizing: border-box;
    background-color: #ffffffe3;
}
.acciones {
    background: #ffffff;
    width: 100%;
    min-height: 320px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 25px;
}
.resumen-sistema {
    background: #ffffff;
    width: 100%;
    min-height: 320px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 25px;
}
.actividad {
    background: #ffffff;
    width: 100%;
    min-height: 320px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 25px;
}
.lista-acciones {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 25px;
    padding: 20px 35px;
    margin: 0;
    font-size: 18px;
    color: #444;
}
.lista-acciones i {
    color: #ff78b8;
    margin-right: 12px;
}
.lista-sistema {
    list-style: none;
    padding: 20px 35px;
    margin: 0;
}
.lista-sistema li {
    display: flex;
    justify-content: space-between;
    margin-bottom: 22px;
    font-size: 18px;
    color: #444;
}
.lista-actividad {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 25px;
    padding: 20px 35px;
    margin: 0;
    font-size: 17px;
    color: #444;
}
.lista-actividad i {
    color: #ff78b8;
    margin-right: 12px;
}
.menu a {
    text-decoration: none;
    color: black;
}
@media (max-width: 1200px) {
body {
    grid-template-columns: 180px minmax(0, 1fr);
    grid-template-areas:
    "barra barra"
    "menu info";
}
.act {
    display: none;
}
.info {
    padding: 25px;
}
    .bienvenida,
    .cards,
.contenido {
    max-width: 950px;
}
}
@media (max-width: 900px) {
body {
    grid-template-columns: 160px minmax(0, 1fr);
}
.bienvenida {
    padding: 20px;
    gap: 20px;
    transform: none;
}
.circulo {
    width: 140px;
    height: 140px;
    min-width: 140px;
}
.texto h2 {
    font-size: 28px;
}
.texto p {
    font-size: 17px;
}
.cards {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
    transform: none;
}
.card {
    min-height: 190px;
}
}
@media (max-width: 768px) {
body {
    display: block;
    min-height: 100vh;
    overflow-x: hidden;
}
.info {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px 15px;
    margin: 0;
}
.bienvenida {
    width: 100%;
    min-height: auto;
    padding: 25px 20px;
    flex-direction: column;
    text-align: center;
    border-radius: 25px;
    gap: 20px;
}
.circulo {
    width: 120px;
    height: 120px;
    min-width: 120px;
}
.texto h2 {
    font-size: 26px;
    margin-bottom: 10px;
}
.texto p {
    font-size: 16px;
}
.cards {
    width: 100%;
    margin-left: 0;
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}
.card {
    min-height: 150px;
    width: 100%;
}
.contenido {
    width: 100%;
.resumen {
    transform: none;
}
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin: 0;
}
.resumen {
    width: 100%;
    min-height: 250px;
    padding: 15px;
    border-radius: 25px;
    overflow-x: auto;
}
.pedidos {
    width: 100%;
    min-height: 300px;
    border-radius: 25px;
}
.titulo-caja {
    font-size: 23px;
}
.tabla-pedidos {
    width: 100%;
    min-width: 450px;
    font-size: 13px;
}
    .tabla-pedidos th,
.tabla-pedidos td {
    padding: 8px;
}
}
@media (max-width: 480px) {
.info {
    padding: 15px 10px;
}
.bienvenida {
    padding: 20px 15px;
    border-radius: 22px;
}
.circulo {
    width: 100px;
    height: 100px;
    min-width: 100px;
}
.texto h2 {
    font-size: 22px;
}
.texto p {
    font-size: 14px;
}
.card {
    min-height: 135px;
    border-radius: 20px;
}
.icono {
    width: 45px;
    height: 45px;
}
.card h3 {
    font-size: 24px;
}
.card p {
    font-size: 13px;
}
.resumen {
    border-radius: 22px;
    padding: 12px;
}
.titulo-caja {
    font-size: 21px;
}
}
</style>

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php include("../includes/includeuser.php"); ?>

<aside class="act">

    <div class="cuadrado-vertical"></div>

    <div class="cuadrado-vertical"></div>

</aside>

<main class="info">

    <section class="bienvenida">

        <div class="circulo">

            <img
                src="../img/<?php echo htmlspecialchars($imagenPerfil); ?>"
                alt="Foto de perfil"
            >

        </div>

        <div class="texto">

            <h2>
                BIENVENIDA <?php echo htmlspecialchars($_SESSION['nombre']); ?>
            </h2>

            <p>
                Aquí puedes revisar tus pedidos, favoritos y administrar tu cuenta.
            </p>

        </div>

    </section>

    <section class="cards">

        <article class="card">

            <div class="icono">

                <i class="fa-solid fa-cart-shopping"></i>

            </div>

            <h3>
                <?php echo $totalpedido; ?>
            </h3>

            <p>
                Pedidos
            </p>

        </article>

        <article class="card">

            <a href="../favoritos/favoritos.php">

                <div class="icono">

                    <i class="fa-regular fa-heart"></i>

                </div>

                <p>
                    Favoritos
                </p>

            </a>

        </article>

        <article class="card">

            <a href="../pagina/revisar.php">

                <div class="icono">

                    <i class="fa-solid fa-star"></i>

                </div>

                <p>
                    Comentarios
                </p>

            </a>

        </article>

    </section>

    <section class="contenido">

        <section class="resumen">

            <h3 class="titulo-caja">
                MIS PEDIDOS
            </h3>

            <table class="tabla-pedidos">

                <tr>

                    <th>
                        Pedido
                    </th>

                    <th>
                        Fecha
                    </th>

                    <th>
                        Estado
                    </th>

                </tr>

                <?php if ($pedidos->num_rows > 0): ?>

                    <?php while ($pedido = $pedidos->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?php echo htmlspecialchars($pedido['id']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($pedido['fecha']); ?>
                            </td>

                            <td>
                                <?php echo htmlspecialchars($pedido['estado']); ?>
                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="3">
                            No tienes pedidos registrados
                        </td>

                    </tr>

                <?php endif; ?>

            </table>

        </section>

    </section>

</main>

<?php

$stmtLista->close();

$conexion->close();

?>

</body>

</html>
