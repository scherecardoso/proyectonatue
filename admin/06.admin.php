<?php
session_start();
include("../includes/verificarbloqueo.php");
if ($_SESSION['rol'] != "administrador") {
  header("Location: ../usuario/09.register.php");
  exit;
}
 
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}
$nombre_usuario = $_SESSION['nombre'];

$sqlPerfil = "SELECT imagen_perfil FROM usuario WHERE nombre=?";
$stmtPerfil = $conn->prepare($sqlPerfil);
$stmtPerfil->bind_param("s", $nombre_usuario);
$stmtPerfil->execute();
$resultadoPerfil = $stmtPerfil->get_result();
$perfil = $resultadoPerfil->fetch_assoc();
$stmtPerfil->close();

$imagenPerfil = !empty($perfil['imagen_perfil']) 
    ? $perfil['imagen_perfil'] 
    : 'imgperfil.avif';

$totalUsuarios = $conn->query(
    "SELECT COUNT(*) AS total FROM usuario"
)->fetch_assoc()['total'];

$totalProductos = $conn->query(
    "SELECT COUNT(*) AS total FROM productos"
)->fetch_assoc()['total'];


$totalPedidos = $conn->query(
    "SELECT COUNT(*) AS total FROM pedidos"
)->fetch_assoc()['total'];

