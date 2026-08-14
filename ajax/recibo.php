<?php
session_start();
require("php/conexion.php");

if(!isset($_SESSION["pedido"])){
    echo "No existe pedido activo";
    exit;
}

$id = $_SESSION["pedido"];

$sql = "SELECT * FROM pedidos WHERE id='$id'";
$resultado = $conn->query($sql);
$pedido = $resultado->fetch_assoc();

if(!$pedido){
    echo "No se encontró el pedido";
    exit;
}

$sqlProductos = "
SELECT p.nombre, c.cantidad, c.costototal
FROM carrito c
INNER JOIN productos p ON c.productos_codigo = p.codigo
WHERE c.pedidos_id = '$id'
";

$resultadoProductos = $conn->query($sqlProductos);

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recibo<?php echo $pedido["id"]; ?></title>
<link rel="stylesheet" href="css/ticket.css">
</head>

<body>

<div class="pagina">
<div class="recibo">

<div class="encabezado">
<h1>NATUÉ</h1>
<p>Productos naturales</p>
<div class="linea"></div>
<h2>RECIBO DE PEDIDO</h2>
<div class="numeroPedido">
Pedido #<?php echo $pedido["id"]; ?>
</div>
</div>

<div class="estadoBox">
<strong>Esperando aprobación</strong>
<p>Tu pedido está siendo revisado por el vendedor.</p>
</div>

<div class="seccion">
<h3>Datos del cliente</h3>

<div class="datos">

<div class="dato">
<span>Cliente</span>
<strong><?php echo htmlspecialchars($pedido["nombre"]); ?></strong>
</div>

<div class="dato">
<span>Teléfono</span>
<strong><?php echo htmlspecialchars($pedido["telefono"]); ?></strong>
</div>

<div class="dato">
<span>Dirección</span>
<strong><?php echo htmlspecialchars($pedido["direccion"]); ?></strong>
</div>

<div class="dato">
<span>Método de pago</span>
<strong><?php echo htmlspecialchars($pedido["metodoPago"]); ?></strong>
</div>

<div class="dato">
<span>Estado</span>
<strong class="estadoTexto">
<?php echo htmlspecialchars($pedido["estado"]); ?>
</strong>
</div>

</div>
</div>

<div class="seccion">
<h3>Productos</h3>

<div class="productos">

<?php
while($producto = $resultadoProductos->fetch_assoc()){

    $total += $producto["costototal"];
?>

<div class="producto">

<div class="productoInfo">
<strong>
<?php echo htmlspecialchars($producto["nombre"]); ?>
</strong>

<span>
Cantidad: <?php echo $producto["cantidad"]; ?>
</span>
</div>

<div class="productoPrecio">
Bs <?php echo number_format($producto["costototal"], 2); ?>
</div>

</div>

<?php
}
?>

</div>
</div>

<div class="totalBox">

<span>Total del pedido</span>

<strong>
Bs <?php echo number_format($total, 2); ?>
</strong>

</div>

<div style="text-align:center;margin:20px 0;">

<p>Escanea para ver este recibo</p>

<img
src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?php echo urlencode("http://localhost/proyectonatue/ajax/recibo.php"); ?>"
width="250"
height="250"
alt="Código QR">

</div>

<div class="acciones">

<button
type="button"
class="btn btnImprimir"
onclick="window.print()">
Imprimir
</button>

<button
type="button"
class="btn btnPDF"
id="descargarPDF">
Descargar PDF
</button>

<button
type="button"
class="btn btnVolver"
id="volverProductos">
Volver a Productos
</button>

</div>

</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>

document.getElementById("descargarPDF").addEventListener("click", function(){

const { jsPDF } = window.jspdf;
const pdf = new jsPDF();

pdf.setFont("helvetica", "bold");
pdf.setFontSize(22);
pdf.text("NATUÉ", 20, 20);

pdf.setFont("helvetica", "normal");
pdf.setFontSize(11);
pdf.text("Productos naturales", 20, 28);

pdf.setFont("helvetica", "bold");
pdf.setFontSize(16);
pdf.text("RECIBO DE PEDIDO", 20, 42);

pdf.setFont("helvetica", "normal");
pdf.setFontSize(11);

pdf.text("Pedido: #" + "<?php echo $pedido["id"]; ?>", 20, 55);
pdf.text("Cliente: " + "<?php echo addslashes($pedido["nombre"]); ?>", 20, 65);
pdf.text("Telefono: " + "<?php echo addslashes($pedido["telefono"]); ?>", 20, 75);
pdf.text("Direccion: " + "<?php echo addslashes($pedido["direccion"]); ?>", 20, 85);
pdf.text("Metodo de pago: " + "<?php echo addslashes($pedido["metodoPago"]); ?>", 20, 95);
pdf.text("Estado: " + "<?php echo addslashes($pedido["estado"]); ?>", 20, 105);

pdf.line(20, 112, 190, 112);

pdf.setFont("helvetica", "bold");
pdf.setFontSize(15);
pdf.text(
"Total: Bs " + "<?php echo number_format($total, 2); ?>",
20,
125
);

pdf.setFont("helvetica", "normal");
pdf.setFontSize(10);

pdf.text("Gracias por tu compra.", 20, 140);
pdf.text("Esperando aprobacion del vendedor.", 20, 148);

pdf.save("pedido-<?php echo $pedido["id"]; ?>.pdf");

});

document.getElementById("volverProductos").addEventListener("click", function(){

fetch("php/nueva_compra.php")

.then(res => res.json())

.then(data => {

if(data.ok){
window.location.href = "index.php";
}else{
alert(data.mensaje || "No se pudo iniciar una nueva compra.");
}

})

.catch(error => {

console.log(error);

alert("Ocurrió un error al iniciar una nueva compra.");

});

});

</script>

</body>
</html>
