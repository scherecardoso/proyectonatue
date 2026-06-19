<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

$CI = $_POST["CI"];
$nombre = $_POST["nombre"];
$rol= $_POST["rol"];

$sql ="SELECT * FROM usuarios
        WERE CI=´$CI´
        AND nombre=´$nombre´
        AND rol=´$rol´ ";
$resultado =mysqli_query($conn,$sql);
if (mysqli_num_rows($resultado) > 0){
    $fila=mysqli_fetch_assoc($resultado);

    $_SESSION[´CI´]=$FILA[´CI´];
    $_SESSION[´nombre´]=$FILA[´nombre´];
    $_SESSION[´rol´]=$FILA[´rol´];
    $_SESSION[´estado´]=$FILA[´estado´];
    
}    if ($_SESSION[´rol´]==´vendedor´){

header("location")
}    