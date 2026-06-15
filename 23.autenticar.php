<?php
session_start();

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor,$usuario,$contra,$baseDeDatos);

if($conn->connect_error){
    die("Error de conexión: ".$conn->connect_error);
}

if(!isset($_POST['CI']) || !isset($_POST['direccion'])){
    header("Location:09.register.php?error=1");
    exit();
}

$CI = trim($_POST['CI']);
$direccion = trim($_POST['direccion']);

$stmt = $conn->prepare("SELECT * FROM usuario WHERE CI=? AND direccion=?");
$stmt->bind_param("ss",$CI,$direccion);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows>0){

    $fila=$resultado->fetch_assoc();

    $_SESSION['CI']=$fila['CI'];
    $_SESSION['rol']=$fila['rol'];

    if($fila['rol']=="administrador"){
        header("Location:06.admin.php");
        exit();
    }

    if($fila['rol']=="vendedor"){
        header("Location:07.vendedor.php");
        exit();
    }

    echo "Rol no reconocido";

}else{

    header("Location:09.register.php?error=1");
    exit();

}

$stmt->close();
$conn->close();
?>