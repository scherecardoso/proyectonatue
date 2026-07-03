<?php
session_start();

if ($_SESSION['rol'] != "vendedor") {
    echo "Acceso denegado";
    exit();
}
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
<title>Maquetado Vendedor</title>
<style>

body {
  display: grid; 
  font-family: Arial, sans-serif;
  margin: 0;
  grid-template-areas:
    "barra barra"
    "menu-lateral principal"
    "pie pie";
  grid-template-columns: 320px 1fr;
  grid-template-rows: 70px 1fr 70px;
  min-height: 100vh;
  gap: 5px;
}

.menu-lateral {
   grid-area: menu-lateral;
  display: flex;
  flex-direction: column;
  gap: 10px;
  background-color: #ffffff;
  padding: 15px;
  margin-top: 27px;
  width: 280px;
  border-right: 1px solid #ececec;
 
}
.menu-titulo {
  font-size: 15px;
  color: #ff5ca8;
  margin-bottom: 20px;
  text-transform: uppercase;
}
.menu-lateral a{
  text-decoration: none;
  color: black;
  padding: 15px;
  border-radius: 12px;
  font-size: 20px;
  transition: .3s;
  cursor: pointer;
  display: block;
}
.menu-lateral a:hover{
  background: #ffdcec;
  color: #ff5ca8;
  padding-left: 22px;
}


