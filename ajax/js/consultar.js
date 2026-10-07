// Este archivo controla la consulta del estado de un pedido desde la interfaz.
// Se ejecuta cuando el usuario hace clic en el botón "Consultar Estado" o presiona Enter.
// La idea principal es: leer el número ingresado, validarlo, enviarlo al servidor,
// y luego mostrar el resultado en el contenedor "resultado" sin recargar la página.

// Aquí se captura el evento click del botón que dispara la búsqueda.
// El código dentro de esta función se ejecuta cada vez que el usuario consulta un pedido.
document.getElementById("consultar").addEventListener("click", () => {
    
    // Leemos el valor del input de pedido, lo limpiamos para evitar espacios vacíos,
    // y lo guardamos en una variable para usarlo después en la petición AJAX.
    let id = document.getElementById("numeroPedido").value.trim();
    
    // Validación básica: si el campo está vacío, mostramos un mensaje claro y salimos.
    // Esto evita enviar una petición innecesaria con un valor nulo o en blanco.
    if (!id) {
        document.getElementById("resultado").innerHTML = 
            '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 4px;">❌ Por favor ingresa un número de pedido</div>';
        return;
    }
    
    // Guardamos una referencia al botón para poder deshabilitarlo mientras se realiza la búsqueda.
    // Esto evita que el usuario haga múltiples consultas a la vez y mejora la experiencia.
    const boton = document.getElementById("consultar");
    boton.disabled = true;
    boton.textContent = "Buscando...";
    
    // Se hace una petición POST al archivo PHP encargado de consultar el pedido.
    // En el cuerpo se envía el identificador con encodeURIComponent para evitar errores
    // si el número o los datos incluyen caracteres especiales.
    fetch("php/consultar_pedido.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + encodeURIComponent(id)
    })
    // Si la respuesta llega correctamente, se convierte a JSON para poder leerla.
    .then(res => res.json())
    // Aquí se procesa la respuesta del backend.
    .then(data => {
        // Se imprime en consola para facilitar la depuración durante el desarrollo.
        console.log(data);
        
        // Si el servidor responde con ok = true, significa que encontró el pedido.
        // Se extrae el objeto pedido y se dibuja la información en pantalla.
        if (data.ok) {
            let p = data.pedido;
            
            // Se inserta HTML dinámico con los datos del pedido.
            // Se muestra en un bloque estilizado con colores verdes para indicar éxito.
            document.getElementById("resultado").innerHTML = `
                <div style="background: #e8f5e9; padding: 15px; border-left: 4px solid #4CAF50; border-radius: 4px;">
                    <h3>✅ Pedido Nº ${p.id}</h3>
                    
                    <p><strong>Cliente:</strong> ${p.nombre}</p>
                    
                    <p><strong>Fecha:</strong> ${p.fecha}</p>
                    
                    <p><strong>Estado:</strong> <b style="color: #2e7d32;">${p.estado}</b></p>
                    
                    <p><strong>Vendedor:</strong> ${p.vendedor ?? "Pendiente"}</p>
                    
                    <p><strong>Método de Pago:</strong> ${p.metodoPago ?? "Pendiente"}</p>
                    
                    <p><strong>Teléfono:</strong> ${p.telefono ?? "N/A"}</p>
                    
                    <p><strong>Dirección:</strong> ${p.direccion ?? "N/A"}</p>
                </div>
            `;
        } else {
            // Si el servidor devuelve ok = false, se muestra el mensaje de error que venga
            // desde PHP o un texto por defecto si no se envió alguno.
            document.getElementById("resultado").innerHTML = 
                `<div style="color: #d32f2f; padding: 10px; background: #ffebee; border-radius: 4px;">❌ ${data.error || "Pedido no encontrado"}</div>`;
        }
    })
    // Captura cualquier error que ocurra durante la petición o la lectura del JSON.
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("resultado").innerHTML = 
            '<div style="color: #d32f2f; padding: 10px; background: #ffebee; border-radius: 4px;">❌ Error en la búsqueda. Intenta nuevamente.</div>';
    })
    // finally se ejecuta siempre, tanto si la solicitud tuvo éxito como si falló.
    // Aquí se reactivan los controles del botón para que el usuario pueda consultar otra vez.
    .finally(() => {
    
        boton.disabled = false;
        boton.textContent = "Consultar Estado";
    });
});

// Este bloque permite iniciar la búsqueda también al pulsar Enter dentro del input.
// Es útil porque muchas personas esperan usar el teclado en vez del mouse.
document.getElementById("numeroPedido").addEventListener("keypress", (e) => {
    // Cuando la tecla presionada es Enter, simulamos un click en el botón de consulta.
    if (e.key === "Enter") {
        document.getElementById("consultar").click();
    }
});