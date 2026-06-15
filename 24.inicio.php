<?php
session_start();

if(!isset($_SESSION['CI'])){
    header("Location:09.register.php");
    exit();
}

$CI=$_SESSION['CI'];

$servidor="localhost";
$usuario="root";
$contra="";
$baseDeDatos="shena";

$conn=new mysqli($servidor,$usuario,$contra,$baseDeDatos);

if($conn->connect_error){
    die("Error de conexión");
}

$stmt=$conn->prepare("SELECT * FROM usuario WHERE CI=?");
$stmt->bind_param("s",$CI);

$stmt->execute();

$resultado=$stmt->get_result();

if($resultado->num_rows>0){

    $fila=$resultado->fetch_assoc();

    $_SESSION['datos']=array(

        "CI"=>$fila['CI'],
        "nombre"=>$fila['nombre'],
        "direccion"=>$fila['direccion'],
        "celular"=>$fila['celular'],
        "rol"=>$fila['rol'],
        "estado"=>$fila['estado']

    );

}

$stmt->close();
$conn->close();
?>