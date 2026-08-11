<?php

session_start();

require("php/conexion.php");





if(!isset($_SESSION["pedido"])){

    echo "No existe pedido activo";

    exit;

}


$id=$_SESSION["pedido"];



$sql="
SELECT *
FROM pedidos
WHERE id='$id_pedidos                                                                                                                                                                                                                                                                                                              '
";


$resultado=$conn->query($sql);


$pedido=$resultado->fetch_assoc();

?>


<!DOCTYPE html>
<html>

<head>

<title>Recibo</title>


<link rel="stylesheet" href="css/ticket.css">


</head>


<body>


<h1>MI TIENDA</h1>


<h2>
Recibo de Pedido
</h2>


<p>
Número:
<?php echo $pedido["id"]; ?>
</p>


<p>
Cliente:
<?php echo $pedido["nombre"]; ?>
</p>


<p>
Teléfono:
<?php echo $pedido["telefono"]; ?>
</p>


<p>
Dirección:
<?php echo $pedido["direccion"]; ?>
</p>



<p>
Estado:
<?php echo $pedido["estado"]; ?>
</p>


<hr>


<h3>
Productos
</h3>


<?php


$sqlProductos="

SELECT 
p.nombre,
c.cantidad,
c.costototal

FROM carrito c

INNER JOIN productos p

ON c.productos_codigo=p.codigo

WHERE c.pedidos_id='$id'

";


$resultadoProductos=$conn->query($sqlProductos);


$total=0;


while($producto=$resultadoProductos->fetch_assoc()){


$total += $producto["costototal"];


echo "

<p>
".$producto["nombre"]."
<br>
Cantidad: ".$producto["cantidad"]."
<br>
Subtotal: Bs ".$producto["costototal"]."
</p>

";


}


?>


<h2>
Total: Bs <?php echo $total; ?>
</h2>


<h3>
Esperando aprobación del vendedor
</h3>
<button onclick="window.print()">
    

🖨 Imprimir

</button>
<button id="volverProductos">

Volver a Productos

</button>

<script>

document
.getElementById("volverProductos")
.addEventListener("click",()=>{

    fetch("php/nueva_compra.php")

    .then(res=>res.json())

    .then(data=>{

        if(data.ok){

            window.location.href="index.php";

        }

    });

});

</script>


</body>

</html>