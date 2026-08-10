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

        nombre: document.getElementById("nombre").value,
        telefono: document.getElementById("telefono").value,
        direccion: document.getElementById("direccion").value,
        metodo: document.getElementById("metodoPago").value,
    

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


        alert(
        "Pedido confirmado Nº "
        + data.pedido
        );


         window.location.href="index.php?id="+data.pedido;


    }else{


        alert(data.mensaje);


    }


})


.catch(error=>{

    console.log("Error:",error);

});


});
function verificarEstadoPedido(){


fetch("php/estado_pedido.php")


.then(res=>res.json())


.then(data=>{


if(data.ok){


let pedido=data.pedido;



if(pedido.Estado=="Pendiente"){



document.getElementById("formularioPedido").style.display="none";



document.getElementById("resumenPedido").style.display="block";



document.getElementById("datosPedido").innerHTML=`

<p>
Número pedido:
${pedido.id}
</p>


<p>
Cliente:
${pedido.Nombre}
</p>


<p>
Teléfono:
${pedido.telefono}
</p>


<p>
Dirección:
${pedido.direccion}
</p>


<p>
Método pago:
${pedido.metodoPago}
</p>


<p>
Estado:
Pendiente de aprobación
</p>


`;



}


}



});


}