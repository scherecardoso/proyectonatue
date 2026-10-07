<?php
// Inicia o recupera la sesión para acceder al identificador del pedido actual.
session_start();
// Carga la conexión a la base de datos.
require("php/conexion.php");

// Comprueba que exista un pedido asociado a la sesión antes de mostrar el recibo.
if(!isset($_SESSION["pedido"])){
    echo "No existe pedido activo";
    exit;
}

// Guarda el identificador del pedido para usarlo en las consultas.
$id = $_SESSION["pedido"];

// Busca los datos generales del pedido.
$sql = "SELECT * FROM pedidos WHERE id='$id'";
$resultado = $conn->query($sql);
$pedido = $resultado->fetch_assoc();

// Detiene la página si el pedido no se encontró en la base de datos.
if(!$pedido){
    echo "No se encontró el pedido";
    exit;
}

// Obtiene el nombre, la cantidad y el costo total de cada producto del pedido.
$sqlProductos = " SELECT p.nombre, c.cantidad, c.costototal
FROM carrito c
INNER JOIN productos p ON c.productos_codigo = p.codigo
WHERE c.pedidos_id = '$id'
";

$resultadoProductos = $conn->query($sqlProductos);

// Acumula los costos de los productos para calcular el total del recibo.
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- El título identifica el recibo con el número de pedido. -->
<title>Recibo<?php echo $pedido["id"]; ?></title>
<!-- Hoja de estilos que da formato visual al ticket. -->
<link rel="stylesheet" href="css/ticket.css">
<!-- SweetAlert se utiliza para mostrar avisos al usuario. -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<!-- Contenedores principales del recibo, centrados y diseñados como un ticket. -->
<div class="pagina">
<div class="recibo">

<!-- Encabezado con la marca, el código QR y el número del pedido. -->
<div class="encabezado">


<h1>NATUÉ</h1>

<!-- Genera un código QR con la dirección de esta página de recibo. -->
<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?php echo urlencode("http://localhost/proyectonatue/ajax/recibo.php"); ?>" width="90" height="90" alt="Código QR" style="display:block;margin:0 auto 15px;">
<p>Productos naturales</p>

<div class="linea"></div>

<h2>RECIBO DE PEDIDO</h2>
<div class="numeroPedido">
Pedido #<?php echo $pedido["id"]; ?>
</div>
</div>

<!-- Informa al cliente que el vendedor todavía debe aprobar el pedido. -->
<div class="estadoBox">
<strong>Esperando aprobación</strong>
<p>Tu pedido está siendo revisado por el vendedor.</p>
</div>

<!-- Presenta los datos del cliente y el estado guardado para el pedido. -->
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

<!-- Lista cada producto asociado al pedido. -->
<div class="seccion">
<h3>Productos</h3>

<div class="productos">

<?php
// Recorre los productos obtenidos y va sumando el importe de cada uno.
while($producto = $resultadoProductos->fetch_assoc()){

    $total += $producto["costototal"];
?>

<div class="producto">

<div class="productoInfo">
<strong>
<!-- Escapa el nombre para mostrarlo de forma segura en el HTML. -->
<?php echo htmlspecialchars($producto["nombre"]); ?>
</strong>

<span>
<!-- Muestra cuántas unidades de este producto se incluyeron en el pedido. -->
Cantidad: <?php echo $producto["cantidad"]; ?>
</span>
</div>

<div class="productoPrecio">
<!-- Presenta el costo total de esta línea con dos decimales. -->
Bs <?php echo number_format($producto["costototal"], 2); ?>
</div>

</div>

<?php
}
?>

</div>
</div>

<!-- Muestra el total acumulado de todos los productos del pedido. -->
<div class="totalBox">

<span>Total del pedido</span>

<strong>
Bs <?php echo number_format($total, 2); ?>
</strong>

</div>

<!-- Código QR proporcionado para que el cliente pueda realizar el pago. -->
<div style="text-align:center;margin:20px 0;">

<p>Escanea para Pagar</p>
     <img src="../img/QR-NATUE.jpeg" width="200" height="200" alt="Código QR"> 


</div>

<!-- Acciones disponibles para imprimir, descargar o iniciar otra compra. -->
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

<!-- Carga jsPDF para generar el recibo como archivo PDF en el navegador. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>

// Al pulsar el botón, crea un PDF y escribe los datos principales del pedido.
document.getElementById("descargarPDF").addEventListener("click", function(){

// Obtiene el constructor de jsPDF y crea un documento nuevo.
const { jsPDF } = window.jspdf;
const pdf = new jsPDF();

// Imprime la marca y el título del recibo.
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

// Agrega al PDF los datos del pedido y del cliente obtenidos desde PHP.
pdf.text("Pedido: #" + "<?php echo $pedido["id"]; ?>", 20, 55);
pdf.text("Cliente: " + "<?php echo addslashes($pedido["nombre"]); ?>", 20, 65);
pdf.text("Telefono: " + "<?php echo addslashes($pedido["telefono"]); ?>", 20, 75);
pdf.text("Direccion: " + "<?php echo addslashes($pedido["direccion"]); ?>", 20, 85);
pdf.text("Metodo de pago: " + "<?php echo addslashes($pedido["metodoPago"]); ?>", 20, 95);
pdf.text("Estado: " + "<?php echo addslashes($pedido["estado"]); ?>", 20, 105);

pdf.line(20, 112, 190, 112);

// Destaca el monto total en el documento descargable.
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

// Guarda el archivo usando el número del pedido como parte del nombre.
pdf.save("pedido-<?php echo $pedido["id"]; ?>.pdf");

});

// Al volver a productos, solicita al servidor iniciar una nueva compra.
document.getElementById("volverProductos").addEventListener("click", function(){

// Envía la solicitud al endpoint y espera una respuesta JSON.
fetch("php/nueva_compra.php")

.then(res => res.json())

.then(data => {

// Si el servidor confirma la operación, regresa a la página de productos.
if(data.ok){
window.location.href = "index.php";
}else{
// Informa si el servidor no pudo preparar una nueva compra.
Swal.fire({
  title: "Hay un problrema",
  text: "No se pudo iniciar una nueva compra.",
  icon: "error"
});
}

})

.catch(error => {

// Registra el error técnico y muestra un aviso comprensible al usuario.
console.log(error);

Swal.fire({
  title: "ERROR",
  text: "Ocurrio un error al iniciar una nueva compra.",
  icon: "error"
});
});

});

</script>

</body>
</html>