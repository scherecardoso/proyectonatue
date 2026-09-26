<?php
session_start();
include("../includes/verificarbloqueo.php");
if ($_SESSION['rol'] != "administrador") {
  header("Location: ../usuario/09.register.php");
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


$sqlVentasSemana = "SELECT  DATE(p.fecha) AS dia,
        SUM(v.costo) AS total
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    WHERE p.fecha >= CURDATE() - INTERVAL 6 DAY
    GROUP BY DATE(p.fecha)
    ORDER BY dia ASC
";

$resultadoVentasSemana = $conn->query($sqlVentasSemana);

$diasVentas = [];
$totalesVentas = [];

if ($resultadoVentasSemana) {
    while ($fila = $resultadoVentasSemana->fetch_assoc()) {
        $diasVentas[] = date("d/m", strtotime($fila['dia']));
        $totalesVentas[] = (float)$fila['total'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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



.info {
    grid-area: info;
    display: grid;
    grid-template-areas:
        "bienvenida"
        "cards"
        "contenido";
    grid-template-rows: auto auto 1fr;
    gap: 20px;
    padding: 10px;
    margin-top: 25px;
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
    display: flex;
    gap: 10px;
    margin-top: 50px;
    margin-left: 175px;
}

.card {
    width: 205px;
    height: 225px;
    background-color: #ffffffe3;
    border-radius: 25px;
    display: flex;
    flex-direction: column; 
    align-items: center;
    justify-content: center;
    gap: 10px;
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
    display: flex;
    gap: 20px;
    margin-top: 2%;
    margin-left: 177px;
}

.resumen {
    grid-area: resumen;
    background: #ffffff;
    height: 450px;
    width: 530px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;  
    align-items: center;   
    justify-content: flex-start; 
    padding-top: 20px;
    color: #ff78b8;
    font-size: 28px;
}
.grafico-resumen {
    width: 90%;
    height: 350px;
    padding: 10px;
}
.pedidos {
    grid-area: pedidos;
    background: #ffffff;
    height: 450px;
    width: 530px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;
    display: flex;
    flex-direction: column;  
    align-items: center;   
    justify-content: flex-start; 
    padding-top: 20px;
    color: #ff78b8;
    font-size: 28px;
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
    margin-top: 30px;
    margin-left: 1270px;
    border-radius: 25%;
    position: absolute;
}

.acciones {
    background: #ffffff;
    width: 330px;
    height: 360px;
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
    width: 330px;
    height: 360px;
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
    width: 330px;
    height: 360px;
    border-radius: 35px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.05);
    border: 1px solid #efefef;

    display: flex;
    flex-direction: column;

    align-items: flex-start;
    justify-content: flex-start;

    padding: 25px;
}

.titulo-caja{
  color:#ff78b8;
  font-size:28px;
  margin-bottom:20px;
}


.tabla-pedidos{
  width:90%;
  margin:auto;
  border-collapse:collapse;
  font-size:16px;
  color:#555;
}

.tabla-pedidos th{
  text-align:left;
  padding:10px;
}

.tabla-pedidos td{
  padding:10px;
}


.lista-acciones{
  list-style:none;
  display:flex;
  flex-direction:column;
  gap:25px;
  padding:20px 35px;
  font-size:18px;
  color:#444;
}

.lista-acciones i{
  color:#ff78b8;
  margin-right:12px;
}



.lista-sistema{
  list-style:none;
  padding:20px 35px;
}

.lista-sistema li{
  display:flex;
  justify-content:space-between;
  margin-bottom:22px;
  font-size:18px;
  color:#444;
}



.lista-actividad{
  list-style:none;
  display:flex;
  flex-direction:column;
  gap:25px;
  padding:20px 35px;
  font-size:17px;
  color:#444;
}

.lista-actividad i{
  color:#ff78b8;
  margin-right:12px;
}

h2{
    font-size: 35px;
}

p{
    font-size: 20px;
}

div{
  color: black;
}

i{
    color:black;
}

.menu a{
    text-decoration: none;
    color: black;
}

@media (max-width: 768px) {

  body{
    grid-template-columns: 1fr;
    grid-template-rows: auto;
    grid-template-areas:
      "barra"
      "info";
  }

  .menu,
  .act {
    display: none;
  }


  .bienvenida {
    position: static;
    width: 90%;
    height: auto;
    margin: 20px auto;
  
    flex-direction: column;
    text-align: center;
    padding: 20px;
  }

  .circulo {
    width: 120px;
    height: 120px;
  }

  .cards {
    margin: 20px 0;
    flex-wrap: wrap;
    justify-content: center;
  }

  .card {
    width: 45%;
  }

  .contenido {
    position: static;
    margin: 20px 0;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .resumen,
  .pedidos {
    width: 100%;
    height: auto;
  }

}
</style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/includeadmin.php"); ?>

<main class="info">
    <seccion class="bienvenida">
      <div class="circulo"><img src="../img_perfil/<?php echo htmlspecialchars($imagenPerfil); ?>" alt="Foto de perfil"> </div>

    <div class="texto"><h2>¡BIENVENIDA, <?php echo $_SESSION['nombre'];?>! 🌸</h2>
    <p>Desde aquí puedes administrar y supervisar todas las operaciones del sistema</p>
  </div>
</seccion>


<section class="cards">
    <article class="card"><div class="icono"><i class="fa-solid fa-users"></i></div><h3><?php echo $totalUsuarios; ?></h3><p>Usuarios Registrados</p></article></a>
    <article class="card"><div class="icono"><i class="fa-solid fa-shield"></i></div><h3>2</h3><p>Roles Activos</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-box"></i></div><h3><?php echo $totalProductos; ?></h3><p>Productos Registrados</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-cart-shopping"></i></div><h3><?php echo $totalPedidos; ?></h3><p>Pedidos este mes</p></article>
    <article class="card"><div class="icono"><i class="fa-solid fa-dollar-sign"></i></div><h3></h3><p>Ventas este mes</p></article>
</section>


<section class="contenido">
  <section class="resumen">
    <h3 class="titulo-caja">RESUMEN DE VENTAS</h3>
    <div class="grafico-resumen">
      <canvas id="graficoResumenVentas"></canvas>
    </div>
  </section>

  <section class="pedidos">
    <h3 class="titulo-caja">PEDIDOS RECIENTES</h3>
    <table class="tabla-pedidos">
      <?php
      $pedidos = $conn->query("
      SELECT *
          FROM pedidos
          ORDER BY id DESC
          LIMIT 5
      ");

      while($pedido = $pedidos->fetch_assoc()){
      ?>
      <tr>
          <td><?php echo $pedido['nombre']; ?></td>
          <td><?php echo $pedido['fecha']; ?></td>
        
          <td><?php echo $pedido['vendedor']; ?></td>

        
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
  <section class="acciones"><h3 class="titulo-caja">ACCIONES RAPIDAS</h3>
  <ul class="lista-acciones">
    <li><a href="../admin/crearuser.php"><i class="fa-solid fa-user-plus"></i>Crear Usuario</li></a>
    <li><a href="../productos/16.formproductos.php"><i class="fa-solid fa-box"></i>Registrar Producto</li></a>
    <li><i class="fa-solid fa-chart-column"></i>Ver Reportes</li>
  </ul>
  </section>

  <section class="resumen-sistema">
    <h3 class="titulo-caja">RESUMEN DEL SISTEMA</h3>
    <ul class="lista-sistema">
    <li><span>Usuarios activos</span><strong>18</strong></li>
    <li><span>Productos activos</span><strong>156</strong></li>
    <li><span>Pedidos este mes</span><strong>128</strong></li>
    <li><span>Ventas este mes</span><strong>$3.850</strong></li></ul>
  </section>

 
  <section class="actividad">
    <h3 class="titulo-caja">ACTIVIDAD RECIENTE</h3>
    <ul class="lista-actividad">
      <li><i class="fa-solid fa-user"></i>Nuevo usuario creado</li>
      <li><i class="fa-solid fa-box"></i>Producto registrado</li>
      <li><i class="fa-solid fa-cart-shopping"></i>Pedido actualizado</li>
      <li><i class="fa-solid fa-chart-line"></i>Reporte generado</li>
    </ul>
  </section>
</aside>
</main>
<script>

const diasVentas = <?php echo json_encode($diasVentas); ?>;
const totalesVentas = <?php echo json_encode($totalesVentas); ?>;


const ctxResumen = document.getElementById('graficoResumenVentas');

new Chart(ctxResumen, {
    type: 'line',
    data: {
        labels: diasVentas,
        datasets: [{
            label: 'Ventas (Bs)',
            data: totalesVentas,
            borderColor: '#ff5ca8',
            backgroundColor: 'rgba(255,92,168,0.15)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

</script>
</body>
</html>
