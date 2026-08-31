<?php
session_start();

if ($_SESSION['rol'] != 'vendedor') {
    header("Location: ../pagina/login.php");
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

<style>



body {
  display: grid; 
  font-family: Arial, sans-serif;
  margin: 0;
  grid-template-areas:
    "barra barra"
    "menu-lateral contenido";
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
    grid-area:contenido;
    width:90%;
    max-width:1200px;
    margin:40px auto;
    background:white;
    padding:35px;
    border-radius:28px;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
    border:1px solid #f3f3f3;
}



table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 12px;
}

th{
    background:#fff1f7;
    padding:18px;
    font-size:15px;
    color:#ff5ca8;
    border:none;
}

td{
    background:white;
    padding:18px;
    font-size:14px;
    text-align:center;
    border-top:1px solid #f3f3f3;
    border-bottom:1px solid #f3f3f3;
}

tr td:first-child{
    border-left:1px solid #f3f3f3;
    border-radius:15px 0 0 15px;
}

tr td:last-child{
    border-right:1px solid #f3f3f3;
    border-radius:0 15px 15px 0;
}

tr:hover td{
    background:#fff8fb;
}



.btn{
    padding:8px 20px;
    border-radius:20px;
    font-size:13px;
    font-weight:500;
    text-decoration:none;

}

.editar{
    background:#ffe4ef;
    color:#ff4f8b;
    
}

.eliminar{
    background:#fff0f0;
    color:#ff4d4d;
}

.sin-datos{
    text-align:center;
    margin-top:40px;
    color:#777;
}



@media (max-width:768px){

body{
    display:flex;
    flex-direction:column;
}

.menu{
    width:100%;
    border-right:none;
}

.contenedor{
    width:95%;
    padding:15px;
    margin:20px auto;
}

table{
    font-size:12px;
}

th,
td{
    padding:10px;
}

h1{
    font-size:28px;
}

}

</style>
</head>

<body>
<?php include("../includes/header.php"); ?>
<aside class="menu-lateral">
  <a class="menu-titulo"><h2>Menu Vendedor</h2></a>
  <a href="../vendedor/07.vendedor.php"><i class="fa-solid fa-house"></i> Inicio</a>
  <a href="../productos/16.formproductos.php"><i class="fa-solid fa-cart-shopping"></i> Registrar Productos</a>
  <a href="../productos/22.readproductos.php"><i class="fa-solid fa-box"></i> Stock de Productos</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-truck"></i> Pedidos de Clientes</a>
  <a href="../ventas/readventas.php"><i class="fa-solid fa-history"></i> Historial de Ventas</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-info-circle"></i> Estado de Pedidos</a>
  <a href=""><i class="fa-solid fa-user"></i> Mi perfil</a>
  <a href="../auth/26.cerrarsesion.php">Cerrar Sesión</a>
</aside>



<div class="contenedor">
    <h1>Lista de Productos</h1>

<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}
if ($_SESSION['rol'] == 'vendedor' || $_SESSION['rol'] == 'administrador') {
 

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

    echo "<table>";
    echo "
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Costo</th>
        <th>Stock</th>
        <th>Imagen</th>
        <th>Acciones</th>
    </tr>
    ";

    while($fila = $result->fetch_assoc()) {

        $codigo = $fila['codigo'];

        echo "
        <tr>
            <td>{$fila['codigo']}</td>
            <td>{$fila['nombre']}</td>
            <td>{$fila['descripcion']}</td>
            <td>$ {$fila['precio']}</td>
            <td>$ {$fila['costo']}</td>
            <td>{$fila['stock']}</td>";
$directorio = "../img/";
$archivoImagen = $directorio . $fila['imagen'];

if (file_exists($archivoImagen)) {
    echo "<td><img src='".$archivoImagen."' width='150'></td>";
} else {
    echo "<td>No imagen</td>";
}
        echo "
            <td>
                <a class='btn editar'
                href='../productos/18.formeditarproductos.php?codigo=$codigo'>
                Editar
                </a>

                <a class='btn eliminar'
                href='../productos/20.eliminarproductos.php?codigo=$codigo'>
                Eliminar
                </a>
            </td>
        </tr>
        ";
    }

    echo "</table>";

} else {

    echo "<p class='sin-datos'>
    No hay productos registrados
    </p>";

}  }else{ echo "Acceso denegado";
    exit();
}

$conn->close();

?>

</div>

</div>
</body>
</html>