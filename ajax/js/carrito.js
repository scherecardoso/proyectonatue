
// Este archivo controla la lógica del carrito de compras en la vista del cliente.
// Aquí se gestionan la apertura/cierre del sidebar, la carga de productos, el vaciado
// del carrito, la actualización de cantidades y la finalización del pedido.

// Se crea un bloque de estilo para asegurar que los modales de SweetAlert queden
// siempre por encima de la capa de fondo y del sidebar del carrito.
const estiloSwal = document.createElement("style");

estiloSwal.innerHTML = `
.swal2-container {
    z-index: 99999 !important;
}
`;
document.head.appendChild(estiloSwal);

// Cuando el usuario hace clic en el ícono del carrito, se abre el panel lateral
// y se vuelve a consultar el contenido actual del carrito para reflejar los datos más recientes.
document.getElementById("carritoIcono")
.addEventListener("click",()=>{
    document.getElementById("sidebar")
    .classList.add("activo");

    document.getElementById("fondo")
    .classList.add("activo");

    actualizarCarrito();
});

// Se asigna la acción de cerrar el carrito tanto al botón de cierre como al fondo oscuro
// que cubre la página cuando el sidebar está abierto.
document.getElementById("cerrarCarrito")
.addEventListener("click",cerrarSidebar);

document.getElementById("fondo")
.addEventListener("click",cerrarSidebar);

// Esta función oculta el sidebar y elimina la capa de fondo para cerrar la vista del carrito.
function cerrarSidebar(){
    document.getElementById("sidebar")
    .classList.remove("activo");

    document.getElementById("fondo")
    .classList.remove("activo");
}


// Función principal para cargar el contenido del carrito desde el servidor.
// Se envia una petición POST a carrito.php con la acción "mostrar" para recuperar
// todos los productos agregados por el cliente.
function actualizarCarrito(){

fetch("php/carrito.php",{
    method:"POST",
    headers:{
        "Content-Type":"application/x-www-form-urlencoded"
    },
    body:"accion=mostrar"
})

.then(res=>res.json())

.then(datos=>{

    // Se deja este log como ayuda de depuración para revisar la respuesta del backend.
    console.log(datos);

    // Variables para construir el HTML del carrito y calcular totales.
    let html="";
    let total=0;
    let cantidadTotal=0;

    // Recorrer cada producto devuelto por la base de datos para crear su fila visual.
    datos.forEach(producto=>{

        // Se convierten a número para poder sumar correctamente precios y cantidades.
        let subtotal=Number(producto.costototal);
        let cantidad=Number(producto.cantidad);

        total += subtotal;
        cantidadTotal += cantidad;

        // Cada producto se renderiza con su imagen, nombre, precio, cantidad, botones
        // para modificarla y el subtotal correspondiente.
        html += `
        <div class="productoCarrito">

            <img src="../img/${producto.imagen}" width="80">

            <h3>${producto.nombre}</h3>

            <p>Precio: Bs ${producto.precio}</p>

            <p>Cantidad: ${cantidad}</p>

            <div>

                <button onclick="cambiarCantidad('${producto.productos_codigo}','disminuir')">
                    -
                </button>

                <button onclick="cambiarCantidad('${producto.productos_codigo}','aumentar')">
                    +
                </button>

            </div>

            <p>Subtotal: Bs ${subtotal}</p>

        </div>
        `;
    });

    // Se actualiza el contenido visible del carrito con el HTML recién generado.
    document.getElementById("contenidoCarrito").innerHTML=html;

    // Se actualiza la cantidad total de artículos y el monto final del pedido.
    document.getElementById("cantidadCarrito").innerHTML=cantidadTotal;

    document.getElementById("totalCarrito").innerHTML="Total: Bs "+total;

})

.catch(error=>{
    // Si ocurre algún fallo en la petición, se registra en consola para depuración.
    console.log("Error carrito:",error);
});

}

// Se activa el botón de vaciar carrito y se muestra una ventana de confirmación antes
// de borrar todos los productos del pedido.
document.getElementById("vaciarCarrito")
.addEventListener("click",vaciarCarrito);

// Esta función pide confirmación al usuario antes de vaciar el carrito por completo.
function vaciarCarrito(){
    Swal.fire({
        title:"¿Vaciar carrito?",
        text:"Se eliminarán todos los productos del carrito.",
        icon:"warning",
        background:"#faf9f6",
        color:"#4a4a4a",
        showCancelButton:true,
        confirmButtonColor:"#555555",
        cancelButtonColor:"#b8b5ae",
        confirmButtonText:"Sí, vaciar",
        cancelButtonText:"Cancelar"
    }).then((resultado)=>{
        // Si el usuario cancela, se termina la ejecución sin hacer cambios.
        if(!resultado.isConfirmed){
            return;
        }

        // Se envia la acción de vaciar al servidor para limpiar el carrito en la BD.
        fetch("php/carrito.php",{

            method:"POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:"accion=vaciar"

        })

        .then(res=>res.json())

        .then(datos=>{

            // Si la operación fue exitosa, se vuelve a cargar el carrito y se muestra un mensaje.
            if(datos.ok){

                actualizarCarrito();
                Swal.fire({
                    title:"Carrito vacío",
                    text:"Se eliminaron todos los productos.",
                    icon:"success",
                    background:"#faf9f6",
                    color:"#4a4a4a",
                    confirmButtonColor:"#555555",
                    confirmButtonText:"Aceptar"
                });

            }else{

                // Si hubo un problema, se informa al usuario con un mensaje de error.
                Swal.fire({
                    title:"No se pudo vaciar",
                    text:datos.mensaje,
                    icon:"error",
                    background:"#faf9f6",
                    color:"#4a4a4a",
                    confirmButtonColor:"#555555",
                    confirmButtonText:"Aceptar"
                });
            }
        })

        .catch(error=>{
            console.log(error);
        });

    });
}


// Se captura cualquier clic en la página para detectar si el botón de comprar fue presionado.
// Cuando esto ocurre, se solicita al backend que finalice el pedido y redirija a la vista del recibo.
document.addEventListener("click",function(e){

    if(e.target.id=="comprar"){

        fetch("php/finalizar_pedido.php")

        .then(res=>res.json())

        .then(data=>{

            // Si la operación es exitosa, se redirige al recibo del pedido.
            if(data.ok){

                window.location.href="recibo.php";

            }else{

                // Si hay un error, se muestra una alerta con el mensaje devuelto por el servidor.
                Swal.fire({
                    title:"No se pudo finalizar",
                    text:data.mensaje,
                    icon:"error",
                    background:"#faf9f6",
                    color:"#4a4a4a",
                    confirmButtonColor:"#555555",
                    confirmButtonText:"Aceptar"
                });
            }
        });
    }
});


// Función para aumentar o disminuir la cantidad de un producto específico dentro del carrito.
// Recibe el código del producto y la acción a ejecutar: "aumentar" o "disminuir".
function cambiarCantidad(codigo,accion){

    fetch("php/carrito.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"accion="+accion+"&codigo="+codigo

    })
    .then(res=>res.json())
    .then(data=>{
        // Si la operación no puede realizarse, se muestra una alerta informativa.
        if(!data.ok && data.mensaje){
            Swal.fire({
                title:"No se puede realizar",
                text:data.mensaje,
                icon:"warning",
                background:"#faf9f6",
                color:"#4a4a4a",
                confirmButtonColor:"#555555",
                confirmButtonText:"Aceptar"
            });
        }

        // En cualquier caso, se actualiza el carrito para reflejar el resultado final.
        actualizarCarrito();
    });
}