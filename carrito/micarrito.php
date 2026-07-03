<?php
session_start();

if (!isset($_SESSION['nombre']) || trim($_SESSION['nombre']) === "") {
    header("Location: ../usuario/09.register.php");
    exit();
}

$conn = new mysqli("localhost","root","","shena");

if ($conn->connect_error) {
    die("Error de conexión");
}

$nombre = $conn->real_escape_string($_SESSION['nombre']);
$sqlPedido = " SELECT id FROM pedidos WHERE nombre='$nombre' AND estado='En Proceso' ORDER BY id DESC LIMIT 1";
$resPedido = $conn->query($sqlPedido);

if($resPedido->num_rows == 0){
    die("No existe un pedido activo");
}

$pedido = $resPedido->fetch_assoc();
$id_pedido = $pedido['id'];

$sqlTotal = "SELECT SUM(costototal) AS total FROM carrito WHERE pedidos_id='$id_pedido'";
$res = $conn->query($sqlTotal);

if ($res) {
    $row = $res->fetch_assoc();
    $total = $row['total'] ?? 0;
} else {
    $total = 0;
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
    max-width: none;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,.1);
    width: 95%;
    height:105%;
    transform: translateX(170px);
    top:90%;
    
}
h2{
    text-align: center;
    color: #d88aa7;
    margin-bottom: 10px;
}
.total{
    text-align: center;
    color: #666;
    margin-bottom: 25px;
}
table{
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 10px;
}
th{
    background: #f4dbe5;
    color: #555;
    padding: 12px;
}
td{
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}
tr:hover{
    background: #faf2f6;
}
input{
    width: 60px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.btn-actualizar{
    background: #d88aa7;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
}
.btn-actualizar:hover{
    background: #c06d8c;
}
.btn-eliminar{
    background: #d9d9d9;
    color: black;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
}
.btn-eliminar:hover{
    background: #bfbfbf;
}
.btn-finalizar{
    display: block;
    width: 220px;
    margin: 30px auto;
    text-align: center;
    background: #d88aa7;
    color: white;
    padding: 14px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    font-size: 16px;
}
.btn-finalizar:hover{
    background: #c06d8c;
}
.extra{
    text-align: center;
    margin-top: 20px;
}

.btn-volver{
    display: inline-block;
    background: #e9e9e9;
    color: black;
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 5px;
    transition: 0.3s;
}

.btn-volver:hover{
    background: #ccccccbd;
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

@media screen and (max-width: 768px) {
    body {
        padding: 15px;
    }

    .contenedor {
        padding: 15px;
    }

    h2 {
        font-size: 24px;
    }

    h3.total {
        font-size: 18px;
    }

    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }

    .btn-finalizar {
        width: 100%;
        max-width: 300px;
    }
}

@media  (max-width: 600px) {

    .contenedor {
        overflow-x: auto;
    }

    table {
        min-width: 600px;
    }

    input[type="number"] {
        width: 50px;
    }

    .btn-actualizar,
    .btn-eliminar {
        font-size: 12px;
        padding: 6px 8px;
    }

    .btn-finalizar {
        width: 100%;
        font-size: 14px;
        padding: 12px;
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

<h2>Mi Carrito</h2>
<h3 class="total">Total del Pedido: <?php echo $total; ?> Bs</h3>

<table>

<tr>
<th>Código</th>
<th>Nombre</th>
<th>Precio</th>
<th>Cantidad</th>
<th>Total</th>
<th>Acciones</th>
</tr>

<?php
$sqlCarrito = " SELECT productos.codigo,productos.nombre,productos.precio,carrito.cantidad,carrito.costototal
FROM carrito
INNER JOIN productos
ON carrito.productos_codigo = productos.codigo
WHERE carrito.pedidos_id = '$id_pedido'
";

$resCarrito = $conn->query($sqlCarrito);
echo "Pedido actual: " . $id_pedido . "<br>";
while($fila = $resCarrito->fetch_assoc()){

?>

<tr>
<td><?php echo $fila['codigo']; ?></td>
<td><?php echo $fila['nombre']; ?></td>
<td><?php echo $fila['precio']; ?> Bs</td>
<td>

<form action="editarcarrito.php" method="POST">

<input type="hidden"name="idPedido"value="<?php echo $id_pedido; ?>">
<input type="hidden"name="codigo"value="<?php echo $fila['codigo']; ?>">
<input type="hidden"name="precio"value="<?php echo $fila['precio']; ?>">
<input type="number"name="cantidad"value="<?php echo $fila['cantidad']; ?>"min="1">
<input class="btn-actualizar"type="submit"value="Actualizar">
</form>
</td>

<td><?php echo $fila['costototal']; ?> Bs</td>

<td>
<a class="btn-eliminar"href="eliminarcarrito.php?idPedido=<?php echo $id_pedido; ?>&codigo=<?php echo $fila['codigo']; ?>">Eliminar</a>
</td>
</tr>

<?php
}
?>

</table>
<a class="btn-finalizar" href="../pedidos/8.finalizarpedido.php?idPedido=<?php echo $id_pedido; ?>"> Finalizar Pedido </a>

<div class="extra">
    <a href="../pagina/03.productos.php" class="btn-volver">
        Seguir viendo productos
    </a>
</div>


</div>
</body>
</html>
<?php
$conn->close();
?>