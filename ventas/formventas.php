<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);
$id_pedidos=$_GET ['íd_pedidos'];
$sql="SELECT *FROM pedidos WHERE id='$íd_pedidos'";
$resultado=$conn->query($sql);
while($fila=$resultado->fetch_assoc())
    {
        $nombre=$fila["nombre"];
    }
//para hallar el total del pedido 
$sqltotal="SELECT sum(costototal)FROM carrito where pedidos_id='$íd_pedidos'";
$resultadoTotal=$conn->query($sqltotal);
$res= $resultadoTotal->fetch_assoc();
$total=$res['sum(costototal)'];
if($res['sum(costototal)']==null){
    $total=0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de venta</title>
</head>
<body>
    <form action="../guardarventas/createventas.php" method="post" id="valiventas">
        pedido:
        <input type="text" name="nombrePedidos" value="<?php echo $nombre?>"readonly>
        <br><br>
        fecha:
        <input type="date" name="fecha">
        <br><br>
        estado :
        <select name="estado">
            <option value="pagado">pagado</option>
            <option value="pendiente">pendiente</option>

</select>
<br><br>
<input type="hidden" value="<?=$total?>"name="total">
<input type="hidden" value="<?=$id_pedidos?>"name="pedidos_id">
<input type="submit" value="guardar">

        <button type="submit">Crear Venta</button>
    </form>
</body>
</html>