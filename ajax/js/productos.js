let listaProductos = [];
let pedidoActivo = false;
document.addEventListener("DOMContentLoaded", () => {
//esto crea una lista vacia donde despues sera cargada con los productos de la base de datos 

   
verificarPedido();
   //cargarProductos();
  

});

function cargarProductos(){
/*fetch() es una función de JavaScript que permite realizar peticiones HTTP al servidor.

En este caso envía una petición al archivo:*/
    fetch("php/obtener_productos.php")
/*Cuando el servidor responde, esa respuesta aún no es un objeto de JavaScript.

Es simplemente una respuesta HTTP. Es decir, transforma el JSON recibido en datos que JavaScript puede utilizar.*/ 
    .then(respuesta => respuesta.json())

    .then(productos => {

        listaProductos = productos;

        mostrarProductos(productos);

    })

    .catch(error => console.log(error));

}
function mostrarProductos(productos){

    let contenedor = document.getElementById("productos");

    let html = "";

    productos.forEach(producto=>{

        html += `
        <div class="tarjeta">

            <img src="img/productos/${producto.imagen}" alt="${producto.nombre}">

            <h3>${producto.nombre}</h3>

            <p>${producto.descripcion}</p>

            <h2>Bs ${producto.precio}</h2>

            <button
class="btnAgregar"
data-codigo="${producto.codigo}"
${pedidoActivo ? "" : "disabled"}>
Agregar al carrito
</button>


        </div>
        `;

    });

    contenedor.innerHTML = html;
// el boton agregar carrito ,Este fragmento es muy importante porque crea dinámicamente el botón "Agregar al carrito" y además decide si estará habilitado o deshabilitado según exista un pedido activo.
    // IMPORTANTE
    agregarEventos();

}
function agregarEventos(){

    document.querySelectorAll(".btnAgregar").forEach(boton=>{

        boton.addEventListener("click",()=>{

            agregarProducto(boton.dataset.codigo);

        });

    });

}
function agregarProducto(codigo){

    fetch("php/carrito.php",{

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"accion=agregar&codigo="+codigo

    })

    .then(respuesta => respuesta.json())

.then(datos=>{

    console.log(datos);

    if(datos.ok){

        actualizarCarrito();

    }else{

        alert(datos.mensaje);

    }

})
}
function habilitarCompra(){

    pedidoActivo = true;

    document.querySelectorAll(".btnAgregar")
    .forEach(boton=>{

        boton.disabled = false;

    });

}

function verificarPedido(){

    fetch("php/verificar_pedido.php")

    .then(res => res.json())

    .then(datos => {

        console.log("Pedido:",datos);

        if(datos.pedidoActivo){

            pedidoActivo = true;

        }

        cargarProductos();

    });

}