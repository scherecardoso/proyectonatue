<?php

session_start();
include("../includes/verificarbloqueo.php");

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


$sqlFavoritos = "
    SELECT productos.codigo, productos.nombre, productos.precio, productos.imagen
    FROM favoritos
    INNER JOIN productos ON favoritos.codigo = productos.codigo
    WHERE favoritos.ci = ?
";
$stmtFavoritos = $conexion->prepare($sqlFavoritos);
$stmtFavoritos->bind_param("s", $_SESSION['CI']);
$stmtFavoritos->execute();
$favoritos = $stmtFavoritos->get_result();


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


$sqlPedidosMes = "
    SELECT MONTH(fecha) AS mes, COUNT(*) AS cantidad
    FROM pedidos
    WHERE nombre = ?
    GROUP BY MONTH(fecha)
    ORDER BY mes
";
$stmtPedidosMes = $conexion->prepare($sqlPedidosMes);
$stmtPedidosMes->bind_param("s", $nombre_usuario);
$stmtPedidosMes->execute();
$resultadoPedidosMes = $stmtPedidosMes->get_result();

$pedidosMes = [];
while ($fila = $resultadoPedidosMes->fetch_assoc()) {
    $pedidosMes[] = $fila;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    position: relative;
    z-index: 1;
    border-radius: 38px 48px 35px 45px / 35px 30px 42px 38px;
    box-sizing: border-box;
}

.bienvenida::before {
    content: "";
    position: absolute;
    top: -7px;
    right: -9px;
    bottom: -6px;
    left: -8px;
    border: 3.5px solid #ff9cca;
    border-radius: 45px 55px 42px 50px / 48px 38px 52px 43px;
    transform: rotate(-0.7deg);
    pointer-events: none;
    z-index: -1;
}

