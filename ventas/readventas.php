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

<?php
if ($resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

        $id = $fila['id'];
        echo "
        <div class=''>
            <h3 class='titulo-venta'> Venta #$id</h3>
            <p class='texto-suave'><b>Costo:</b> {$fila['costo']}</p>
            <p class='texto-suave'><b>Metodo:</b> {$fila['metodo']}</p>
            <p class='texto-suave'><b>Estado:</b> {$fila['estado']}</p>
            <div class='zona-botones'>
            <a href='editarventa.php?id=$id'> <button class='botoncito editar-plata'>Editar</button></a>
            <a href=' deleteventa.php?id=$id'><button class='botoncito eliminar-rojo-suave'>Eliminar</button></a>
        </div>
        </div>";
    }

} else {
    echo "<p style='text-align:center;'>No hay ventas</p>";
}
?>