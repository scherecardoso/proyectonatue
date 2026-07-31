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
    die("No se recibió el ID de la Venta");
}

$sql = "SELECT * FROM ventas WHERE id='$id'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $costo = $fila['costo'];
    $metodo = $fila['metodo'];
    $estado = $fila['estado'];

} else {

    die("Venta no encontrada");

}

?>

<div class="contenedor">

    <form action="updateventa.php" method="POST">

        <h1>Venta Nro <?php echo $id; ?></h1>

        <label>Costo:</label>
        <input type="number"name="costo"value="<?php echo $costo; ?>"required>

        <label>Método de Pago:</label>
        <input type="text"name="metodo"value="<?php echo $metodo; ?>"required>

        <label>Estado:</label>
        <input type="text"name="estado"value="<?php echo $estado; ?>"required>

        <input type="hidden"name="id"value="<?php echo $id; ?>">

        <button type="submit">Actualizar Venta</button>

    </form>
    <a href="4.readventas.php" class="volver">Volver a Ventas</a>

</div>