document
.getElementById("consultar")
.addEventListener("click",()=>{


let id =
document.getElementById("numeroPedido").value;



fetch("php/consultar_pedido.php",{


method:"POST",


headers:{

"Content-Type":
"application/x-www-form-urlencoded"

},


body:
"id="+id


})


.then(res=>res.json())


.then(data=>{


console.log(data);



if(data.ok){


let p=data.pedido;



document.getElementById("resultado")
.innerHTML=`

<hr>

<h3>
Pedido Nº ${p.id}
</h3>


<p>
Cliente:
${p.nombre}
</p>


<p>
Fecha:
${p.fecha}
</p>


<p>
Estado:
<b>${p.estado}</b>
</p>


<p>
Vendedor:
${p.vendedor ?? "Pendiente"}
</p>

`;



}else{


document.getElementById("resultado")
.innerHTML=
"Pedido no encontrado";


}


});


});