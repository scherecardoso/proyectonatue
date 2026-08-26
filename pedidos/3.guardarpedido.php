<?php
session_start();

$conexion = new mysqli("localhost","root","","shena");

if($conexion->connect_error){
    die("Error de conexión");
}



// ==========================================
// RECIBIR DATOS DEL FORMULARIO
// ==========================================

$nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$vendedor = $_POST['vendedor'];
$telefono = $_POST["telefono"];
$direccion = $_POST["direccion"];

// ==========================================
// INSERTAR PEDIDO
// ==========================================

$sql = "INSERT INTO pedidos(nombre, fecha, estado, vendedor)VALUES('$nombre','$fecha','$estado','$vendedor')";

if ($conexion->query($sql)) {
   // ======================================
    // OBTENER ID DEL PEDIDO CREADO
    // ======================================
    $idPedido = $conexion->insert_id;

        // ======================================
    // GUARDAR ID DEL PEDIDO EN SESIÓN
    // ======================================
    $_SESSION["pedidos_id"] = $idPedido;
if (isset($_SESSION["producto_temp"])) {

        $datos = $_SESSION["producto_temp"];

        $codigo = $datos["codigo"];
        $cantidad = (int)$datos["cantidad"];
        $precio = (float)$datos["precio"];

        $total = $cantidad * $precio;
       // ==================================
        //  INSERTAR PRODUCTO EN CARRITO
        // ==================================
        $sqlCarrito = "INSERT INTO carrito
        (pedidos_id, productos_codigo, cantidad, costototal)
        VALUES
        ('$idPedido','$codigo','$cantidad','$total')
        ON DUPLICATE KEY UPDATE
        cantidad = cantidad + VALUES(cantidad),
        costototal = costototal + VALUES(costototal)";

        $conexion->query($sqlCarrito);
        // ==================================
        //  BORRAR PRODUCTO TEMPORAL
        // ==================================
        unset($_SESSION["producto_temp"]);
    }

    header("Location: ../carrito/micarrito.php");
    exit();

} else {

    echo "Error al crear pedido: " . $conexion->error;
}
?>