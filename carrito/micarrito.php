<?php
session_start();

if (empty($_SESSION['nombre'])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

$conn = new mysqli("localhost","root","","shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$id_pedido = (int)($_GET['Pedido_id'] ?? 0);

$sql = "SELECT * FROM producto";

$resultado = $conn->query($sql);
$sqlTotal="SELECT sum(costototal) FROM carrito where Pedido_id='$id_pedido'";
$resultadoTotal=$conn->query($sqlTotal);
$res = $resultadoTotal->fetch_assoc();
$total=$res['sum(costototal)'];

if($res['sum(costototal)']==null){
    $total=0;
}
echo "<h3>Total: ".$total."</h3>";
echo "<table border='1'>";

echo "<tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Acciones</th>
        <th colspan=2>Agregar al Carrito</th>
      </tr>";

while($fila = $resultado->fetch_assoc()){
    echo "<tr>";
        echo "<td>".$fila["codigo"]."</td>";
        echo "<td>".$fila["nombre"]."</td>";
        echo "<td>".$fila["descripcion"]."</td>";
        echo "<td>".$fila["precio"]."</td>";
        echo "<td>
                <a href='../pagina/03.productos.php?codigo=".$fila["codigo"]."'>
                    <button>Mostrar</button>
                </a>
            </td>";
        echo "<input type='hidden' value=".$fila["codigo"]." name='codigo'>";
        echo "<input type='hidden' value=".$id_pedido." name='Pedido_id'>";
        echo "<input type='hidden' value=".$fila["precio"]." name='precio'>";

        echo "<td><input type='number' name='cantidad' value=0></td>";
        echo "<td><input type='submit' value='Agregar'></td>";
        echo "</tr>";
        echo "</form>";

}

echo "</table>";
echo "<a href='../pedidos/1.formpedido.php'>
        <button>Generar Nuevo Pedido</button>
      </a><br><br>";

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