document.addEventListener("DOMContentLoaded",()=>{ 
 
    verificarEstadoPedido(); 
 
}); 
 
 
//============================== 
// ABRIR FORMULARIO 
//============================== 
 

document.getElementById("generarPedido").addEventListener("click",()=>{ 
 
    document 
    .getElementById("modalCompra") 
    .style.display="flex"; 
 
}); 
 
//============================== 
// CERRAR FORMULARIO 
//============================== 
 
document.getElementById("cancelarCompra").addEventListener("click",()=>{ 
 
    document.getElementById("modalCompra") 
    .style.display="none"; 
 
}); 

//============================== 
// CONFIRMAR COMPRA 
//============================== 

document.getElementById("confirmarPedido").addEventListener("click",()=>{ 
       
 
let datos = { 
 
    telefono: document.getElementById("telefono").value, 
    direccion: document.getElementById("direccion").value, 
    metodoPago: document.getElementById("metodoPago").value 
}; 
 
 
 
fetch("php/crear_pedido.php",{ 
 
    method:"POST", 
 
    headers:{ 
        "Content-Type":"application/json" 
    }, 
 
    body: JSON.stringify(datos) 
 
}) 
 
 
.then(res=>res.json()) 
 
 
.then(data=>{ 
 
 
    console.log(data); 
 
 
    if(data.ok){ 
 
 
       Swal.fire({ 
            title: "¡Pedido creado!", 
            text: "Pedido Nº " + data.pedido + ". Ahora agregue los productos al carrito.", 
            icon: "success", 
            background: "#faf9f6", 
            color: "#4a4a4a", 
            confirmButtonColor: "#555555", 
            confirmButtonText: "Aceptar",
            customClass: {
                popup: "alertaPedido",
                title: "tituloAlerta",
                htmlContainer: "textoAlerta",
                confirmButton: "botonAlerta"
            }
        }).then(() => {
 
            window.location.href="index.php?id="+data.pedido; 
 
        });
 
 
    }else{ 
 
 
        Swal.fire({
            title: "No se pudo crear el pedido",
            text: data.mensaje,
            icon: "error",
            background: "#faf9f6",
            color: "#4a4a4a",
            confirmButtonColor: "#555555",
            confirmButtonText: "Aceptar",
            customClass: {
                popup: "alertaPedido",
                title: "tituloAlerta",
                htmlContainer: "textoAlerta",
                confirmButton: "botonAlerta"
            }
        });
 
 
    } 
 
 
}) 
 
 
.catch(error=>{ 
 
    console.log("Error:", error); 
 
    Swal.fire({
        title: "Ocurrió un error",
        text: "No se pudo conectar con el servidor.",
        icon: "error",
        background: "#faf9f6",
        color: "#4a4a4a",
        confirmButtonColor: "#555555",
        confirmButtonText: "Aceptar",
        customClass: {
            popup: "alertaPedido",
            title: "tituloAlerta",
            htmlContainer: "textoAlerta",
            confirmButton: "botonAlerta"
        }
    });
 
}); 
 
 
}); 

function verificarEstadoPedido(){ 
 
fetch("php/verificar_pedido.php") 
.then(res=>res.json()) 
.then(data=>{ 
 
if(data.pedidoActivo){ 
    pedidoActivo=true; 
} 
 
}) 
.catch(error=>console.log(error)); 
}