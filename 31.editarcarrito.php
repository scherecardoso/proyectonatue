<?php
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}

$productos_codigo = $_POST['productos_codigo'];
$sql = "SELECT * FROM carrito WHERE productos_codigo='$productos_codigo'";
$resultado = $conn->query($sql);
$fila = $resultado->fetch_assoc();
if($resultado->num_rows > 0){
        while($fila=$resultado->fetch_assoc()){
            $productos_codigo = $fila['productos_codigo'];
            $pedidos_id = $fila['pedidos_id'];
            $cantidad = $fila['cantidad'];
            $costototal = $fila['costototal'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Carrito</title>
</head>
<body>
    
    <form action="33.updatecarrito.php" method="post">
      <h1>Editar Carrito</h1>
      <label for="productos_codigo">Código del Producto:</label>
        <input type="hidden" name="productos_codigo" value='<?=$productos_codigo?>'><br>
        <label for="pedidos_id">ID del Pedido:</label>
        <input type="number" name="pedidos_id" value='<?=$pedidos_id?>'><br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" value='<?=$cantidad?>'><br>
        <label for="costototal">Costo Total:</label>
        <input type="submit">

</form>
</body>
</html>