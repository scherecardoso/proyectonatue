<?php
session_start();

if ($_SESSION['rol'] != "vendedor") {
    die("Acceso denegado");
}
$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
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
    "menu-lateral contenedor"
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





.contenedor{
    max-width:none;
    margin:auto;
    background:white;
    padding:30px;
    border-radius:15px;
    width: 95%;
    height:105%;
    box-shadow:0 0 20px rgba(0,0,0,.1);
}


.encabezado-pedidos h2{
    color:#ff4f94;
    font-size:28px;
    margin:0;
}
table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#f4dbe5;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:hover{
    background:#faf2f6;
}

select{
    padding:5px;
}

button{
    padding:8px 12px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    background:#d88aa7;
    color:white;
}

button:hover{
    background:#c06d8c;
}

.barra-superior{
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}


.barra-superior h2{
    margin: 0;
    flex: 1;
    text-align: center;
}
</style>
</head>

<body>
<?php include("../includes/header.php"); ?>
<aside class="menu-lateral">
  <a class="menu-titulo"><h2>Menu Vendedor</h2></a>
  <a href="../vendedor/07.vendedor.php"><i class="fa-solid fa-house"></i> Registrar Ventas</a>
  <a href=""><i class="fa-solid fa-box"></i> Stock de Productos</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-truck"></i> Pedidos de Clientes</a>
  <a href=""><i class="fa-solid fa-history"></i> Historial de Ventas</a>
  <a href=""><i class="fa-solid fa-info-circle"></i> Estado de Pedidos</a>
  <a href=""><i class="fa-solid fa-user"></i> Mi perfil</a>
  <a href="../auth/26.cerrarsesion.php">Cerrar Sesión</a>
</aside>


<div class="contenedor">
<div class="barra-superior">

    <h2>Pedidos de Clientes</h2>
</div>

<table>

<tr>
    <th>ID Pedido</th>
    <th>Cliente</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Productos</th>
    <th>Acción</th>
</tr>

<?php

$sqlPedidos = "SELECT * FROM pedidos ORDER BY id DESC";
$resultadoPedidos = $conn->query($sqlPedidos);

while ($pedido = $resultadoPedidos->fetch_assoc()) {

    $idPedido = $pedido['id'];

    $sqlProductos = "SELECT productos.nombre, carrito.cantidad
                     FROM carrito
                     INNER JOIN productos
                     ON carrito.productos_codigo = productos.codigo
                     WHERE carrito.pedidos_id = '$idPedido'";

    $resultadoProductos = $conn->query($sqlProductos);

    $productos = "";

    while ($prod = $resultadoProductos->fetch_assoc()) {
        $productos .= $prod['nombre'] . " (" . $prod['cantidad'] . ")<br>";
    }

?>

<tr>
    <td><?php echo $pedido['id']; ?></td>
    <td><?php echo $pedido['nombre']; ?></td>
    <td><?php echo $pedido['fecha']; ?></td>
    <td><?php echo $pedido['estado']; ?></td>
    <td><?php echo $productos; ?></td>

    <td>
        <form action="actualizar_estado_pedido.php" method="POST">
            <input type="hidden" name="pedido_id"
                   value="<?php echo $pedido['id']; ?>">

            <select name="estado">
                <option value="En Proceso">En Proceso</option>
                <option value="Aceptado">Aceptado</option>
                <option value="Rechazado">Rechazado</option>
            </select>

            <button type="submit">Actualizar</button>

    </form>
</td>
</tr>

<?php
}
?>
</td>
</tr>
    <td colspan="6">No existen pedidos registrados.</td>
</table>
</div>
</body>
</html>
<?php
$conn->close();
?>