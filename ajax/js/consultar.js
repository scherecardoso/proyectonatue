document.getElementById("consultar").addEventListener("click", () => {
    
    let id = document.getElementById("numeroPedido").value.trim();
    
    // Validar que no esté vacío
    if (!id) {
        document.getElementById("resultado").innerHTML = 
            '<div style="color: red; padding: 10px; background: #ffebee; border-radius: 4px;">❌ Por favor ingresa un número de pedido</div>';
        return;
    }
    
    // Deshabilitar botón
    const boton = document.getElementById("consultar");
    boton.disabled = true;
    boton.textContent = "Buscando...";
    
    fetch("php/consultar_pedido.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id=" + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => {
        console.log(data);
        
        if (data.ok) {
            let p = data.pedido;
            
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
            document.getElementById("resultado").innerHTML = 
                `<div style="color: #d32f2f; padding: 10px; background: #ffebee; border-radius: 4px;">❌ ${data.error || "Pedido no encontrado"}</div>`;
        }
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("resultado").innerHTML = 
            '<div style="color: #d32f2f; padding: 10px; background: #ffebee; border-radius: 4px;">❌ Error en la búsqueda. Intenta nuevamente.</div>';
    })
    .finally(() => {
        // Re-habilitar botón
        boton.disabled = false;
        boton.textContent = "Consultar Estado";
    });
});

// Permitir buscar presionando Enter
document.getElementById("numeroPedido").addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
        document.getElementById("consultar").click();
    }
});