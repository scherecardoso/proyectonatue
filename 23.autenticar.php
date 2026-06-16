<?php
$servidor ="localhost";
$usuario ="root";
$contra ="";
$baseDeDatos ="shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$CI = $_POST['CI']; // a partir de aqui se crea una variable para asignarle un valor mediante POST (la variable ci tendra el valor del registro que se ingreso en e campo ci -> se obtiene del form)
$direccion = $_POST['direccion'];
$rol = $_POST['rol'] ?? ''; // "??" operador de fusión nula, verifica que la variable exista y no sea nula

$sql=" SELECT * FROM usuario 
        WHERE CI ='$CI'
         AND direccion='$direccion'"; //consulta sql que busca los camos en la BD
$resultado=$conn->query($sql);// se crea una variable resultado la cual establece que la conexion debe tener como requisito (query) el sql (de mi bd saca los parametros sql)
if ($resultado-> num_rows>0){ // condicion, si mi resultado es mayor a 0 
  $fila = $resultado->fetch_assoc(); //Toma los datos del usuario que encontramos en la base de datos y conviértelos en una lista ordenada (un array) para que PHP los pueda entender y usar.
  //fetch_assoc(): Es una función interna de PHP.
  //  Su trabajo exacto es ir a $resultado, agarrar la fila del usuario y transformarla en un array asociativo (una lista donde cada dato se busca por el nombre de su columna, como ['nombre'] o ['CI']).
session_start(); // de hecho siempre va al inicio del docu asi que nose q se quede

 //guardar datos en la sesion
   $_SESSION ['CI']=$fila['CI']; // $_SESSION es una varible global que funciona como array guardando la informacion del usuario con $fila (que en un paso anterior busca esa fila exacta en la BD), bajo el nombre de ['CI'] 
   $_SESSION ['direccion']=$fila['direccion'];
   $_SESSION['rol']=$fila['rol'];

 if($_SESSION['rol']=="vendedor"){ //redirecciones

    header("Location:07.vendedor.php"); 
  exit(); // Detiene la ejecución del script tras redireccionar
 }elseif ($_SESSION['rol'] == "administrador") {
        header("Location: 06.admin.php");
        exit();
    } else { // aunque se puede eliminar dice que este else funciona como una manera de proteger el panel de intrusos
        echo "Rol no reconocido.";
    }

} else {
    // Este 'else' pertenece al 'if ($resultado->num_rows > 0)'
    echo "Usuario o datos incorrectos";
}


?>