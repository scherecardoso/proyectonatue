<?php

require("conexion.php");


$id=$_POST["id"];


$sql="
SELECT *
FROM pedido
WHERE id='$id'
";


$resultado=$conn->query($sql);



if($resultado->num_rows>0){


$pedido=$resultado->fetch_assoc();



echo json_encode([

"ok"=>true,

"pedido"=>$pedido

]);


}else{


echo json_encode([

"ok"=>false

]);


}


?>