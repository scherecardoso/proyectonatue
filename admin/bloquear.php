<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}

if (isset($_GET['CI'])) {

    $CI = $_GET['CI'];

    $sql = "UPDATE usuario SET estado='bloqueado' WHERE CI=$CI";

    if ($conn->query($sql) === TRUE) {

        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Usuario bloqueado</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>

        <body>

        <script>
        Swal.fire({
            title: "Actualización exitosa",
            text: "El usuario fue bloqueado correctamente.",
            imageUrl: "../img/perrito-feliz.png",
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: "Perrito feliz",
            background: "#fff1f4",
            color: "#90ceb6",
            confirmButtonColor: "#75a18b",
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../usuario/12.readusuarios.php";
            }
        });
        </script>

        </body>
        </html>
        ';

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
            title: "Error",
            text: "No se pudo bloquear el usuario.",
            icon: "error",
            confirmButtonColor: "#75a18b",
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../usuario/12.readusuarios.php";
            }
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
        <title>Error</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>

    <script>
    Swal.fire({
        title: "Error",
        text: "No se recibió el CI del usuario.",
        icon: "error",
        confirmButtonColor: "#75a18b",
        confirmButtonText: "Aceptar"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../usuario/12.readusuarios.php";
        }
    });
    </script>

    </body>
    </html>
    ';
}

$conn->close();

?>