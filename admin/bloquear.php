<?php

// Se configuran los datos para conectarse a la base de datos.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se crea la conexión con la base de datos.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se corta la ejecución del script.
if ($conn->connect_error) {
    die("Error de conexión");
}

// Se verifica si se recibió el CI del usuario por medio de la URL.
if (isset($_GET['CI'])) {

    // Se obtiene el CI enviado en la consulta.
    $CI = $_GET['CI'];

    // Se actualiza el estado del usuario a bloqueado.
    $sql = "UPDATE usuario SET estado='bloqueado' WHERE CI=$CI";

    // Si la actualización se ejecuta correctamente, se muestra una alerta de éxito.
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
            color: "#767c80",
            confirmButtonColor: "#5e6466",
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

    // Si la actualización falla, se muestra una alerta de error.
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
            confirmButtonColor: "#565a64",
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

// Si no se envió el CI, se avisa que faltan datos.
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
        confirmButtonColor: "#575763",
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

// Se cierra la conexión con la base de datos al finalizar.
$conn->close();

?>