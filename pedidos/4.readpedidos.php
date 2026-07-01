<?php
session_start();
?>
<?php
$conexion = new mysqli("localhost", "root", "", "shena");
if ($conexion->connect_error) {
    die("Error de conexión");
}
$sql = "SELECT * FROM pedidos";
$resultado = $conexion->query($sql);

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
<title>Mis Pedidos</title>

<style>


.cielo-suave{
    font-family: Arial;
    background: #f7f7f7;
    margin: 0;
    padding: 0;
}

.nube-titulo{
    text-align: center;
    color: #444;
    margin-bottom: 20px;
}


.caja-brisada{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 18px;
}


.capsula-perla{
    background: #ffffff;
    width: 270px;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(180,180,180,0.4);
    border: 1px solid #e6e6e6;
}


.titulo-pedido{
    margin: 0;
    color: #555;
}

.texto-suave{
    color: #777;
    margin: 5px 0;
}


.zona-botones{
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
}

.zona-botones a{
    text-decoration: none;
}


.botoncito{
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    transition: 0.2s;
}


.ver-rosa{
    background: #f8c8dc;
    color: #333;
}

.editar-plata{
    background: #d9d9d9;
    color: #333;
}

.eliminar-rojo-suave{
    background: #f3a6b5;
    color: #fff;
}

.botoncito:hover{
    transform: scale(1.05);
}

</style>
</head>

<body class="cielo-suave">
<?php include("../includes/header.php"); ?>
<h1 class="nube-titulo">Mis Pedidos</h1>
<div class="caja-brisada">

<?php
if ($resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $id = $fila['id'];
        echo "
        <div class='capsula-perla'>
            <h3 class='titulo-pedido'>Pedido #$id</h3>
            <p class='texto-suave'><b>Nombre:</b> {$fila['nombre']}</p>
            <p class='texto-suave'><b>Fecha:</b> {$fila['fecha']}</p>
            <p class='texto-suave'><b>Estado:</b> {$fila['estado']}</p>
            <p class='texto-suave'><b>Vendedor:</b> {$fila['vendedor']}</p>
            <div class='zona-botones'>
            <a href='5.editarpedido.php?id=$id'> <button class='botoncito editar-plata'>Editar</button></a>
            <a href='7.deletepedido.php?id=$id'><button class='botoncito eliminar-rojo-suave'>Eliminar</button></a>
        </div>
        </div>";
    }

} else {
    echo "<p style='text-align:center;'>No hay pedidos</p>";
}
?>

</div>
</body>
</html>