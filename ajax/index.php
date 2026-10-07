<?php
// Inicia o recupera la sesión para validar el acceso y obtener los datos del usuario.
session_start();
// Comprueba si la cuenta tiene alguna restricción de acceso.
include("../includes/verificarbloqueo.php");
// Esta página de tienda está disponible únicamente para usuarios y vendedores.
if (
    !isset($_SESSION['rol']) ||
    !in_array($_SESSION['rol'], ['usuario', 'vendedor'])
) {
    // Detiene la carga de la página cuando el rol no está autorizado.
    echo "Acceso denegado";
    exit();

}
// Recupera los datos de sesión para precargarlos en el formulario de compra.
$nombreUsuario = $_SESSION['nombre'] ?? '';
$telefonoUsuario = $_SESSION['celular'] ?? '';
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <!-- Estilos locales para la consulta y presentación del estado de pedidos. -->
    <style>
  
        /* Distribuye verticalmente las secciones de búsqueda. */
        .zonaBuscadores {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        /* Presenta cada buscador como una tarjeta con separación visual. */
        .seccionBuscador {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Alinea el icono y el título de cada buscador. */
        .seccionBuscador h3 {
            color: #333;
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Mantiene juntos el campo del número de pedido y su botón. */
        .buscadorPedido {
            display: flex; gap: 10px; align-items: center; margin-right: 30%;
        }

        /* Da formato al campo donde se introduce el número del pedido. */
        .buscadorPedido input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }

        /* Resalta el campo de pedido mientras está seleccionado. */
        .buscadorPedido input:focus {
            outline: none;
            border-color: #b5b5b6;
        }

        /* Estilo y alineación del botón para iniciar la consulta. */
        .btnConsultarPedido {
            padding: 12px 25px;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
        }


        /* Indica que la consulta está en curso y deshabilita visualmente el botón. */
        .btnConsultarPedido:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Separa y anima el área donde se muestran los resultados de la consulta. */
        #resultadoPedido {
            margin-top: 15px;
            animation: slideIn 0.3s ease-in-out;
        }

        /* Animación de entrada para avisos y detalles del pedido. */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Formato compartido por los mensajes de estado y error. */
        .alerta {
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Paleta visual para mensajes de error. */
        .alerta-error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }

        /* Paleta visual para mensajes informativos o de carga. */
        .alerta-exito {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }



        /* Distribuye la etiqueta y el valor de cada dato del pedido. */
        .filaPedido {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        /* Evita una línea inferior al final de la lista de datos. */
        .filaPedido:last-child {
            border-bottom: none;
        }

        /* Diferencia visualmente el nombre de cada campo. */
        .etiqueta {
            font-weight: 600;
            color: #666;
        }

        /* Color aplicado al valor mostrado para cada campo. */
        .valor {
            color: #333;
        }

        /* Apariencia común de la etiqueta que muestra el estado del pedido. */
        .estadoBadge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }

        /* Colores para pedidos pendientes. */
        .estadoBadge.pendiente {
            background: #fff3cd;
            color: #856404;
        }

        /* Colores para pedidos completados. */
        .estadoBadge.completado {
            background: #d4edda;
            color: #155724;
        }

    </style>

</head>

<body>
<!-- Inserta el encabezado compartido de la tienda. -->
<?php include("../includes/header.php");?>
  

<!-- Contiene las búsquedas y la acción para generar pedidos. -->
<div class="zonaTienda">

    <!-- Buscador del estado de un pedido mediante su número de identificación. -->
    <div class="seccionBuscador">
        <h3>
            <i class="fa-solid fa-receipt"></i>
            Consultar Estado de Pedido
        </h3>

        <div class="buscadorPedido">
            <input
                <!-- Solo se aceptan identificadores numéricos positivos. -->
                type="number"
                id="numeroPedidoConsulta"
                placeholder="Ingresa el número de tu pedido..."
                autocomplete="off"
                min="1">

            <!-- El script de esta página enlaza el botón con la consulta AJAX. -->
            <button class="btnConsultarPedido" id="btnConsultarPedido">
                <i class="fa-solid fa-magnifying-glass"></i>
                Consultar
            </button>
        </div>

        <!-- El resultadoPedido se completa dinámicamente con la respuesta del servidor. -->
        <div id="resultadoPedido"></div>
    </div>

    <!-- Buscador de productos usado por el catálogo de la tienda. -->
    <div class="seccionBuscador">
        <h3>
            <i class="fa-solid fa-search"></i>
            Buscar Productos
        </h3>

        <div class="busqueda">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="buscar"
                placeholder="Buscar producto..."
                autocomplete="off">

        </div>
    </div>

    <!-- Inicia el flujo para crear un pedido con los productos seleccionados. -->
    <button id="generarPedido">

        <i class="fa-solid fa-file-circle-plus"></i>

        <span>Generar Pedido</span>

    </button>

</div>


<!-- Botón flotante para abrir el carrito; el contador se actualiza desde JavaScript. -->
<button id="carritoIcono" title="Abrir carrito">

    <i class="fa-solid fa-bag-shopping"></i>

    <span id="cantidadCarrito">0</span>

</button>


    <!-- Zona principal en la que se presenta el catálogo de productos. -->
    <main>

        <h2 class="titulo">
            Productos Disponibles
        </h2>

        <!-- productos.js carga aquí los productos disponibles. -->
        <section id="productos">

        </section>

    </main>

    <!-- Capa de fondo asociada a la apertura del carrito lateral. -->
    <div id="fondo"></div>


    <!-- Panel lateral que muestra el contenido y las acciones del carrito. -->
    <aside id="sidebar">

        <div class="sidebarHeader">

            <h2>🛒 Mi Carrito</h2>

            <button id="cerrarCarrito">✖</button>

        </div>

        <!-- carrito.js inserta aquí las líneas del carrito. -->
        <div id="contenidoCarrito">

        </div>

        <!-- Resumen del total y botones para vaciar o comprar. -->
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
 

<!-- Formulario modal con los datos que se requieren para finalizar la compra. -->
<form id="valiindex">
<div id="modalCompra" class="modal">

    <div class="modalContenido">

        <h2>🛍 Finalizar Compra</h2>

         <!-- El nombre y teléfono se precargan con los datos guardados en la sesión. -->
         <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" value="<?= htmlspecialchars($nombreUsuario) ?>" required>

        <input type="text" id="telefono" name="telefono" placeholder="Teléfono" value="<?= htmlspecialchars($telefonoUsuario) ?>" required>

        <!-- Dirección de entrega solicitada al confirmar la compra. -->
        <input type="text" id="direccion" name="direccion" placeholder="Dirección"required value="">   

    

        <!-- El cliente debe seleccionar una de las opciones de pago disponibles. -->
        <select id="metodoPago" name="metodoPago">
            <option value="">Método de Pago</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Tarjeta">Tarjeta</option>
            <option value="QR">QR</option>
        </select>


        <div class="botonesModal">

            <button id="confirmarPedido" type="submit">
                Confirmar Compra
            </button>

            <button id="cancelarCompra" type="button">
                Cancelar
            </button>

        </div>

    </div>

</div>
</form>
    <!-- Configura la validación del formulario y la consulta asíncrona de pedidos. -->
    <script>
$(document).ready(function(){
    // Reglas y mensajes en español para validar los datos antes de confirmar la compra.
    $("#valiindex").validate({
        rules: {
            nombre: {
                required: true,
                minlength: 3
            },
            telefono: {
                required: true,
                digits: true,
                minlength: 8
            },
            direccion: {
                required: true,
                minlength: 5
            },
            metodoPago: {
                required: true
            }
        },
        messages: {
            nombre: {
                required: "Por favor, ingresa tu nombre.",
                minlength: "El nombre debe tener al menos 3 caracteres."
            },
            telefono: {
                required: "Por favor, ingresa tu número de teléfono.",
                digits: "El teléfono debe contener solo números.",
                minlength: "El teléfono debe tener al menos 8 dígitos."
            },
            direccion: {
                required: "Por favor, ingresa tu dirección.",
                minlength: "La dirección debe tener al menos 5 caracteres."
            },
            metodoPago: {
                required: "Por favor, selecciona un método de pago."
            }
        }
    });


    // Referencias a los elementos que participan en la consulta del pedido.
    const inputPedido = document.getElementById("numeroPedidoConsulta");
    const btnConsultar = document.getElementById("btnConsultarPedido");
    const divResultado = document.getElementById("resultadoPedido");

    // Valida el identificador, consulta al servidor y muestra el resultado recibido.
    function consultarPedido() {
        let id = inputPedido.value.trim();

        // No se envía una solicitud vacía; se muestra un aviso y se enfoca el campo.
        if (!id) {
            divResultado.innerHTML = `
                <div class="alerta alerta-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Por favor ingresa un número de pedido válido
                </div>
            `;
            inputPedido.focus();
            return;
        }

        // Evita consultas repetidas mientras el servidor procesa esta solicitud.
        btnConsultar.disabled = true;
        divResultado.innerHTML = `
            <div class="alerta alerta-exito">
                <div class="spinner"></div>
                Buscando pedido #${id}...
            </div>
        `;

        // Envía el número del pedido al endpoint PHP en formato de formulario URL-encoded.
        fetch("php/consultar_pedido.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + encodeURIComponent(id)
        })
        // Convierte el cuerpo de la respuesta HTTP a un objeto JavaScript.
        .then(res => res.json())
        .then(data => {
            // Una respuesta correcta incluye el pedido y sus campos para presentar.
            console.log("Respuesta:", data);

            if (data.ok && data.pedido) {
                // Conserva los datos del pedido y normaliza su estado para mostrarlo.
                let p = data.pedido;
                let estado = String(p.estado || 'Pendiente');

    
                // Selecciona una clase visual según el estado devuelto por el servidor.
                let estadoClase = "pendiente";
                if (estado.toLowerCase().includes("completado")) {
                    estadoClase = "completado";
                } else if (estado.toLowerCase().includes("proceso")) {
                    estadoClase = "proceso";
                }

                // Presenta en una tarjeta los datos principales del pedido localizado.
                divResultado.innerHTML = `
                    <div class="tarjetaPedido">
                        <h4>✅ Pedido Encontrado</h4>
                        
                        <div class="filaPedido">
                            <span class="etiqueta">Número:</span>
                            <span class="valor">#${p.id}</span>
                        </div>

                        <div class="filaPedido">
                            <span class="etiqueta">Cliente:</span>
                            <span class="valor">${p.nombre || 'N/A'}</span>
                        </div>

                        <div class="filaPedido">
                            <span class="etiqueta">Fecha:</span>
                            <span class="valor">${p.fecha || 'N/A'}</span>
                        </div>

                        <div class="filaPedido">
                            <span class="etiqueta">Estado:</span>
                            <span class="valor">
                                <span class="estadoBadge ${estadoClase}">
                                    ${estado}
                                </span>
                            </span>
                        </div>

                        <div class="filaPedido">
                            <span class="etiqueta">Vendedor:</span>
                            <span class="valor">${p.vendedor || 'Sin asignar'}</span>
                        </div>

                        <div class="filaPedido">
                            <span class="etiqueta">Método de Pago:</span>
                            <span class="valor">${p.metodoPago || 'N/A'}</span>
                        </div>

                        <div class="filaPedido">
                            <span class="etiqueta">Teléfono:</span>
                            <span class="valor">${p.telefono || 'N/A'}</span>
                        </div>

                        <div class="filaPedido">
                            <span class="etiqueta">Dirección:</span>
                            <span class="valor">${p.direccion || 'N/A'}</span>
                        </div>
                    </div>
                `;
            // Si la búsqueda no tuvo éxito, muestra el error informado por el servidor.
            } else {
                divResultado.innerHTML = `
                    <div class="alerta alerta-error">
                        <i class="fa-solid fa-circle-xmark"></i>
                        ${data.error || 'Pedido no encontrado'}
                    </div>
                `;
            }
        })
        // Informa un fallo de red o de lectura de respuesta con un mensaje para el usuario.
        .catch(error => {
            console.error("Error:", error);
            divResultado.innerHTML = `
                <div class="alerta alerta-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Error al consultar el pedido. Intenta nuevamente.
                </div>
            `;
        })
        // Reactiva el botón al terminar, independientemente del resultado de la consulta.
        .finally(() => {
            btnConsultar.disabled = false;
        });
    }

    // Permite iniciar la búsqueda tanto con el botón como con Enter en el campo.
    btnConsultar.addEventListener("click", consultarPedido);

    inputPedido.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            consultarPedido();
        }
    });
});
    </script>

<!-- Dependencias y módulos para alertas, catálogo, pedidos y gestión del carrito. -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/productos.js"></script>
<script src="js/pedido.js"></script>
<script src="js/carrito.js"></script>

</body>

</html>
