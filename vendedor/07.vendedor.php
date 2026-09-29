<?php
session_start();


if ($_SESSION['rol'] != "vendedor") {
    echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Usuario bloqueado</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>

        <body>

        <script>
        Swal.fire({
            title: "Acceso denegado",
            text: "Verifica tus datos correctamente.",
            imageUrl: "../img/perrito-ojoso.jpg",
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: "Perrito",
            background: "#fff1f4",
            color: "#767c80",
            confirmButtonColor: "#5e6466",
            confirmButtonText: "Aceptar"
         }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../vendedor/07.vendedor.php"; 
            }
        });
        </script>

        </body>
        </html>
        ';
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
<title>Vendedor</title>
<style>
body {
  display: grid; 
  font-family: Arial, sans-serif;
  margin: 0;
  grid-template-areas:
    "barra barra"
    "menu-lateral contenido";
  grid-template-columns: 380px 1fr;
  grid-template-rows: 88px 1fr 70px;
  min-height: 100vh;
  gap: 5px;
}


.menu-lateral a:hover{
  background: #ffdcec;
  color: #ff5ca8;
  padding-left: 22px;
}

.contenedor{
    grid-area:contenido;
    width:99%;
    max-width:2100px;
    margin:40px auto;
    background:white;
    padding:8px;
  
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
  color: #8c8c8c;
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
    background:  #ffe4ec;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.icono i {
    color: #fa7ebc;
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
    color: #8c8c8c ;
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
    background: #ffe4ec ;
    color:#8c8c8c;
    text-align:left;
    padding:20px;
    font-size:18px;
}

.tabla-pedidos td{
    padding:25px 20px;
    font-size:18px;
    color: #8c8c8c;
    border-bottom: 1px solid #eeeeee;
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
  background-color: #f5b0c7;
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
  color: #f7a0bd;
  font-weight: bold;
}

.accionesPedido{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    flex-wrap:nowrap;

}

.btnVerPedido{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    padding:9px 13px;
    background:pink;
    color:white;
    text-decoration:none;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
    white-space:nowrap;
    transition:.3s ease;
}
.btnVerPedido:hover{
    background:pink;
    transform:translateY(-1px);
}

.formEstado{
    display:flex;
    align-items:center;
    gap:6px;
    margin:0;
}


.formEstado select{
    padding:8px 10px;
    border:1px solid #ddd;
    border-radius:8px;
    background:white;
    font-size:12px;
    color:#555;
    outline:none;
}


.btnActualizar{
    padding:8px 11px;
    border:none;
    border-radius:8px;
    background:#888;
    color:white;
    cursor:pointer;
    font-size:12px;
    white-space:nowrap;
    transition:.3s ease;
}

.btnActualizar:hover{
    background:#666;
}
/* ========== TABLET Y MENOR (menú pasa arriba) ========== */
@media (max-width: 1199px) {
  body {
    grid-template-areas:
      "barra"
      "menu-lateral"
      "contenido";
    grid-template-columns: 1fr;
    grid-template-rows: auto;
    gap: 0;
  }

  .contenedor {
    width: 100%;
    margin: 10px auto;
    padding: 12px;
    box-sizing: border-box;
    min-width: 0;           
  }

  .contenido {
    flex-direction: column;
  }

  .pedidos {
    padding: 20px;
    flex: none;
    width: 100%;
    box-sizing: border-box;
  }

  .acceso-rapido {
    width: 100%;
  }

  .contenedor-acciones {
    flex-wrap: wrap;
  }

  .accion {
    flex: 1 1 30%;
    border-radius: 25px;     
  }

  
  .tabla-pedidos {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .tabla-pedidos table {
    min-width: 650px;
  }
}


@media (max-width: 768px) {

  .bienvenida {
    height: auto;
    padding: 15px;
    border-radius: 25px;
  }

  .contenido-bienvenida {
    flex-direction: column;
    text-align: center;
  }

  .info-bienvenida {
    flex-direction: column;
    gap: 12px;
  }

  .icono-bienvenida {
    width: 70px;
    height: 70px;
    font-size: 35px;
  }

  .texto-bienvenida h1 {
    font-size: 22px;
  }

  .slider-bienvenida {
    display: none;          
  }

 
  .acciones {
    padding: 10px;
  }

  .acciones h1 {
    font-size: 24px;
  }

  .contenedor-acciones {
    flex-direction: column;
  }

  .accion {
    flex: none;
    width: 100%;
    box-sizing: border-box;
  }

  /* Pedidos */
  .pedidos {
    padding: 15px;
    border-radius: 20px;
  }

  .encabezado-pedidos h2 {
    font-size: 22px;
  }

  .tabla-pedidos th,
  .tabla-pedidos td {
    padding: 12px 10px;
    font-size: 14px;
  }

  .btnVerPedido,
  .btnActualizar {
    font-size: 12px;
    padding: 7px 10px;
  }

  .estado-entregado,
  .estado-pendiente {
    padding: 8px 14px;
    font-size: 13px;
  }
}


@media (max-width: 480px) {
  .texto-bienvenida h1 {
    font-size: 18px;
  }

  .accion a {
    font-size: 17px;
  }

  .tabla-pedidos table {
    min-width: 560px;
  }
}
</style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/includeVendedor.php"); ?>

<div class="contenedor">
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
    <a href="../productos/16.formproductos.php" style="color: #000000;">Registrar Productos</a>
    <p><center>Registra nuevos productos</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-box"></i></div>
    <a href="../productos/22.readproductos.php" style="color: #000000;">Ver Stock</a>
    <p><center>Consulta el stock disponible de productos</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-clipboard-list"></i></div>
    <a href="../pedidos/pedidosclientes.php" style="color: #000000;">Ver Pedidos</a>
    <p><center>Consulta los pedidos realizados por los clientes</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-arrows-rotate"></i></div>
    <a href="../ventas/readventas.php" style="color: #000000;">Historial de Ventas</a>
    <p><center>Consulta el historial de ventas realizadas</center></p>
  </section>
  <section class="accion">
    <div class="icono"><i class="fa-solid fa-chart-column"></i></div>
    <a href="../pedidos/pedidosclientes.php" style="color: #000000;">Estado de Pedidos </a>
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
   echo "<td class='accionesPedido'>";

echo "<a 
        href='../pedidos/detallepedido.php?id=" . $pedido['id'] . "' 
        class='btnVerPedido'>
        Ver pedido
        
      </a>";

if($pedido['estado'] == 'Pendiente'){

    echo "<form action='../pedidos/Actualizar_estado_pedido.php' method='post' class='formEstado'>";
    echo "<input type='hidden' name='pedido_id' value='" . $pedido['id'] . "'>";
    echo "<input type='hidden' name='estado' value='Aceptado'>";
    echo "<button type='submit' class='btnActualizar'>Aceptar</button>";
    echo "</form>";

    echo "<form action='../pedidos/Actualizar_estado_pedido.php' method='post' class='formEstado'>";
    echo "<input type='hidden' name='pedido_id' value='" . $pedido['id'] . "'>";
    echo "<input type='hidden' name='estado' value='Rechazado'>";
    echo "<button type='submit' class='btnActualizar'>Rechazar</button>";
    echo "</form>";

}

echo "</td>";
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
      <a href="">Ver Catálogo</a>
    </section>
  </section>
</section>
</main>
<?php include("../includes/footer.php"); ?>
</body>
</html>