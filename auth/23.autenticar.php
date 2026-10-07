<?php
// Configuración de acceso a la base de datos del proyecto.
// Estos valores se utilizan para establecer la conexión con MySQL.

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se crea la conexión a la base de datos donde están registrados los usuarios.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se muestra una alerta y se detiene el script,
// porque no se pueden validar las credenciales sin consultar la base de datos.
if ($conn->connect_error) {

    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Error</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
    <script>
    Swal.fire({
        title: "Error de conexión",
        text: "No se pudo conectar con la base de datos.",
        imageUrl: "../img/perrito-triste.gif",
        imageWidth: 200,
        imageHeight: 200,
        imageAlt: "Perrito triste",
        background: "#fff5f7",
        color: "#7a263a",
        confirmButtonColor: "#c94f68",
        confirmButtonText: "Aceptar"
    });
    </script>
    </body>
    </html>
    ';

    exit();
}

// Se reciben los datos enviados por el formulario de inicio de sesión.
$CI = $_POST['CI'];
$direccion = $_POST['direccion'];

// Se consulta la tabla usuario para buscar un registro que coincida
// tanto con el CI como con la dirección ingresada.
$sql = "SELECT * FROM usuario
        WHERE CI='$CI'
        AND direccion='$direccion'";

$resultado = $conn->query($sql);

// Si se encontró un usuario con esos datos, se prepara su sesión.
if ($resultado->num_rows > 0) {

    // Se obtienen los datos del usuario encontrado en la consulta.
    $fila = $resultado->fetch_assoc();

    // Se inicia la sesión y se guardan sus datos para utilizarlos en otras páginas.
    session_start();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['direccion'] = $fila['direccion'];
    $_SESSION['celular'] = $fila['celular'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];
    $_SESSION['fecha'] = $fila['fecha'];

    // Si la cuenta está bloqueada, se dirige al usuario a la página informativa.
    if ($_SESSION['estado'] == "bloqueado") {

        header("Location: ../admin/verbloqueo.php");
        exit();
    }

    // Se redirige a cada usuario al panel que corresponde a su rol.
    if ($_SESSION['rol'] == "vendedor") {

        header("Location: ../vendedor/07.vendedor.php");
        exit();

    } elseif ($_SESSION['rol'] == "administrador") {

        header("Location: ../admin/06.admin.php");
        exit();

    } elseif ($_SESSION['rol'] == "usuario") {

        header("Location: ../usuario/08.usuario.php");
        exit();

    } else {

        // Se muestra un aviso si el rol guardado no es uno de los reconocidos.
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Error</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
        <script>
        Swal.fire({
            title: "Rol no reconocido",
            text: "El rol del usuario no es válido.",
            imageUrl: "../img/perrito-triste.gif",
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: "Perrito triste",
            background: "#fff5f7",
            color: "#7a263a",
            confirmButtonColor: "#c94f68",
            confirmButtonText: "Aceptar"
        });
        </script>
        </body>
        </html>
        ';
    }

} else {

    // Si no hay coincidencias, se informa que los datos ingresados no son válidos.
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Datos incorrectos</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
    <script>
    Swal.fire({
        title: "Datos incorrectos",
        text: "El usuario o los datos ingresados no son correctos.",
        imageUrl: "../img/perrito-triste.gif",
        imageWidth: 200,
        imageHeight: 200,
        imageAlt: "Perrito triste",
        background: "#fff1f4",
        color: "#7a263a",
        confirmButtonColor: "#c94f68",
        confirmButtonText: "Aceptar"
    });
    </script>

    </body>
    </html>
    ';
}

// Se cierra la conexión con la base de datos al finalizar el proceso.
$conn->close();

?>