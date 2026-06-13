<?php
$direccion="localhost";
$usuario="root";
$contra="";
$baseDeDatos="shena";

$conn = new mysqli($direccion, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "No se conecto a la base de datos."
}

$CI=$_POST['CI']:
$sql= "SELECT * FROM usuario WHERE CI='$CI'"; 
$resultado= $conn->query($sql);
if ($resultado->num_rows>0){
    while($fila=$resultado->fetch_assoc()){
        echo $fila['CI']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado'];
    }
}
?>