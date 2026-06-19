<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
session_start();
$pedidos_id=$_GET['pedidos_id'];
$sql = "SELECT * FROM productos";

$resultado = $conn->query($sql);
$sqlTotal="SELECT sum(costototal) FROM carrito where Pedido_id='$pedidos_id'";
$costototal=$conn->query($sqlTotal);
$res = $costototal->fetch_assoc();
$costototal=$res['sum(costototal)'];
if($res['sum(costototal)']==null){
    $total=0;
}
echo "<h3>Total: ".$costototal."</h3>";
echo "<table border='1'>";

echo "<tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Acciones</th>
        <th colspan=2>Agregar al Carrito</th>
      </tr>";

while($fila = $resultado->fetch_assoc()){
    echo "<form action='28.registrocarrito.php' method='post'>";
    echo "<tr>";
        echo "<td>".$fila["codigo"]."</td>";
        echo "<td>".$fila["nombre"]."</td>";
        echo "<td>".$fila["descripcion"]."</td>";   
        echo "<td>".$fila["precio"]."</td>";
        echo "<td>
                <a href='producto.php?productos_codigo=".$fila["productos_codigo"]."'>
                    <button>Mostrar</button>
                </a>
            </td>";
        echo "<input type='hidden' value=".$fila["productos_codigo"]." name='productos_codigo'>";
        echo "<input type='hidden' value=".$pedidos_id." name='pedidos_id'>";
        echo "<input type='hidden' value=".$fila["precio"]." name='precio'>";
        echo "<td><input type='number' name='cantidad' value=0></td>";
        echo "<td><input type='submit' value='Agregar'></td>";
        echo "</tr>";
        echo "</form>";

}

echo "</table>";
echo "<a href='./pedios/1.formpedidos.php'>
        <button>Generar Nuevo Pedido</button>
      </a><br><br>";

?>