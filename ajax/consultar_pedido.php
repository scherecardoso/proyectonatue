<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Pedido</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 100%;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            text-align: center;
            font-size: 28px;
        }

        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
            font-family: inherit;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.1);
        }

        .button-group {
            display: flex;
            gap: 10px;
        }

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

        button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        #resultado {
            margin-top: 30px;
            min-height: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        .pedido-card {
            background: #f5f5f5;
            border-left: 5px solid #667eea;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .pedido-card h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .pedido-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        .pedido-row:last-child {
            border-bottom: none;
        }

        .pedido-label {
            font-weight: 600;
            color: #666;
        }

        .pedido-valor {
            color: #333;
        }

        .estado-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        .estado-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .estado-completado {
            background: #d4edda;
            color: #155724;
        }

        .estado-proceso {
            background: #cce5ff;
            color: #004085;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
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
    <div class="container">
        <h1>🔍 Consultar Pedido</h1>
        <p class="subtitle">Ingresa tu número de pedido para ver el estado</p>

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

        <div class="button-group">
            <button id="consultar">Consultar Estado</button>
            <button id="limpiar" type="button">Limpiar</button>
        </div>

        <div id="resultado"></div>
    </div>

    <script>
        const inputPedido = document.getElementById("numeroPedido");
        const botonConsultar = document.getElementById("consultar");
        const botonLimpiar = document.getElementById("limpiar");
        const divResultado = document.getElementById("resultado");

        // Función para consultar pedido
        function consultarPedido() {
            let id = inputPedido.value.trim();

            if (!id) {
                divResultado.innerHTML = `
                    <div class="alert alert-error">
                        ⚠️ Por favor ingresa un número de pedido válido
                    </div>
                `;
                inputPedido.focus();
                return;
            }

            // Deshabilitar botón y mostrar carga
            botonConsultar.disabled = true;
            divResultado.innerHTML = `
                <div class="alert alert-success" style="background: #e3f2fd; color: #1565c0;">
                    <div class="loading"></div>
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
                    let estadoClase = "estado-pendiente";
                    if (p.estado.toLowerCase().includes("completado")) {
                        estadoClase = "estado-completado";
                    } else if (p.estado.toLowerCase().includes("proceso")) {
                        estadoClase = "estado-proceso";
                    }

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
                    divResultado.innerHTML = `
                        <div class="alert alert-error">
                            ❌ ${data.error || 'Pedido no encontrado'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error("Error:", error);
                divResultado.innerHTML = `
                    <div class="alert alert-error">
                        ❌ Error al consultar el pedido. Intenta nuevamente.
                    </div>
                `;
            })
            .finally(() => {
                botonConsultar.disabled = false;
            });
        }

        // Evento click en botón consultar
        botonConsultar.addEventListener("click", consultarPedido);

        // Evento Enter en input
        inputPedido.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                consultarPedido();
            }
        });

        // Botón limpiar
        botonLimpiar.addEventListener("click", () => {
            inputPedido.value = "";
            divResultado.innerHTML = "";
            inputPedido.focus();
        });

        // Focus al cargar
        inputPedido.focus();
    </script>
</body>

</html>