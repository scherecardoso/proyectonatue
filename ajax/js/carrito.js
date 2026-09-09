//==============================
// ABRIR CARRITO
//==============================
document.getElementById("carritoIcono")
.addEventListener("click",()=>{

    document.getElementById("sidebar")
    .classList.add("activo");

    document.getElementById("fondo")
    .classList.add("activo");

    actualizarCarrito();

});

//==============================
// CERRAR
//==============================

document.getElementById("cerrarCarrito")
.addEventListener("click",cerrarSidebar);

document.getElementById("fondo")
.addEventListener("click",cerrarSidebar);

function cerrarSidebar(){

    document.getElementById("sidebar")
    .classList.remove("activo");

    document.getElementById("fondo")
    .classList.remove("activo");

}

//==============================
// ACTUALIZAR CARRITO
//==============================

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

console.log(datos);

let html="";

let total = 0;

let cantidadTotal = 0;

datos.forEach(producto=>{

let subtotal = Number(producto.costototal);

let cantidad = Number(producto.cantidad);

total += subtotal;

cantidadTotal += cantidad;

html += `

<div class="productoCarrito">

<img src="../img/${producto.imagen}" width="80">

<h3>
${producto.nombre}
</h3>

<p>
Precio: Bs ${producto.precio}
</p>

<p>
Cantidad: ${cantidad}
</p>

<div>
<button onclick="cambiarCantidad('${producto.productos_codigo}','disminuir')">-</button>
<button onclick="cambiarCantidad('${producto.productos_codigo}','aumentar')">+</button>
</div>

<p>
Subtotal:
Bs ${subtotal}
</p>

</div>

`;

});

document.getElementById("contenidoCarrito")
.innerHTML = html;

document.getElementById("cantidadCarrito")
.innerHTML = cantidadTotal;

document.getElementById("totalCarrito")
.innerHTML = "Total: Bs " + total;

})

.catch(error=>{

console.log("Error carrito:",error);

});

}

//==============================
// VACIAR CARRITO
//==============================

document.getElementById("vaciarCarrito")
.addEventListener("click", vaciarCarrito);

function vaciarCarrito(){

    Swal.fire({
        title: "¿Vaciar carrito?",
        text: "Se eliminarán todos los productos del carrito.",
        icon: "warning",
        background: "#faf9f6",
        color: "#4a4a4a",
        showCancelButton: true,
        confirmButtonColor: "#555555",
        cancelButtonColor: "#b8b5ae",
        confirmButtonText: "Sí, vaciar",
        cancelButtonText: "Cancelar"
    }).then((resultado)=>{

        if(!resultado.isConfirmed){
            return;
        }

        fetch("php/carrito.php",{

            method:"POST",

            headers:{
                "Content-Type":"application/x-www-form-urlencoded"
            },

            body:"accion=vaciar"

        })

        .then(res=>res.json())

        .then(datos=>{

            if(datos.ok){

                actualizarCarrito();

                Swal.fire({
                    title: "Carrito vacío",
                    text: "Se eliminaron todos los productos.",
                    icon: "success",
                    background: "#faf9f6",
                    color: "#4a4a4a",
                    confirmButtonColor: "#555555",
                    confirmButtonText: "Aceptar"
                });

            }else{

                Swal.fire({
                    title: "No se pudo vaciar",
                    text: datos.mensaje,
                    icon: "error",
                    background: "#faf9f6",
                    color: "#4a4a4a",
                    confirmButtonColor: "#555555",
                    confirmButtonText: "Aceptar"
                });

            }

        })

        .catch(error=>{

            console.log(error);

        });

    });

}

document.addEventListener("click",function(e){

    if(e.target.id=="comprar"){

        fetch("php/finalizar_pedido.php")

        .then(res=>res.json())

        .then(data=>{

            if(data.ok){

                window.location.href="recibo.php";

            }else{

                Swal.fire({
                    title: "No se pudo finalizar",
                    text: data.mensaje,
                    icon: "error",
                    background: "#faf9f6",
                    color: "#4a4a4a",
                    confirmButtonColor: "#555555",
                    confirmButtonText: "Aceptar"
                });

            }

        });

    }

});

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

if(!data.ok && data.mensaje){

    Swal.fire({
        title: "No se puede realizar",
        text: data.mensaje,
        icon: "warning",
        background: "#faf9f6",
        color: "#4a4a4a",
        confirmButtonColor: "#555555",
        confirmButtonText: "Aceptar"
    });

}

actualizarCarrito();

});

}