<!-- Documento de consulta para que el cliente pueda revisar el estado de un pedido. -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Pedido</title>
    <style>
        /* Reinicia los espacios y facilita controlar el tamaño de todos los elementos. */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Centra el panel en la ventana y aplica el fondo degradado de la página. */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Panel principal que agrupa el formulario y los resultados de la consulta. */
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        /* Presentación del título principal. */
        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
            font-size: 28px;
        }

        /* Texto de ayuda que explica qué dato debe ingresar el usuario. */
        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        /* Espaciado del grupo de entrada. */
        .form-group {
            margin-bottom: 20px;
        }

        /* Estilo de la etiqueta del número de pedido. */
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        /* Apariencia del campo numérico para ingresar el identificador. */
        input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        /* Resalta el campo cuando el usuario lo selecciona. */
        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
        }

        /* Distribuye en una fila los botones disponibles. */
        .button-group {
            display: flex;
            gap: 10px;
        }

        /* Estilo común de los botones de consulta y limpieza. */
        button {
            flex: 1;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: inherit;
        }

        /* Efecto al pasar el cursor por encima de un botón habilitado. */
        button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        /* Indica que el botón no puede usarse mientras se procesa la búsqueda. */
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Área dinámica donde se muestran avisos y datos del pedido. */
        #resultado {
            margin-top: 30px;
            min-height: 20px;
        }

        /* Estilo compartido por los mensajes mostrados al usuario. */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Colores para errores o pedidos que no se encontraron. */
        .alert-error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }

        /* Colores para mensajes informativos positivos y de carga. */
        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        /* Tarjeta que organiza la información del pedido encontrado. */
        .pedido-card {
            background: #f5f5f5;
            border-left: 5px solid #667eea;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        /* Estilo del encabezado de la tarjeta del pedido. */
        .pedido-card h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 20px;
        }

        /* Fila individual con la etiqueta y el valor de cada dato. */
        .pedido-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        /* La última fila no necesita una línea divisoria inferior. */
        .pedido-row:last-child {
            border-bottom: none;
        }

        /* Destaca el nombre de cada dato dentro de la tarjeta. */
        .pedido-label {
            font-weight: 600;
            color: #666;
        }

        /* Color aplicado al valor correspondiente a cada etiqueta. */
        .pedido-valor {
            color: #333;
        }

        /* Estilo base para mostrar el estado del pedido como insignia. */
        .estado-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        /* Colores asociados a un pedido pendiente. */
        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        /* Colores asociados a un pedido completado. */
        .estado-completado {
            background: #d4edda;
            color: #155724;
        }

        /* Colores asociados a un pedido en proceso. */
        .estado-proceso {
            background: #cce5ff;
            color: #004085;
        }

        /* Indicador circular que comunica que la consulta está cargando. */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animación que hace girar el indicador de carga. */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <!-- Contenedor principal de la interfaz. -->
    <div class="container">
        <h1>🔍 Consultar Pedido</h1>
        <p class="subtitle">Ingresa tu número de pedido para ver el estado</p>

        <!-- Campo donde se introduce el número del pedido que se desea consultar. -->
        <div class="form-group">
            <label for="numeroPedido">Número de Pedido:</label>
            <input 
                type="number"
                id="numeroPedido"
                placeholder="Ej: 1, 2, 3..."
                min="1"
                autocomplete="off"
            >
        </div>

        <!-- Acciones para buscar el pedido o limpiar la consulta actual. -->
        <div class="button-group">
            <button id="consultar">Consultar Estado</button>
            <button id="limpiar" type="button">Limpiar</button>
        </div>

        <!-- JavaScript insertará aquí el indicador de carga, errores o datos encontrados. -->
        <div id="resultado"></div>
    </div>

    <script>
        // Referencias a los controles y al área en la que se muestran los resultados.
        const inputPedido = document.getElementById("numeroPedido");
        const botonConsultar = document.getElementById("consultar");
        const botonLimpiar = document.getElementById("limpiar");
        const divResultado = document.getElementById("resultado");

        // Valida el identificador, consulta el endpoint y presenta la respuesta recibida.
        function consultarPedido() {
            // Lee el valor ingresado y elimina espacios sobrantes en sus extremos.
            let id = inputPedido.value.trim();

            // Evita enviar una consulta vacía y solicita al usuario que complete el campo.
            if (!id) {
                divResultado.innerHTML = `
                    <div class="alert alert-error">
                        ⚠️ Por favor ingresa un número de pedido válido
                    </div>
                `;
                inputPedido.focus();
                return;
            }
            // Evita consultas repetidas mientras el servidor procesa la solicitud.
            botonConsultar.disabled = true;
            // Muestra una indicación inmediata de que la búsqueda está en curso.
            divResultado.innerHTML = `
                <div class="alert alert-success" style="background: #e3f2fd; color: #1565c0;">
                    <div class="loading"></div>
                    Buscando pedido #${id}...
                </div>
            `;

            // Envía el identificador en el cuerpo de una solicitud POST al endpoint PHP.
            fetch("php/consultar_pedido.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "id=" + encodeURIComponent(id)
            })
            // Convierte la respuesta del servidor desde JSON para poder leer sus propiedades.
            .then(res => res.json())
            .then(data => {
                // Muestra la respuesta en la consola, útil para revisar el resultado recibido.
                console.log("Respuesta:", data);

                // Continúa con la presentación detallada si el servidor encontró el pedido.
                if (data.ok && data.pedido) {
                    let p = data.pedido;

                    // Define la clase de color para la insignia según el estado informado.
                    let estadoClase = "estado-pendiente";
                    if (p.estado.toLowerCase().includes("completado")) {
                        estadoClase = "estado-completado";
                    } else if (p.estado.toLowerCase().includes("proceso")) {
                        estadoClase = "estado-proceso";
                    }

                    // Inserta en el área de resultados una tarjeta con los datos del pedido.
                    divResultado.innerHTML = `
                        <div class="pedido-card">
                            <h3>✅ Pedido Encontrado</h3>
                            
                            <div class="pedido-row">
                                <span class="pedido-label">Número de Pedido:</span>
                                <span class="pedido-valor">#${p.id}</span>
                            </div>

                            <div class="pedido-row">
                                <span class="pedido-label">Cliente:</span>
                                <span class="pedido-valor">${p.nombre || 'N/A'}</span>
                            </div>

                            <div class="pedido-row">
                                <span class="pedido-label">Fecha:</span>
                                <span class="pedido-valor">${p.fecha || 'N/A'}</span>
                            </div>

                            <div class="pedido-row">
                                <span class="pedido-label">Estado:</span>
                                <span class="pedido-valor">
                                    <span class="estado-badge ${estadoClase}">
                                        ${p.estado || 'N/A'}
                                    </span>
                                </span>
                            </div>

                            <div class="pedido-row">
                                <span class="pedido-label">Vendedor:</span>
                                <span class="pedido-valor">${p.vendedor || 'Sin asignar'}</span>
                            </div>

                            <div class="pedido-row">
                                <span class="pedido-label">Método de Pago:</span>
                                <span class="pedido-valor">${p.metodoPago || 'N/A'}</span>
                            </div>

                            <div class="pedido-row">
                                <span class="pedido-label">Teléfono:</span>
                                <span class="pedido-valor">${p.telefono || 'N/A'}</span>
                            </div>

                            <div class="pedido-row">
                                <span class="pedido-label">Dirección:</span>
                                <span class="pedido-valor">${p.direccion || 'N/A'}</span>
                            </div>
                        </div>
                    `;
                } else {
                    // Si la consulta no fue exitosa, presenta el error devuelto o un aviso general.
                    divResultado.innerHTML = `
                        <div class="alert alert-error">
                            ❌ ${data.error || 'Pedido no encontrado'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                // Atiende errores de conexión o problemas al procesar la respuesta del servidor.
                console.error("Error:", error);
                divResultado.innerHTML = `
                    <div class="alert alert-error">
                        ❌ Error al consultar el pedido. Intenta nuevamente.
                    </div>
                `;
            })
            .finally(() => {
                // Reactiva el botón al finalizar la solicitud, tanto si tuvo éxito como si falló.
                botonConsultar.disabled = false;
            });
        }

        // Permite iniciar la consulta haciendo clic en el botón principal.
        botonConsultar.addEventListener("click", consultarPedido);

        // También permite buscar desde el campo al presionar la tecla Enter.
        inputPedido.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                consultarPedido();
            }
        });
        // Limpia el número y los resultados para iniciar una consulta nueva.
        botonLimpiar.addEventListener("click", () => {
            inputPedido.value = "";
            divResultado.innerHTML = "";
            inputPedido.focus();
        });

        // Deja el cursor listo en el campo de entrada al abrir la página.
        inputPedido.focus();
    </script>
</body>

</html>