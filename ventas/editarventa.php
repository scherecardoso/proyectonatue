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

<div class="contenedor">

    <form action="updatepedido.php" method="POST">

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