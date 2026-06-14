<?php

$direccion = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($direccion, $usuario, $contra, $baseDeDatos);

if ($conn->error) {
    echo "Error";
}

$sql = "SELECT * FROM usuario";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()){

        echo $fila['CI']."<br>".$fila['nombre']."<br>".$fila['direccion']."<br>".$fila['celular']."<br>".$fila['rol']."<br>".$fila['estado']."<br>";

        $CI = $fila['CI'];

        echo "<a href='12.readusuario.php'><button>Mostrar</button></a>";
        echo "<a href='14formeditarusuario.php'><button>Editar</button></a>";
        echo "<a href='16.eliminarusuario.php'><button>Eliminar</button></a>";

    }
}

$conn->close();

?>