<?php

// Datos de acceso a la base de datos local del proyecto.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se establece la conexión con MySQL usando la extensión MySQLi.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si no se pudo conectar, se detiene la página y se informa el motivo del error.
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Se obtiene desde la URL el CI del usuario que se desea editar.
// Este valor también se usa más abajo para identificar al usuario en la consulta.
$CI = $_GET['CI'];

// Se consulta la tabla usuario para buscar el registro cuyo CI coincide con el recibido.
// Nota: aquí el valor de CI se inserta directamente en la consulta SQL.
$sql = "SELECT * FROM usuario WHERE CI = $CI";
$resultado = $conn->query($sql);

// Si la consulta encontró al menos un registro, se leen sus datos.
if ($resultado->num_rows > 0) {
    // Se recorren las filas devueltas y se guardan los campos necesarios
    // en variables que se mostrarán después en el formulario de edición.
    while ($fila = $resultado->fetch_assoc()) {
        $nombre = $fila['nombre'];
        $direccion = $fila['direccion'];
        $celular = $fila['celular'];
        $rol = $fila['rol'];
        $estado = $fila['estado'];
    }
} else {
    // Se muestra este mensaje si no existe un usuario con el CI solicitado.
    echo "Usuario no encontrado";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f3f3f3;
    padding:40px;
}

h2{
    text-align:center;
    font-size:42px;
    color:#222;
    margin-bottom:30px;
}

form{
    width:550px;
    margin:0 auto;
    background:white;
    padding:40px;
    border-radius:25px;
    border:2px solid #f8c6e5;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}

input{
    width:100%;
    height:58px;
    padding:20px;
    margin-bottom:18px;
    border:1px solid #f5a3d5;
    border-radius:40px;
    background:#fafafa;
    color:#777;
    font-size:15px;
    outline:none;
}

input:focus{
    border-color:#f06ac3;
}

button{
    width:100%;
    padding:16px;
    border:1px solid #f34bb3;
    border-radius:40px;
    background:#f06ac3;
    color:white;
    font-size:17px;
    cursor:pointer;
    margin-top:10px;
    transition:0.3s;
}

button:hover{
    background:#f765c6;
    transform:scale(1.03);
}
select {
    width:100%;
    height:58px;
    color: #777;
    border:1px solid #f5a3d5;
    border-radius:40px;
    display:flex;
    align-items:center;
    padding:20px;
    margin-bottom:18px;
    background:#fafafa;
}
</style>
<body>

    
<?php include("../includes/header.php"); ?>
<form id="formeditarusuario" action="../usuario/14.actualizarusuario.php" method="post">
<h2>Editar Usuario</h2>
        <input type="hidden" name="CI" value="<?=$CI?>">
        <input type="text" name="nombre" value="<?=$nombre?>" placeholder="Nombre Completo" required>
        <input type="text" name="direccion" value="<?=$direccion?>" placeholder="Dirección" required>
        <input type="number" name="celular" value="<?=$celular?>" placeholder="Celular" required>
        <select name="rol" required>

        <option value="">Seleccione un rol</option>
        <option value="administrador">Administrador</option>
        <option value="vendedor">Vendedor</option>
        <option value="usuario">Usuario</option>

    </select>
        <input type="text" name="estado" value="<?=$estado?>" placeholder="Estado" required>
        <button type="submit">Actualizar Usuario</button>

    </form>
    <script>
$(document).ready(function(){

    $("#formeditarusuario").validate({

        rules:{
            CI:{
                required:true,
                minlength:3
            },
            nombre:{
                required:true,
                minlength:3
            },
            direccion:{
                required:true,
                minlength:5
            },
            celular:{
                required:true,
                digits:true
            },
            rol:{
                required:true
            },
            estado:{
                required:true
            }
        },

        messages:{
            CI:{
                required:"Debes ingresar un CI",
                minlength:"El CI debe tener al menos 3 caracteres"
            },
            nombre:{
                required:"Debes ingresar un nombre",
                minlength:"El nombre debe tener al menos 3 caracteres"
            },
            direccion:{
                required:"Debes ingresar una dirección",
                minlength:"La dirección debe tener al menos 5 caracteres"
            },
            celular:{
                required:"Debes ingresar un número de celular",
                digits:"Debes ingresar un número válido"
            },
            rol:{
                required:"Debes seleccionar un rol"
            },
            estado:{
                required:"Debes seleccionar un estado"
            }
        }

    });

});
</script>

</body>
</html>