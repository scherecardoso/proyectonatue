<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/estilos.css">

</head>

<body>
<?php include("../includes/header.php");?>
  
  
<!--================== ZONA DE TIENDA ==================-->

<div class="zonaTienda">

    <!-- BUSCADOR CENTRADO -->
    <div class="busqueda">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="text"
            id="buscar"
            placeholder="Buscar producto..."
            autocomplete="off">

    </div>


    <!-- GENERAR PEDIDO -->
    <button id="generarPedido">

        <i class="fa-solid fa-file-circle-plus"></i>

        <span>Generar Pedido</span>

    </button>

</div>


<!--================== CARRITO FLOTANTE ==================-->

<button id="carritoIcono" title="Abrir carrito">

    <i class="fa-solid fa-bag-shopping"></i>

    <span id="cantidadCarrito">0</span>

</button>
  

    <!--================== PRODUCTOS ==================-->

    <main>

        <h2 class="titulo">
            Productos Disponibles
        </h2>

        <section id="productos">

        </section>

    </main>
    



</div>
<!--================== FONDO OSCURO ==================-->

    <div id="fondo"></div>

    <!--================== SIDEBAR ==================-->

    <aside id="sidebar">

        <div class="sidebarHeader">

            <h2>🛒 Mi Carrito</h2>

            <button id="cerrarCarrito">✖</button>

        </div>

        <div id="contenidoCarrito">

        </div>

        <div class="sidebarFooter">

            <h3 id="totalCarrito">

                Total: Bs 0

            </h3>

            <button id="vaciarCarrito">

                Vaciar carrito

            </button>

            <button id="comprar">

                Comprar

            </button>

        </div>

    </aside>
 



<!--================== MODAL COMPRA ==================-->

<div id="modalCompra" class="modal">

    <div class="modalContenido">

        <h2>🛍 Finalizar Compra</h2>

        <input type="text"id="nombre"placeholder="Nombre completo">

        <input type="text"id="telefono"placeholder="Teléfono">

        <input type="text"id="direccion" placeholder="Dirección">


        <div class="botonesModal">

            <button id="confirmarPedido">
                Confirmar Compra
            </button>

            <button id="cancelarCompra">
                Cancelar
            </button>

        </div>

    </div>

</div>

</div>
    


<script src="js/productos.js"></script>
<script src="js/pedido.js"></script>
<script src="js/carrito.js"></script>

</body>

</html>