.principal {
  grid-area: principal;
  padding: 15px;
  display: flex;
  flex-direction: column;
  gap: 20px;
  margin-top: 80px;
}
.bienvenida {
  height: 140px;
  padding: 20px;
  background: #fdeff6;
  border-radius: 33px;
}
.contenido-bienvenida {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.info-bienvenida {
  display: flex;
  align-items: center;
  gap: 25px;
}
.icono-bienvenida {
  width: 90px;
  height: 90px;
  border: 3px solid pink;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 50px;
}
.texto-bienvenida {
  display: flex;
  flex-direction: column;
}
.imagen-bienvenida {
  width: 300px;
  height: 140px;
  margin-left: 20px;
}
.slider-bienvenida{
    position: relative;
    width: 300px;
    height: 140px;
}
.imagen-slide{
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    animation: cambiarImagen 9s infinite;
}
.imagen-slide:nth-child(1){
    animation-delay: 0s;
}
.imagen-slide:nth-child(2){
    animation-delay: 3s;
}
.acciones {
  padding: 20px;
  border-radius: 20%;
  color: #ff5ca8;
}
.contenedor-acciones {
  display: flex;
  gap: 15px;
  margin-top: 20px;
  color: black;

}
.accion {
  flex: 1;
  border-radius: 20%;
  padding: 15px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transition: 0.3s;
  color: black;
}
.accion:hover {
  transform: scale(1.05);
  box-shadow: 0 4px 8px rgba(212, 76, 76, 0.2);
}
.accion a {
  text-decoration: none;
  font-weight: bold;
  font-size: 20px;
  margin-top: 10px;
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
.contenido {
  display: flex;
  gap: 10px;
}
.pedidos{
    flex:2.3;
    background:white;
    border-radius:30px;
    padding:35px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

.encabezado-pedidos{
    background:none;
    height:auto;
    padding:0;
    margin-bottom:25px;
}

.encabezado-pedidos a{
    text-decoration:none;
}

.encabezado-pedidos h2{
    color:#ff4f94;
    font-size:28px;
    margin:0;
}

.tabla-pedidos{
    background:none;
    height:auto;
    padding:0;
}

.tabla-pedidos table{
    width:100%;
    border-collapse:collapse;
}

.tabla-pedidos th{
    background:#f8e8ee;
    color:#ff4f94;
    text-align:left;
    padding:20px;
    font-size:18px;
}

.tabla-pedidos td{
    padding:25px 20px;
    font-size:18px;
    color:#222;
    border-bottom:1px solid #eeeeee;
}

.tabla-pedidos tr:last-child td{
    border-bottom:none;
}
.estado-entregado{
    background:#d8f0dc;
    color:#159957;
    padding:12px 20px;
    border-radius:25px;
    font-weight:bold;
    display:inline-block;
}

.estado-pendiente{
    background:#f6dce7;
    color:#ff4f94;
    padding:12px 20px;
    border-radius:25px;
    font-weight:bold;
    display:inline-block;
}
.acceso-rapido {
  flex: 1;
}
.encabezado-acceso {
  height: 60px;
  background-color: #ff5c93;
  color: white;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.boton-acceso {
  height: 70px;
  background-color: #ffe4ec;
  border-radius: 15px;
  margin-top: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.3s;
}
.boton-acceso:hover {
  background-color: pink;
}
.boton-acceso a {
  text-decoration: none;
  color: #d87093;
  font-weight: bold;
}

@keyframes cambiarImagen{
    0%{
        opacity: 0;
    }
    10%{
        opacity: 1;
    }
    45%{
        opacity: 1;
    }
    55%{
        opacity: 0;
    }
    100%{
        opacity: 0;
    }
}
@media (max-width: 768px) {
  body {
    grid-template-areas:
      "barra"
      "menu-lateral"
      "principal"
      "pie";
    grid-template-columns: 1fr;
    grid-template-rows: auto;
  }
  
  .menu-lateral {
   display: none;
  }
  .principal {
    margin-top: 0;
    padding: 12px;
    gap: 30px;
  }
  .bienvenida {
    height: auto;
    padding: 25px 15px;
    border-radius: 25px;
  }
  .contenido-bienvenida {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 20px;
  }
  .info-bienvenida {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
  }
  .texto-bienvenida h1 {
    margin: 0;
    font-size: 28px;
  }
  .texto-bienvenida p {
    font-size: 18px;
    line-height: 1.5;
    margin: 10px 0 0 0;
  }
  .imagen-bienvenida {
    width: 100%;
    max-width: 220px;
    height: auto;
    margin: 0;
    object-fit: contain;
  }
  .acciones {
    padding: 10px;
  }
  .acciones h1 {
    text-align: center;
    font-size: 40px;
    margin-bottom: 20px;
  }
  .contenedor-acciones {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .accion {
    width: 100%;
    box-sizing: border-box;
    background: white;
    border-radius: 20px;
    padding: 20px;
  }
  .accion a {
    text-align: center;
    font-size: 26px;
  }
  .accion p {
    text-align: center;
    font-size: 18px;
    margin-top: 10px;
  }
  .contenido {
    flex-direction: column;
  }
  .pedidos{
    width:100%;
    padding:20px;
    border-radius:20px;
}

.encabezado-pedidos{
    margin-bottom:20px;
}

.encabezado-pedidos h2{
    font-size:24px;
    text-align:center;
}

.tabla-pedidos{
    overflow-x:auto;
    padding:0;
}

.tabla-pedidos table{
    min-width:600px;
}

.tabla-pedidos th{
    padding:15px;
    font-size:16px;
}

.tabla-pedidos td{
    padding:18px 15px;
    font-size:15px;
}

.estado-entregado,
.estado-pendiente{
    padding:10px 15px;
    font-size:13px;
}
  .acceso-rapido {
    width: 100%;
  }
  .slider-bienvenida{
    width: 220px;
    height: 180px;
}
}
</style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<aside class="menu-lateral">
  <a class="menu-titulo"><h2>Menu Vendedor</h2></a>
  <a href=""><i class="fa-solid fa-house"></i> Registrar Ventas</a>
  <a href=""><i class="fa-solid fa-box"></i> Stock de Productos</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-truck"></i> Pedidos de Clientes</a>
  <a href=""><i class="fa-solid fa-history"></i> Historial de Ventas</a>
  <a href=""><i class="fa-solid fa-info-circle"></i> Estado de Pedidos</a>
  <a href=""><i class="fa-solid fa-user"></i> Mi perfil</a>
  <a href="../auth/26.cerrarsesion.php">Cerrar Sesión</a>
</aside>
<main class="principal">
    <section class="bienvenida">
    <section class="contenido-bienvenida">
      <section class="info-bienvenida">
        <section class="icono-bienvenida">
          <i class="fa-solid fa-user"></i>
        </section>
        <section class="texto-bienvenida">
          <h1>Bienvenido/a <?php echo $_SESSION['nombre'];?></h1>
          <p>
           Haz que cada día sea una oportunidad para brillar.
          </p>
        </section>
      </section>
      <section class="slider-bienvenida">
   <img src="../img/zbanner.png" class="imagen-slide active">
   <img src="../img/nos.png" class="imagen-slide">
</section>
    </section>
 </section>
  <section class="acciones">
    <h1>Acciones Rapidas</h1>
    <section class="contenedor-acciones">
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-cart-shopping"></i></div>
    <a href="../pedidos/1.formpedidos.php" style="color: #000000;">Registrar Venta</a>
    <p><center>Registra nuevas ventas de productos</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-box"></i></div>
    <a href="" style="color: #000000;">Ver Stock</a>
    <p><center>Consulta el stock disponible de productos</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-clipboard-list"></i></div>
    <a href="" style="color: #000000;">Ver Pedidos</a>
    <p><center>Consulta los pedidos realizados por los clientes</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-arrows-rotate"></i></div>
    <a href="" style="color: #000000;">Historial de Ventas</a>
    <p><center>Consulta el historial de ventas realizadas</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-chart-column"></i></div>
    <a href="" style="color: #000000;">Estado de Pedidos </a>
    <p><center>Consulta el estado de los pedidos</center></p>
  </section>
</section>
  </section>
</section>
<section class="contenido">
  <section class="pedidos">
    <section class="encabezado-pedidos">
      <a href="#ultimos-pedidos">
        <h2>Últimos Pedidos</h2>
      </a>
    </section>
    <section class="tabla-pedidos" id="ultimos-pedidos">
      <table width="100%">
        <tr>
          <th>Código</th>
          <th>Cliente</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>

<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM pedidos ORDER BY id DESC LIMIT 5";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($pedido = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>#CODI" . $pedido['id'] . "</td>";
        echo "<td>" . $pedido['nombre'] . "</td>";
        echo "<td>" . $pedido['fecha'] . "</td>";
        echo "<td>" . $pedido['estado'] . "</td>";
        echo "<td>";
        echo "<form action='../pedidos/actualizar_estado_pedido.php' method='post' style='display:inline;'>";
        echo "<input type='hidden' name='pedido_id' value='" . $pedido['id'] . "'>";
        echo "<select name='estado'>";
        echo "<option value='En Proceso'>En Proceso</option>";
        echo "<option value='Aceptado'>Aceptado</option>";
        echo "<option value='Rechazado'>Rechazado</option>";
        echo "</select>";
        echo "<button type='submit'>Actualizar</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No hay pedidos</td></tr>";
}

$conn->close();

?>
      </table>
</section>
  </section>
  <section class="acceso-rapido">
    <section class="encabezado-acceso">
      <h2>Acceso Rápido</h2>
    </section>
    <section class="boton-acceso">
      <a href="../pedidos/1.formpedidos.php">Nuevo Pedido</a>
    </section>
    <section class="boton-acceso">
      <a href="">Ver Catálogo</a>
    </section>
  </section>
</section>
</main>
<?php include("../includes/footer.php"); ?>
</body>
</html>