<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

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

$CI = $_POST['CI'];
$direccion = $_POST['direccion'];

$sql = "SELECT * FROM usuario
        WHERE CI='$CI'
        AND direccion='$direccion'";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    session_start();

    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['direccion'] = $fila['direccion'];
    $_SESSION['celular'] = $fila['celular'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];
    $_SESSION['fecha'] = $fila['fecha'];

    if ($_SESSION['estado'] == "bloqueado") {

        header("Location: ../admin/verbloqueo.php");
        exit();
    }

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
$conn->close();

?>