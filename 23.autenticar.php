<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conexion= new mysqli ($servidor, $usuario, $contra, $baseDeDatos);
if ($conexion-> error){ 
    echo"hubo un error";
}

$CI = $_POST['CI']; 
$direccion = $_POST['direccion'];
$rol = $_POST['rol'] ?? ''; 

$sql=" SELECT * FROM usuario
        WHERE CI ='$CI'
         AND direccion='$direccion'"; 
$resultado=$conexion->query($sql);
if ($resultado-> num_rows>0){ 
  $fila = $resultado->fetch_assoc(); 
session_start();


   $_SESSION ['CI']=$fila['CI'];
   $_SESSION['rol']=$fila['rol'];

 if($_SESSION['rol']=="vendedor"){ 

    header("Location:07.vendedor.php"); 
 }elseif ($_SESSION['rol'] == "administrador") {
        header("Location: 06.admin.php");
        exit();
    } else { 
                echo "Rol no reconocido.";
    }

} else {
    echo "Usuario o datos incorrectos";
}


?>