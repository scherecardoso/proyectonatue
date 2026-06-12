<?php
    
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="db_natue";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

    if ($conn->connect_error) {
        echo "hubo un error :(";
    }
    $idproductos=$_GET['productos'];
    $sql ="SELECT * FROM productos WHERE codigo=$codigo";
    $resultado = $conn->query($sql);
    if($resultado->num_rows > 0){
        while($fila=$resultado->fetch_assoc()){
            $nombreproducto = $fila['nombreproducto'];
            $descripcion = $fila['descripcion'];
            $precio = $fila['precio'];
            $stock = $fila['stock'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>
<body>
    <form action="updateproductos.php" method="post">
        <label for="codigo">Nombre:</label>
        <input type="hidden" name="codigo" value='<?=$codigo?>'>
        <input type="text" name="nombreproducto" value='<?=$nombreproducto?>'><br>
        <label for="descripcion">Descripcion:</label>
        <input type="text" name="descripcion" value='<?=$descripcion?>'><br>
        <label for="precio">Precio:</label>
        <input type="text" name="precio" value='<?=$precio?>'><br>
        <label for="stock">Stock:</label>
        <input type="text" name="stock" value='<?=$stock?>'><br>
        <input type="submit">
        
    </form>
</body>
</html>