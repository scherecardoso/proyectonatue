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
if ($result && $result->num_rows > 0) {
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

echo "
<tr>
<td>".$fila['codigo']."</td>
<td>".$fila['id']."</td>
<td>".$fila['cantidad']."</td>
<td>".$fila['costototal']."</td>

<td>
 a class='btn eliminar' href='30.eliminarcarrito.php?codigo=$codigo'>Eliminar</a>
 a class='btn editar' href='30.editarcarrito.php?codigo=$codigo'>Editar</a>
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