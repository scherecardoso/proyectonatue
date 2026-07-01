<?php
session_start();

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión");
}

$nombre = $_SESSION['nombre'];

$sql = "SELECT pedidos.id,
               pedidos.fecha,
               pedidos.estado,
               productos.nombre AS producto,
               productos.precio,
               carrito.cantidad,
               carrito.costototal
        FROM pedidos
        INNER JOIN carrito
        ON pedidos.id = carrito.pedidos_id
        INNER JOIN productos
        ON carrito.productos_codigo = productos.codigo
        WHERE pedidos.nombre = '$nombre'
        ORDER BY pedidos.id DESC";

$resultado = $conn->query($sql);
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

.menu {
    grid-area: menu;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: #ffffff;
    padding: 15px;
    margin-top: 27px;
    width: 330px;
    border-right: 1px solid #ececec;
}

.titulo-menu {
    font-size: 15px;
    color: #ff5ca8; 
    margin-bottom: 10px;
}

.menu div{
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
    cursor: pointer;
}

.info {
    grid-area: info;
    display: grid;
    grid-template-areas:
      "contenedor";
    grid-template-rows: auto auto 1fr;
    gap: 20px;
    padding: 10px;
    margin-top: 25px;
}




.menu div:hover{
    background: #ffdcec;
    color: #ff5ca8;
    padding-left: 22px;
} 

.contenedor{
    width: 95%;
    height:100%;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,.1);
    transform: translateX(170px);
}

h2{
    text-align:center;
    color:#d88aa7;
    margin-bottom:25px;
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
    text-align:center;
    border-bottom:1px solid #ddd;
}

tr:hover{
    background:#faf2f6;
}

.estado{
    font-weight:bold;
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

@media  (max-width: 768px) {

    body{
        padding:15px;
    }

    .contenedor{
        padding:15px;
    }

    h2{
        font-size:24px;
    }

    table{
        font-size:14px;
    }

    th,
    td{
        padding:8px;
    }
}


@media (max-width: 600px) {

    body{
        padding:10px;
    }

    .contenedor{
        padding:10px;
        overflow-x:auto;
    }

    table{
        min-width:700px;
    }

    th,
    td{
        padding:6px;
        font-size:12px;
    }

    h2{
        font-size:20px;
    }
}
</style>

</head>
<body>

<?php include("../includes/header.php"); ?>
<aside class="menu">
    <div class="titulo-menu">MENU USUARIO</div>
    <div><a href="../usuario/08.usuario.php"><i class="fa-solid fa-house"></i> Inicio</div>
    <div><i class="fa-solid fa-user"></i> Mi Perfil</div>
    <div><a href="../carrito/micarrito.php"><i class="fas fa-shopping-cart"></i> Mi Carrito</a></div>
    <div><a href="../pedidos/mispedidos.php"><i class="fa-solid fa-bag-shopping"></i> Mis Pedidos</div>
    <div><i class="fa-solid fa-heart"></i> Favoritos</div>
    <div><i class="fa-solid fa-location-dot"></i> Direcciones</div>
    <div><i class="fa-solid fa-credit-card"></i> Pagos</div>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><a href="../auth/26.cerrarsesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></div>
</aside>


<div class="contenedor">
<h2>Mis Pedidos</h2>
<table>

<tr>
    <th>ID Pedido</th>
    <th>Fecha</th>
    <th>Estado</th>
    <th>Producto</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Total</th>
</tr>

<?php

if($resultado && $resultado->num_rows > 0){
    while($fila = $resultado->fetch_assoc()){

?>

<tr>
    <td><?php echo $fila['id']; ?></td>
    <td><?php echo $fila['fecha']; ?></td>
    <td class="estado"><?php echo $fila['estado']; ?></td>
    <td><?php echo $fila['producto']; ?></td>
    <td><?php echo $fila['precio']; ?> Bs</td>
    <td><?php echo $fila['cantidad']; ?></td>
    <td><?php echo $fila['costototal']; ?> Bs</td>
</tr>

<?php
    }
}else{
?>
<tr><td>No tienes pedidos registrados.</td></tr>
<?php
}
?>
</table>
</div>
</body>
</html>
<?php
$conn->close();
?>