.bienvenida::after {
    content: "";
    position: absolute;
    top: -3px;
    right: -4px;
    bottom: -4px;
    left: -3px;
    border: 1px solid rgba(255, 255, 255, 0.9);
    border-radius: 35px 50px 38px 48px / 40px 34px 48px 37px;
    transform: rotate(0.4deg);
    pointer-events: none;
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
    transform: translateX(-60px);
    
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
    border: 3px solid #efefef;
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

.icono i {
    color: #ff5ca8;
    font-size: 30px;
}

.card h3 {
    margin: 0;
    font-size: 29px;
    color: #000;
    font-family: 'Playfair Display', serif;
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
    border: 3px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 20px;
    color: #ff5ca8;
    font-size: 28px;
    overflow-x: auto;
    transform: translateX(-80px);
    box-sizing: border-box;
}

.grafico-panel h3,
.favoritos-panel h3,
.titulo-caja {
    margin: 0 0 20px 0;
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 600;
    color: #ff5ca8;
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

.estado {
    display: inline-block;
    padding: 7px 15px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    min-width: 80px;
}

.estado-aceptado {
    background-color: #dff3e4;
    color: #4f8a5b;
}

.estado-rechazado {
    background-color: #f8dddd;
    color: #b85c5c;
}

.estado-pendiente {
    background-color: #fff1d6;
    color: #a67c35;
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
    height: 65%;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    border-radius: 25px;
    box-sizing: border-box;
    background-color: #ffffffe3;
}

.grafico-panel {
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    overflow: hidden;
}

.grafico-contenedor {
    width: 100%;
    height: 230px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.favoritos-panel {
    padding: 20px;
    overflow: hidden;
    position: relative;
}

.carrusel {
    width: 100%;
    height: calc(100% - 45px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.favorito {
    display: none;
    width: 200%;
    height: 100%;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.favorito.activo {
    display: flex;
}

.favorito img {
    width: 70%;
    object-fit: cover;
    border-radius: 18px;
    display: block;
}

.favorito-nombre {
    margin: 10px 0 3px;
    font-size: 17px;
    color: #333;
    text-align: center;
    font-family: 'Playfair Display', serif;
}

.favorito-precio {
    margin: 0;
    font-size: 15px;
    color: #777;
}

.flecha {
    position: absolute;
    top: 43%;
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 50%;
    background: #faacd1;
    color: #ff5ca8;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 2;
}

.flecha:hover {
    background: #ff5ca8;
    color: white;
}

.flecha-izquierda {
    left: 2px;
}

.flecha-derecha {
    right: 2px;
}

.puntos {
    display: flex;
    justify-content: center;
    gap: 5px;
    margin-top: 8px;
}

.punto {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #ddd;
}

.punto.activo {
    background: #ff78b8;
}

.sin-favoritos {
    text-align: center;
    color: #888;
    font-size: 14px;
    margin-top: 50px;
}

.acciones,
.resumen-sistema,
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
    box-sizing: border-box;
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
    color: #ff5ca8;
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
    color: #ff5ca8;
    margin-right: 12px;
}

.menu a {
    text-decoration: none;
    color: black;
}



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
        transform: none;
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
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin: 0;
    }

    .resumen {
        transform: none;
        width: 100%;
        min-height: 250px;
        padding: 15px;
        border-radius: 25px;
        overflow-x: auto;
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

    <div class="cuadrado-vertical favoritos-panel">
        <h3>Mis favoritos</h3>

        <?php if ($favoritos->num_rows > 0): ?>
            <div class="carrusel">
                <?php
                $cantidadFavoritos = $favoritos->num_rows;
                $numeroFavorito = 0;
                ?>

                <?php while ($favorito = $favoritos->fetch_assoc()): ?>
                    <div class="favorito <?php echo $numeroFavorito == 0 ? 'activo' : ''; ?>">
                        <img
                            src="../img/<?php echo htmlspecialchars($favorito['imagen']); ?>"
                            alt="<?php echo htmlspecialchars($favorito['nombre']); ?>"
                        >
                        <p class="favorito-nombre"><?php echo htmlspecialchars($favorito['nombre']); ?></p>
                        <p class="favorito-precio"><?php echo htmlspecialchars($favorito['precio']); ?> Bs</p>
                    </div>
                    <?php $numeroFavorito++; ?>
                <?php endwhile; ?>

                <?php if ($cantidadFavoritos > 1): ?>
                    <button type="button" class="flecha flecha-izquierda" onclick="cambiarFavorito(-1)">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" class="flecha flecha-derecha" onclick="cambiarFavorito(1)">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                <?php endif; ?>
            </div>

            <?php if ($cantidadFavoritos > 1): ?>
                <div class="puntos">
                    <?php for ($i = 0; $i < $cantidadFavoritos; $i++): ?>
                        <span class="punto <?php echo $i == 0 ? 'activo' : ''; ?>"></span>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <p class="sin-favoritos">Todavía no tienes favoritos.</p>
        <?php endif; ?>
    </div>

    <div class="cuadrado-vertical grafico-panel">
        <h3>Pedidos por mes</h3>

        <?php if (count($pedidosMes) > 0): ?>
            <div class="grafico-contenedor">
                <canvas id="graficoPedidos"></canvas>
            </div>
        <?php else: ?>
            <p class="sin-favoritos">Todavía no tienes pedidos.</p>
        <?php endif; ?>
    </div>

</aside>


<main class="info">

    <section class="bienvenida">
        <div class="circulo">
            <img src="../img_perfil/<?php echo htmlspecialchars($imagenPerfil); ?>" alt="Foto de perfil">
        </div>

        <div class="texto">
            <h2>¡Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>! </h2>
            <p>Este es tu espacio. Revisa tus pedidos, guarda tus favoritos y disfruta de tu experiencia en Natué.</p>
        </div>
    </section>


    <section class="cards">
        <article class="card">
            <div class="icono">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h3><?php echo $totalpedido; ?></h3>
            <p>Pedidos</p>
        </article>

        <article class="card">
            <a href="../favoritos/favoritos.php">
                <div class="icono">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <p>Favoritos</p>
            </a>
        </article>

        <article class="card">
            <a href="../pagina/revisar.php">
                <div class="icono">
                    <i class="fa-solid fa-star"></i>
                </div>
                <p>Comentarios</p>
            </a>
        </article>
    </section>

    <section class="contenido">
        <section class="resumen">
            <h3 class="titulo-caja">MIS PEDIDOS</h3>

            <table class="tabla-pedidos">
                <tr>
                    <th>Pedido</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>

                <?php if ($pedidos->num_rows > 0): ?>
                    <?php while ($pedido = $pedidos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                            <td>
                                <?php
                                $estado = strtolower(trim($pedido['estado']));

                                if ($estado === 'aceptado') {
                                    $claseEstado = 'estado-aceptado';
                                } elseif ($estado === 'rechazado') {
                                    $claseEstado = 'estado-rechazado';
                                } else {
                                    $claseEstado = 'estado-pendiente';
                                }
                                ?>
                                <span class="estado <?php echo $claseEstado; ?>">
                                    <?php echo htmlspecialchars($pedido['estado']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No tienes pedidos registrados</td>
                    </tr>
                <?php endif; ?>
            </table>
        </section>
    </section>

</main>

<script>

let favoritoActual = 0;
const favoritos = document.querySelectorAll(".favorito");
const puntos = document.querySelectorAll(".punto");

function mostrarFavorito(numero) {
    if (favoritos.length === 0) return;

    if (numero >= favoritos.length) {
        favoritoActual = 0;
    } else if (numero < 0) {
        favoritoActual = favoritos.length - 1;
    } else {
        favoritoActual = numero;
    }

    favoritos.forEach(function (favorito, indice) {
        favorito.classList.remove("activo");
        if (indice === favoritoActual) favorito.classList.add("activo");
    });

    puntos.forEach(function (punto, indice) {
        punto.classList.remove("activo");
        if (indice === favoritoActual) punto.classList.add("activo");
    });
}

function cambiarFavorito(direccion) {
    mostrarFavorito(favoritoActual + direccion);
}


const datosPedidos = <?php echo json_encode($pedidosMes); ?>;

const nombresMeses = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];

const etiquetasMeses = datosPedidos.map(function (pedido) {
    return nombresMeses[pedido.mes - 1];
});

const cantidadesPedidos = datosPedidos.map(function (pedido) {
    return pedido.cantidad;
});

if (datosPedidos.length > 0) {
    const grafico = document.getElementById("graficoPedidos");

    new Chart(grafico, {
        type: "pie",
        data: {
            labels: etiquetasMeses,
            datasets: [{
                data: cantidadesPedidos,
                backgroundColor: [
                    "#f877b3", "#facce1", "#f974b2", "#ff5ca8",
                    "#ff5ca8", "#ff5ca8", "#ff5ca8", "#f87eb7",
                    "#fcbad9", "#ff5ca8", "#ff5ca8", "#ff5ca8"
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "bottom"
                }
            }
        }
    });
}
</script>

<?php
$stmtFavoritos->close();
$stmtLista->close();
$stmtPedidosMes->close();
$conexion->close();
?>

</body>
</html>