<?php
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}

$codigo = $_GET['codigo'];
$sql = "SELECT * FROM carrito WHERE codigo='$codigo'";
$resultado = $conn->query($sql);
$fila = $resultado->fetch_assoc();
if($resultado->num_rows > 0){
        while($fila=$resultado->fetch_assoc()){
            $codigo = $fila['codigo'];
            $id = $fila['id'];
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
    
    <form action="32.updatecarrito.php" method="post">
<h1>Editar Carrito</h1>
 <label for="codigo">Nombre:</label>
        <input type="hidden" name="codigo" value='<?=$codigo?>'>
        <input type="text" name="nombreproducto" value='<?=$nombreproducto?>'><br>
        <label for="id">ID</label>
        <input type="number" name="id" value='<?=$id?>'><br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" value='<?=$cantidad?>'><br>
        <label for="costototal">Costo Total:</label>
        <input type="submit">

</form>
</body>
</html>