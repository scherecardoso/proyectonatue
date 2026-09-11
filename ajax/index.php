<?php
session_start();
if (
    !isset($_SESSION['rol']) ||
    !in_array($_SESSION['rol'], ['usuario', 'vendedor'])
) {
    echo "Acceso denegado";
    exit();

}

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

    <!-- jQuery y jQuery Validate (necesarios para la validación del formulario) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <style>
        /* Estilos para el buscador de pedidos */
        .zonaBuscadores {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .seccionBuscador {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .seccionBuscador h3 {
            color: #333;
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .buscadorPedido {
            display: flex; gap: 10px; align-items: center; margin-right: 30%;
        }

        .buscadorPedido input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .buscadorPedido input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.2);
        }

        .btnConsultarPedido {
            padding: 12px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

        .btnConsultarPedido:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btnConsultarPedido:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        #resultadoPedido {
            margin-top: 15px;
            animation: slideIn 0.3s ease-in-out;
        }

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

        .alerta {
            padding: 15px;
            border-radius: 5px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alerta-error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }

        .alerta-exito {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        .tarjetaPedido {
            background: white;
            border-left: 5px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .tarjetaPedido h4 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .filaPedido {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        .filaPedido:last-child {
            border-bottom: none;
        }

        .etiqueta {
            font-weight: 600;
            color: #666;
        }

        .valor {
            color: #333;
        }

        .estadoBadge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
        }

        .estadoBadge.pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .estadoBadge.completado {
            background: #d4edda;
            color: #155724;
        }

        .estadoBadge.proceso {
            background: #cce5ff;
            color: #004085;
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

</head>

<body>
<?php include("../includes/header.php");?>
  

<!--================== ZONA DE TIENDA ==================-->

<div class="zonaTienda">

    <!-- BUSCADOR DE PEDIDOS -->
    <div class="seccionBuscador">
        <h3>
            <i class="fa-solid fa-receipt"></i>
            Consultar Estado de Pedido
        </h3>

        <div class="buscadorPedido">
            <input
                type="number"
                id="numeroPedidoConsulta"
                placeholder="Ingresa el número de tu pedido..."
                autocomplete="off"
                min="1">

            <button class="btnConsultarPedido" id="btnConsultarPedido">
                <i class="fa-solid fa-magnifying-glass"></i>
                Consultar
            </button>
        </div>

        <div id="resultadoPedido"></div>
    </div>

    <!-- BUSCADOR DE PRODUCTOS -->
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
<form id="valiindex">
<div  id="modalCompra" class="modal">

    <div class="modalContenido">

        <h2>🛍 Finalizar Compra</h2>

        <input type="text" id="nombre" name="nombre" placeholder="Nombre completo">

        <input type="text" id="telefono" name="telefono" placeholder="Teléfono">

        <input type="text" id="direccion" name="direccion" placeholder="Dirección">

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

</div>
</form>
    <script>
$(document).ready(function(){
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

    // ============================================
    // CONSULTAR PEDIDO
    // ============================================
    const inputPedido = document.getElementById("numeroPedidoConsulta");
    const btnConsultar = document.getElementById("btnConsultarPedido");
    const divResultado = document.getElementById("resultadoPedido");

    function consultarPedido() {
        let id = inputPedido.value.trim();

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

        // Mostrar carga
        btnConsultar.disabled = true;
        divResultado.innerHTML = `
            <div class="alerta alerta-exito">
                <div class="spinner"></div>
                Buscando pedido #${id}...
            </div>
        `;

        fetch("php/consultar_pedido.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + encodeURIComponent(id)
        })
        .then(res => res.json())
        .then(data => {
            console.log("Respuesta:", data);

            if (data.ok && data.pedido) {
                let p = data.pedido;

                // Determinar clase de estado
                let estadoClase = "pendiente";
                if (p.estado.toLowerCase().includes("completado")) {
                    estadoClase = "completado";
                } else if (p.estado.toLowerCase().includes("proceso")) {
                    estadoClase = "proceso";
                }

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
                                    ${p.estado || 'N/A'}
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
            } else {
                divResultado.innerHTML = `
                    <div class="alerta alerta-error">
                        <i class="fa-solid fa-circle-xmark"></i>
                        ${data.error || 'Pedido no encontrado'}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error("Error:", error);
            divResultado.innerHTML = `
                <div class="alerta alerta-error">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Error al consultar el pedido. Intenta nuevamente.
                </div>
            `;
        })
        .finally(() => {
            btnConsultar.disabled = false;
        });
    }

    // Evento click
    btnConsultar.addEventListener("click", consultarPedido);

    // Evento Enter
    inputPedido.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            consultarPedido();
        }
    });
});
    </script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/productos.js"></script>
<script src="js/pedido.js"></script>
<script src="js/carrito.js"></script>

</body>

</html>
