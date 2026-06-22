<?php
session_start();
$vendedor = "Administrador";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Pedido</title>
</head>
<body>
<h2>Crear Pedido</h2>
<form action="nuevopedido.php" method="POST">
    Nombre:
    <input type="text"name="nombre"value="<?php echo $_SESSION['nombre']; ?>"readonly><br><br>

    Fecha:
    <input type="date"name="fecha"value="<?php echo date('Y-m-d'); ?>" readonly><br><br>
    <input type="hidden"name="estado"value="En Proceso">

    Vendedor:
    <input type="text"name="nombreVendedor"value="<?php echo $vendedor; ?>"readonly><br><br>
    <input type="submit" value="Crear Pedido">

</form>
</body>
</html>