$totalVentasMes = $conn->query(
    "SELECT COUNT(*) AS total
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    WHERE MONTH(p.fecha) = MONTH(CURDATE())
    AND YEAR(p.fecha) = YEAR(CURDATE())
    AND v.estado = 'Entregado'
")->fetch_assoc()['total'];
$totalUsuariosActivos = $conn->query(
    "SELECT COUNT(*) AS total
    FROM usuario
    WHERE estado = 'Activo'
")->fetch_assoc()['total'];

$totalProductosActivos = $conn->query(
    "SELECT COUNT(*) AS total
    FROM productos
    WHERE estado = 'Activo'
")->fetch_assoc()['total'];

$totalPedidosMes = $conn->query(
    "SELECT COUNT(*) AS total
    FROM pedidos
    WHERE MONTH(fecha) = MONTH(CURDATE())
    AND YEAR(fecha) = YEAR(CURDATE())
")->fetch_assoc()['total'];

$totalIngresosMes = $conn->query(
    "SELECT COALESCE(SUM(v.costo), 0) AS total
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    WHERE MONTH(p.fecha) = MONTH(CURDATE())
    AND YEAR(p.fecha) = YEAR(CURDATE())
    AND v.estado = 'Entregado'
")->fetch_assoc()['total'];


$ventasGrafico = [];
$ingresosGrafico = [];

$sqlGrafico = "SELECT v.id, v.costo
               FROM ventas v
               INNER JOIN pedidos p ON v.pedidos_id = p.id
               WHERE p.fecha BETWEEN '2026-09-13' AND '2026-09-19'
               AND v.estado = 'Entregado'
               ORDER BY v.id ASC";

$resultadoGrafico = $conn->query($sqlGrafico);

if (!$resultadoGrafico) {
    die("Error en gráfico: " . $conn->error);
}

while ($fila = $resultadoGrafico->fetch_assoc()) {
    $ventasGrafico[] = "Venta " . $fila['id'];
    $ingresosGrafico[] = (float)$fila['costo'];
}

$totalRoles = $conn->query(
    "SELECT COUNT(DISTINCT rol) AS total FROM usuario"
)->fetch_assoc()['total'];

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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>


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
    display: grid;
    grid-template-columns: 330px minmax(0, 1fr);
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "barra barra"
        "menu  info";
    gap: 0;
}

h2 { font-size: 35px; }
p  { font-size: 20px; }
div { color: black; }
i   { color: black; }



.info {
    grid-area: info;
    min-width: 0;
    box-sizing: border-box;
    padding: 25px;

    display: grid;
    grid-template-columns: minmax(0, 1fr);
    grid-template-areas:
        "bienvenida"
        "cards"
        "contenido"
        "act";
    gap: 25px;
    align-content: start;
}


@media (min-width: 1400px) {
    .info {
        grid-template-columns: minmax(0, 1fr) 350px;
        grid-template-areas:
            "bienvenida act"
            "cards      act"
            "contenido  act";
    }
}


.bienvenida {
    grid-area: bienvenida;
    width: 100%;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 25px;
    padding: 20px 40px;
    background: #fdeff6;
    font-size: 30px;
    font-family: 'Playfair Display', serif;
    color: #272020;
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
    width: clamp(105px, 14vw, 170px);
    height: clamp(105px, 14vw, 170px);
    flex-shrink: 0;
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


.cards {
    grid-area: cards;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 14px;
}

.card {
    box-sizing: border-box;
    min-height: 190px;
    padding: 15px 10px;
    background-color: #ffffffe3;
    border-radius: 25px;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-align: center;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
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
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 380px), 1fr));
    gap: 20px;
}

.resumen,
.pedidos {
    min-width: 0;
    box-sizing: border-box;
    min-height: 450px;
    background: #ffffff;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
    padding: 20px 15px;
    color: #ff78b8;
    font-size: 28px;
}

.grafico-resumen {
    width: 100%;
    height: 350px;
    padding: 5px;
    box-sizing: border-box;
    position: relative;
}

.pedidos {
    overflow-x: auto;
    align-items: flex-start;
}

.titulo-caja {
    color: #ff78b8;
    font-size: 28px;
    margin: 0 0 20px;
}

.resumen .titulo-caja,
.pedidos .titulo-caja {
    align-self: center;
    text-align: center;
}

.tabla-pedidos {
    width: 100%;
    min-width: 500px;
    border-collapse: collapse;
    font-size: 16px;
    color: #555;
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

.estado-aceptado  { background-color: #dff3e4; color: #4f8a5b; }
.estado-rechazado { background-color: #f8dddd; color: #b85c5c; }
.estado-pendiente { background-color: #fff1d6; color: #a67c35; }



.act {
    grid-area: act;
    min-width: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
    gap: 20px;
    align-content: start;
}

.acciones,
.resumen-sistema {
    box-sizing: border-box;
    min-height: 300px;
    background: #ffffff;
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
    margin: 0;
    padding: 10px 10px;
    font-size: 18px;
    color: #444;
}

.lista-acciones a {
    color: inherit;
    text-decoration: none;
}

.lista-acciones i {
    color: #ff78b8;
    margin-right: 12px;
}

.lista-sistema {
    list-style: none;
    width: 100%;
    margin: 0;
    padding: 10px 10px;
    box-sizing: border-box;
}

.lista-sistema li {
    display: flex;
    justify-content: space-between;
    margin-bottom: 22px;
    font-size: 18px;
    color: #444;
    gap: 30px;
}


@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto auto 1fr;
        grid-template-areas:
            "barra"
            "menu"
            "info";
    }

    .info {
        padding: 20px 15px;
    }
}


@media (max-width: 768px) {

    .info {
        gap: 22px;
        padding: 18px 15px;
    }

    .bienvenida {
        min-height: 230px;
        padding: 25px 20px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        gap: 15px;
    }

    .bienvenida h2 {
        font-size: 27px;
        margin: 0 0 8px;
    }

    .bienvenida p {
        font-size: 15px;
        line-height: 1.5;
        margin: 0;
    }

    .cards {
        gap: 12px;
    }

    .card {
        min-height: 170px;
        border-radius: 22px;
        gap: 8px;
    }

    .icono {
        width: 45px;
        height: 45px;
    }

    .icono i {
        font-size: 23px;
    }

    .card h3 {
        font-size: 25px;
    }

    .card p {
        font-size: 12px;
    }

    .resumen,
    .pedidos {
        min-height: 350px;
        border-radius: 25px;
        padding: 20px 10px;
    }

    .titulo-caja {
        font-size: 22px;
        margin: 5px 0 15px;
    }

    .grafico-resumen {
        height: 280px;
    }

    .tabla-pedidos {
        font-size: 13px;
    }

    .tabla-pedidos th,
    .tabla-pedidos td {
        padding: 8px;
    }

    .estado {
        padding: 5px 10px;
        font-size: 12px;
        min-width: 65px;
    }

    .acciones,
    .resumen-sistema {
        border-radius: 25px;
        padding: 20px;
        min-height: 0;
    }

    .lista-acciones,
    .lista-sistema li {
        font-size: 16px;
    }
}
</style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/includeadmin.php"); ?>

<main class="info">
  <section class="bienvenida">
    <div class="circulo"><img src="../img_perfil/<?php echo htmlspecialchars($imagenPerfil); ?>" alt="Foto de perfil"></div>

    <div class="texto">
      <h2>¡BIENVENIDA, <?php echo htmlspecialchars($_SESSION['nombre']); ?>! 🌸</h2>
      <p>Desde aquí puedes administrar y supervisar todas las operaciones del sistema</p>
    </div>
  </section>


  <section class="cards">
    <article class="card">
      <div class="icono"><i class="fa-solid fa-users"></i></div>
      <h3><?php echo $totalUsuarios; ?></h3>
      <p>Usuarios Registrados</p>
    </article>

    <article class="card">
      <div class="icono"><i class="fa-solid fa-shield"></i></div>
      <h3><?php echo $totalRoles; ?></h3>
      <p>Roles Activos</p>
    </article>

    <article class="card">
      <div class="icono"><i class="fa-solid fa-box"></i></div>
      <h3><?php echo $totalProductos; ?></h3>
      <p>Productos Registrados</p>
    </article>

    <article class="card">
      <div class="icono"><i class="fa-solid fa-cart-shopping"></i></div>
      <h3><?php echo $totalPedidos; ?></h3>
      <p>Pedidos este mes</p>
    </article>

    <article class="card">
      <div class="icono"><i class="fa-solid fa-dollar-sign"></i></div>
      <h3><?php echo $totalVentasMes; ?></h3>
      <p>Ventas este mes</p>
    </article>
  </section>


  <section class="contenido">
    <section class="resumen">
      <h3 class="titulo-caja">VENTAS DE LA SEMANA</h3>

      <div class="grafico-resumen">
        <canvas id="graficoResumenVentas"></canvas>
      </div>
    </section>

    <section class="pedidos">
      <h3 class="titulo-caja">PEDIDOS RECIENTES</h3>
      <table class="tabla-pedidos">
        <?php
        $pedidos = $conn->query(
          "SELECT *
            FROM pedidos
            ORDER BY id DESC
            LIMIT 5
        ");

        while($pedido = $pedidos->fetch_assoc()){
        ?>
        <tr>
          <td><?php echo htmlspecialchars($pedido['nombre']); ?></td>
          <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
          <td><?php echo htmlspecialchars($pedido['vendedor']); ?></td>
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
        <?php
        }
        ?>
      </table>
    </section>
  </section>


  <aside class="act">
    <section class="acciones">
      <h3 class="titulo-caja">ACCIONES RAPIDAS</h3>
      <ul class="lista-acciones">
        <li><a href="../admin/crearuser.php"><i class="fa-solid fa-user-plus"></i>Crear Usuario</a></li>
        <li><a href="../productos/16.formproductos.php"><i class="fa-solid fa-box"></i>Registrar Producto</a></li>
        <li><a href="../reportes/graficoingresos.php"><i class="fa-solid fa-chart-column"></i>Ver Reportes de Ingresos</a></li>
      </ul>
    </section>

    <section class="resumen-sistema">
      <h3 class="titulo-caja">RESUMEN DEL SISTEMA</h3>
      <ul class="lista-sistema">
        <li>
          <span>Usuarios activos</span>
          <strong><?php echo $totalUsuariosActivos; ?></strong>
        </li>

        <li>
          <span>Productos activos</span>
          <strong><?php echo $totalProductosActivos; ?></strong>
        </li>

        <li>
          <span>Pedidos este mes</span>
          <strong><?php echo $totalPedidosMes; ?></strong>
        </li>

        <li>
          <span>Ventas este mes</span>
          <strong><?php echo number_format($totalIngresosMes, 2); ?></strong>
        </li>
      </ul>
    </section>
  </aside>
</main>

<script>
const ventas = <?php echo json_encode($ventasGrafico); ?>;
const ingresos = <?php echo json_encode($ingresosGrafico); ?>;

const contexto = document.getElementById("graficoResumenVentas");

new Chart(contexto, {
    type: "line",
    data: {
        labels: ventas,
        datasets: [{
            label: "Ventas (Bs)",
            data: ingresos,
            borderColor: "#ff5ca8",
            backgroundColor: "rgba(255,92,168,0.15)",
            borderWidth: 2,
            pointBackgroundColor: "#ff5ca8",
            pointBorderColor: "#ffffff",
            pointBorderWidth: 1,
            pointRadius: 3,
            pointHoverRadius: 5,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return " Bs " + context.parsed.y.toFixed(2);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: "rgba(0,0,0,0.06)"
                },
                ticks: {
                    font: {
                        size: 10
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: 10
                    }
                }
            }
        }
    }
});
</script>
</body>
</html>