// Este archivo controla la lógica del pedido en la interfaz.
// Se encarga de abrir/cerrar el modal de compra, crear el pedido,
// mostrar mensajes al usuario y verificar si existe un pedido activo.

// Cuando la página termina de cargar, se ejecuta la comprobación del estado del pedido.
document.addEventListener("DOMContentLoaded",()=>{ 
 
    // Llama a la función que revisa si ya hay un pedido activo en curso.
    verificarEstadoPedido(); 
 
}); 
 
 
// Se abre el modal para completar la compra cuando el usuario hace clic en "Generar pedido".
document.getElementById("generarPedido").addEventListener("click",()=>{ 
 
    // Muestra el modal de compra usando Flex como modo de visualización.
    document 
    .getElementById("modalCompra") 
    .style.display="flex"; 
 
}); 
 
// Cierra el modal si el usuario decide cancelar la operación.
document.getElementById("cancelarCompra").addEventListener("click",()=>{ 
 
    // Oculta el modal de compra.
    document.getElementById("modalCompra") 
    .style.display="none"; 
 
}); 


// Al confirmar la compra, se envían los datos del cliente y del pedido al servidor.
document.getElementById("confirmarPedido").addEventListener("click",()=>{ 
       
// Objeto con la información que se enviará al backend para crear el pedido.
let datos = { 
 
    // Número de teléfono del cliente.
    telefono: document.getElementById("telefono").value, 
    // Dirección de entrega solicitada.
    direccion: document.getElementById("direccion").value, 
    // Método de pago seleccionado.
    metodoPago: document.getElementById("metodoPago").value 
}; 
 
 
 // Se realiza la petición al servidor para crear el pedido.
fetch("php/crear_pedido.php",{ 
 
    // Se indica que la petición es de tipo POST.
    method:"POST", 
 
    // Se envían los datos en formato JSON.
    headers:{ 
        "Content-Type":"application/json" 
    }, 
 
    // Se convierten los datos del formulario a texto JSON.
    body: JSON.stringify(datos) 
 
}) 
 
 // Primero se convierte la respuesta a un objeto JavaScript.
.then(res=>res.json()) 
 
 // La respuesta del servidor es analizada para saber si el pedido fue creado.
.then(data=>{ 
 
 
    // Se muestra la respuesta del servidor en la consola para depuración.
    console.log(data); 
 
 
    // Si el backend responde con éxito, se muestra un mensaje de confirmación.
    if(data.ok){ 
 
 
       // SweetAlert muestra una notificación de éxito con el número de pedido.
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
 
            // Una vez aceptado el mensaje, se redirige a la vista del pedido recién creado.
            window.location.href="index.php?id="+data.pedido; 
 
        });
 
 
    }else{ 
 
 
        // Si el backend respondió con un error, se muestra un mensaje de error.
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
 
 // Si ocurre un problema de red o el servidor falla, se muestra una alerta genérica.
.catch(error=>{ 
 
    // Se guarda el error en consola para depurar.
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

// Función que consulta al servidor si existe un pedido activo.
function verificarEstadoPedido(){ 
 
// Se realiza una petición simple sin enviar datos al backend.
fetch("php/verificar_pedido.php") 
.then(res=>res.json()) 
.then(data=>{ 
 
// Si la respuesta indica que hay un pedido activo, se guarda esa información.
if(data.pedidoActivo){ 
    // Esta variable global se usa para controlar el estado del pedido.
    pedidoActivo=true; 
} 
 
}) 
// En caso de error de red o de respuesta, se muestra el problema en consola.
.catch(error=>console.log(error)); 
}