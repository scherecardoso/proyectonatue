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

$pedidos_id = $_GET['pedidos_id'];

$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

$sqlTotal = "SELECT SUM(costototal) FROM carrito WHERE pedidos_id='$pedidos_id'";
$costototal = $conn->query($sqlTotal);

if ($costototal == false) {
    die("Error en la consulta: " . $conn->error);
}

$filaTotal = $costototal->fetch_assoc();
$costototal = $filaTotal['SUM(costototal)'];

if ($costototal == null) {
    $costototal = 0;
}

echo "<h3>Total: " . $costototal . "</h3>";

echo "<table border='1'>";

echo "<tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Acciones</th>
        <th colspan='2'>Agregar al Carrito</th>
      </tr>";

while ($fila = $resultado->fetch_assoc()) {

    echo "<form action='28.registrocarrito.php' method='post'>";
    echo "<tr>";

    echo "<td>".$fila["codigo"]."</td>";
    echo "<td>".$fila["nombre"]."</td>";
    echo "<td>".$fila["descripcion"]."</td>";
    echo "<td>".$fila["precio"]."</td>";

    echo "<td>
            <a href='22.readproductos.php?productos_codigo=".$fila["productos_codigo"]."'>
                <button type='button'>Mostrar</button>
            </a>
          </td>";

    echo "<input type='hidden' name='productos_codigo' value='".$fila["productos_codigo"]."'>";
    echo "<input type='hidden' name='pedidos_id' value='".$pedidos_id."'>";
    echo "<input type='hidden' name='precio' value='".$fila["precio"]."'>";

    echo "<td><input type='number' name='cantidad' value='0'></td>";
    echo "<td><input type='submit' value='Agregar'></td>";

    echo "</tr>";
    echo "</form>";
}

echo "</table>";

echo "<a href='./pedidos/1.formpedidos.php'>
        <button>Generar Nuevo Pedido</button>
      </a><br><br>";

$conn->close();
?>