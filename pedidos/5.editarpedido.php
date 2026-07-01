<?php
session_start();
?>
<?php
$direccion = "localhost";
$usuario = "root";
$contraseña = "";
$nombreBD = "shena";

$conexion = new mysqli($direccion, $usuario, $contraseña, $nombreBD);

if ($conexion->connect_error) {
    die("Error de conexión");
}

$id = $_GET['id'] ?? null;

if ($id == null) {
    die("No se recibió el ID del pedido");
}

$sql = "SELECT * FROM pedidos WHERE id='$id'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $nombre = $fila['nombre'];
    $fecha = $fila['fecha'];
    $estado = $fila['estado'];
    $vendedor = $fila['vendedor'];

} else {

    die("Pedido no encontrado");

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
<title>Editar Pedido</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#f5f5f5;
    margin:0;
    padding:0;
}

.contenedor{
    width:500px;
    margin:50px auto;
    background:#ffffff;
    padding:30px;
    border-radius:15px;
    border:1px solid #d9d9d9;
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

h1{
    text-align:center;
    color:#555;
    margin-bottom:25px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#555;
}

input[type="text"],
input[type="date"]{
    width:100%;
    padding:12px;
    margin-bottom:18px;
    border:1px solid #cfcfcf;
    border-radius:8px;
    box-sizing:border-box;
    transition:0.3s;
}

input[type="text"]:focus,
input[type="date"]:focus{
    outline:none;
    border-color:silver;
    box-shadow:0 0 6px rgba(192,192,192,0.5);
}

button{
    width:100%;
    padding:12px;
    background:silver;
    color:#333;
    border:none;
    border-radius:8px;
    font-size:15px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#bfbfbf;
    transform:translateY(-2px);
}

.volver{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#666;
    transition:0.3s;
}

.volver:hover{
    color:#333;
}

@media(max-width:768px){

    .contenedor{
        width:90%;
        padding:20px;
        margin:20px auto;
    }

    h1{
        font-size:22px;
    }

}

</style>

</head>

<body>
<?php include("../includes/header.php"); ?>
<div class="contenedor">

    <form action="6.updatepedido.php" method="POST">

        <h1>Pedido Nro <?php echo $id; ?></h1>

        <label>Nombre:</label>
        <input type="text"name="nombre"value="<?php echo $nombre; ?>"required>

        <label>Fecha:</label>
        <input type="date"name="fecha"value="<?php echo $fecha; ?>"required>

        <label>Estado:</label>
        <input type="text"name="estado"value="<?php echo $estado; ?>"required>

        <label>Vendedor:</label>
        <input type="text"name="vendedor"value="<?php echo $vendedor; ?>"required>

        <input type="hidden"name="id"value="<?php echo $id; ?>">

        <button type="submit">Actualizar Pedido</button>

    </form>
    <a href="4.readpedidos.php" class="volver">Volver a Pedido</a>

</div>
</body>
</html>