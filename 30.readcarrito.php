<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
$sql = "SELECT * FROM carrito";
$resultado = $conn->query($sql);
if ($resultado && $resultado->num_rows > 0) {
echo "<h2>Lista Carrito</h2>";

echo "<table>";
echo "
<tr>
<th>codigo</th>
<th>id</th>
<th>cantidad</th>
<th>costo total</th>
</tr>
";

while($fila = $resultado->fetch_assoc()){
$codigo = $fila['productos_codigo'];
echo "
<tr>
<td>".$fila['productos_codigo']."</td>
<td>".$fila['pedidos_id']."</td>
<td>".$fila['cantidad']."</td>
<td>".$fila['costototal']."</td>

<td>
 a class='btn eliminar' href='32.eliminarcarrito.php?productos_codigo=$codigo'>Eliminar</a>
 a class='btn editar' href='31.editarcarrito.php?productos_codigo=$codigo'>Editar</a>
 </td>
</tr>
";

}

echo "</table>";
}else{
echo "No hay productos en el carrito";
}

$conn->close();
?>