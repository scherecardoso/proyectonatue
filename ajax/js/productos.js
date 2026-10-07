let listaProductos = [];
// Indica si el cliente puede agregar productos al carrito.
let pedidoActivo = false;



document.addEventListener("DOMContentLoaded", function () {

    // Comprueba primero si existe un pedido activo; después se cargarán los productos.
    verificarPedido();

    // Busca el campo de búsqueda en la página. Puede no existir en todas las vistas.
    const buscador = document.getElementById("buscar");

    if (buscador) {

        // Filtra la lista cada vez que el usuario escribe o borra texto.
        buscador.addEventListener("keyup", function () {

            buscarProductos(this.value);

        });

    }

});




function cargarProductos(){

    // Solicita al servidor el catálogo de productos en formato JSON.
    fetch("php/obtener_productos.php")

    .then(respuesta => respuesta.json())

    .then(productos => {

        // Conserva los datos recibidos para reutilizarlos al filtrar.
        console.log("Productos cargados:", productos);

        listaProductos = productos;

        mostrarProductos(listaProductos);

    })

    .catch(error => {

        // Registra cualquier error de red o de lectura de la respuesta.
        console.log("Error cargando productos:", error);

    });

}




function buscarProductos(texto){

    // Normaliza la consulta para que la búsqueda no distinga mayúsculas ni espacios extremos.
    texto = texto.toLowerCase().trim();

    console.log("Buscando:", texto);

    if(texto === ""){

        // Si no hay consulta, vuelve a mostrar el catálogo completo.
        mostrarProductos(listaProductos);

        return;

    }


    // Conserva los productos cuyo nombre o descripción contiene el texto buscado.
    const resultados = listaProductos.filter(function(producto){

        // Convierte los valores a texto y minúsculas; así se evitan errores con valores vacíos.
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



function mostrarProductos(productos){

    // Contenedor donde se dibujan las tarjetas del catálogo.
    const contenedor = document.getElementById("productos");

    // No intenta actualizar la página si esta vista no contiene el catálogo.
    if(!contenedor){
        return;
    }


    // Se arma el contenido HTML antes de insertarlo en el documento.
    let html = "";


    if(productos.length === 0){

        // Muestra un aviso cuando la búsqueda no encuentra coincidencias o no hay productos.
        contenedor.innerHTML = `

            <div class="sinResultados">

                <i class="fa-solid fa-magnifying-glass"></i>

                <h3>No encontramos ese producto</h3>

                <p>Prueba con otro nombre o descripción.</p>

            </div>

        `;

        return;

    }


    // Crea una tarjeta con los datos de cada producto recibido.
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
                    <!-- El botón solo se activa con un pedido abierto y stock disponible. -->
                    ${pedidoActivo && Number(producto.stock)>0 ? "" : "disabled"}
                >

                    <i class="fa-solid fa-cart-plus"></i>

                    Agregar al carrito

                </button>

            </div>

        `;

    });


    // Reemplaza el contenido anterior por las tarjetas recién generadas.
    contenedor.innerHTML = html;


    // Conecta los botones creados dinámicamente con su acción de agregar.
    agregarEventos();

}




function agregarEventos(){

    // Asigna un evento a cada botón visible del catálogo.
    document.querySelectorAll(".btnAgregar").forEach(function(boton){

        boton.addEventListener("click", function(){

            // El código del producto viaja en el atributo data-codigo del botón.
            agregarProducto(this.dataset.codigo);

        });

    });

}



function agregarProducto(codigo){

    // Envía al servidor la acción y el código del producto mediante POST.
    fetch("php/carrito.php", {

        method:"POST",

        headers:{
            "Content-Type":"application/x-www-form-urlencoded"
        },

        body:"accion=agregar&codigo=" + codigo

    })


    .then(respuesta => respuesta.json())

    .then(datos => {

        // Revisa la respuesta del servidor para confirmar si se agregó correctamente.
        console.log(datos);


        if(datos.ok){

            // Refresca la información del carrito si la operación fue exitosa.
            actualizarCarrito();

        }else{

            // Informa al usuario el motivo por el que no se pudo agregar el producto.
            Swal.fire({
                title: "No se pudo agregar",
                text: datos.mensaje,
                icon: "error",
                background: "#faf9f6",
                color: "#4a4a4a",
                confirmButtonColor: "#555555",
                confirmButtonText: "Aceptar"
            });

        }

    })

    .catch(error => {

        // Registra errores de comunicación o al procesar la respuesta del carrito.
        console.log("Error al agregar:", error);

    });

}


function habilitarCompra(){

    // Marca el pedido como activo y habilita los botones de agregar.
    pedidoActivo = true;


    document.querySelectorAll(".btnAgregar").forEach(function(boton){

        boton.disabled = false;

    });

}



function verificarPedido(){

    // Consulta al servidor si hay un pedido activo antes de mostrar el catálogo.
    fetch("php/verificar_pedido.php")

    .then(res => res.json())

    .then(datos => {

        // Guarda el estado recibido para que las tarjetas habiliten o deshabiliten sus botones.
        console.log("Pedido:", datos);


        if(datos.pedidoActivo){

            pedidoActivo = true;

        }


        // Carga los productos después de conocer el estado del pedido.
        cargarProductos();

    })

    .catch(error => {

        // Aunque falle la consulta del pedido, se intenta mostrar el catálogo.
        console.log("Error verificando pedido:", error);

        cargarProductos();

    });

}