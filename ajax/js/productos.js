let listaProductos = [];
let pedidoActivo = false;


//==================================================
// INICIAR
//==================================================

document.addEventListener("DOMContentLoaded", function () {

    verificarPedido();

    // BUSCADOR
    const buscador = document.getElementById("buscar");

    if (buscador) {

        buscador.addEventListener("keyup", function () {

            buscarProductos(this.value);

        });

    }

});



//==================================================
// CARGAR PRODUCTOS
//==================================================

function cargarProductos(){

    fetch("php/obtener_productos.php")

    .then(respuesta => respuesta.json())

    .then(productos => {

        console.log("Productos cargados:", productos);

        listaProductos = productos;

        mostrarProductos(listaProductos);

    })

    .catch(error => {

        console.log("Error cargando productos:", error);

    });

}



//==================================================
// BUSCAR PRODUCTOS
//==================================================

function buscarProductos(texto){

    texto = texto.toLowerCase().trim();

    console.log("Buscando:", texto);

    if(texto === ""){

        mostrarProductos(listaProductos);

        return;

    }


    const resultados = listaProductos.filter(function(producto){

        const nombre = String(producto.nombre || "").toLowerCase();

        const descripcion = String(producto.descripcion || "").toLowerCase();

        return (
            nombre.includes(texto) ||
            descripcion.includes(texto)
        );

    });


    console.log("Resultados:", resultados);

    mostrarProductos(resultados);

}



//==================================================
// MOSTRAR PRODUCTOS
//==================================================

function mostrarProductos(productos){

    const contenedor = document.getElementById("productos");

    if(!contenedor){
        return;
    }


    let html = "";


    // SI NO HAY RESULTADOS
    if(productos.length === 0){

        contenedor.innerHTML = `

            <div class="sinResultados">

                <i class="fa-solid fa-magnifying-glass"></i>

                <h3>No encontramos ese producto</h3>

                <p>Prueba con otro nombre o descripción.</p>

            </div>

        `;

        return;

    }


    // MOSTRAR PRODUCTOS
    productos.forEach(function(producto){

        html += `

            <div class="tarjeta">

                <img
                    src="../img/${producto.imagen}"
                    alt="${producto.nombre}"
                >

                <h3>
                    ${producto.nombre}
                </h3>

                <p>
                    ${producto.descripcion}
                </p>

                <h2>
                    Bs ${producto.precio}
                </h2>

                <p>
                    Stock: ${producto.stock}
                </p>

                <button
                    class="btnAgregar"
                    data-codigo="${producto.codigo}"
                    ${pedidoActivo && Number(producto.stock)>0 ? "" : "disabled"}
                >

                    <i class="fa-solid fa-cart-plus"></i>

                    Agregar al carrito

                </button>

            </div>

        `;

    });


    contenedor.innerHTML = html;


    // VOLVER A ACTIVAR LOS BOTONES
    agregarEventos();

}



//==================================================
// EVENTOS BOTONES
//==================================================

function agregarEventos(){

    document.querySelectorAll(".btnAgregar").forEach(function(boton){

        boton.addEventListener("click", function(){

            agregarProducto(this.dataset.codigo);

        });

    });

}



//==================================================
// AGREGAR PRODUCTO
//==================================================

function agregarProducto(codigo){

    fetch("php/carrito.php", {

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"accion=agregar&codigo=" + codigo

    })

    .then(respuesta => respuesta.json())

    .then(datos => {

        console.log(datos);


        if(datos.ok){

            actualizarCarrito();

        }else{

            alert(datos.mensaje);

        }

    })

    .catch(error => {

        console.log("Error al agregar:", error);

    });

}



//==================================================
// HABILITAR COMPRA
//==================================================

function habilitarCompra(){

    pedidoActivo = true;


    document.querySelectorAll(".btnAgregar").forEach(function(boton){

        boton.disabled = false;

    });

}



//==================================================
// VERIFICAR PEDIDO
//==================================================

function verificarPedido(){

    fetch("php/verificar_pedido.php")

    .then(res => res.json())

    .then(datos => {

        console.log("Pedido:", datos);


        if(datos.pedidoActivo){

            pedidoActivo = true;

        }


        cargarProductos();

    })

    .catch(error => {

        console.log("Error verificando pedido:", error);

        // Aunque falle verificarPedido,
        // igual cargamos los productos
        cargarProductos();

    });

}