<?php
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

session_start();

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

$sqltotal = "SELECT SUM(costototal) AS total FROM carrito WHERE id='$id'";
$resultadototal = $conn->query($sqltotal);

$res = $resultadototal->fetch_assoc();
$total = $res['total'];

if ($total == null) {
    $total = 0;
}

echo "<h1>Carrito de compras</h1>";
echo "<h3>Total acumulado: Bs. $total</h3>";

echo "<table border='1'>";

echo "<tr>
        <th>Codigo</th>
        <th>Precio</th>
        <th>Cantidad Disponible</th>
        <th>Agregar al carrito</th>
        <th>Cantidad</th>
        <th>Accion</th>
      </tr>";

while ($fila = $result->fetch_assoc()) {

    echo "<form action='29.agregarcarrito.php' method='POST'>";

    echo "<tr>";

    echo "<td>" . $fila['codigo'] . "</td>";
    echo "<td>" . $fila['precio'] . "</td>";
    echo "<td>" . $fila['cantidad'] . "</td>";

    echo "<td>
            <a href='29.agregarcarrito.php?codigo=" . $fila['codigo'] . "'>
                Agregar al carrito
            </a>
          </td>";

    echo "<input type='hidden' name='codigo' value='" . $fila['codigo'] . "'>";
    echo "<input type='hidden' name='id' value='" . $id . "'>";
    echo "<input type='hidden' name='precio' value='" . $fila['precio'] . "'>";

    echo "<td>
            <input type='number' name='cantidad' value='1' min='1'>
          </td>";

    echo "<td>
            <input type='submit' value='Agregar'>
          </td>";

    echo "</tr>";

    echo "</form>";
}

echo "</table>";

echo "<br>";

echo "<a href='formpedidos.php'>
        <button>Nuevo pedido</button>
      </a>";

$conn->close();
?>
