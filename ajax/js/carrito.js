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

<img src="../imagen/${producto.imagen}" width="80">


<h3>
${producto.nombre}
</h3>


<p>
Precio: Bs ${producto.precio}
</p>


<p>
Cantidad: ${cantidad}
</p>


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

    if(!confirm("¿Desea vaciar todo el carrito?")){
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

        }else{

            alert(datos.mensaje);

        }

    })

    .catch(error=>{

        console.log(error);

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


        alert(data.mensaje);

    }


});

    }


});
