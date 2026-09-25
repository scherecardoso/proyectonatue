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
        imageUrl: "https://unsplash.it/400/200",
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: "Error de conexión",

        background: "#fff5f7",
        color: "#7a263a",
        confirmButtonColor: "#c94f68",
        confirmButtonText: "Aceptar",
    });
    </script>
    <style>
        .alertaRosa {
            border-radius: 22px !important;
            border: 2px solid #f2b6c2 !important;
            box-shadow: 0 8px 30px rgba(190, 70, 95, 0.20) !important;
        }
        .tituloRosa {
            color: #9e3049 !important;
            font-family: Arial, sans-serif !important;
        }
        .textoRosa {
            color: #7a4a54 !important;
            font-family: Arial, sans-serif !important;
        }
        .botonRosa {
            background-color: #c94f68 !important;
            border-radius: 10px !important;
            padding: 10px 25px !important;
            box-shadow: 0 4px 10px rgba(201, 79, 104, 0.25) !important;
        }
        .botonRosa:hover {
            background-color: #a93650 !important;
        }
    </style>
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
            imageUrl: "https://unsplash.it/400/200",
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: "Rol no reconocido",

            background: "#fff5f7",
            color: "#7a263a",
            confirmButtonColor: "#c94f68",
            confirmButtonText: "Aceptar",
        });
        </script>
        <style>
            .alertaRosa {
                border-radius: 22px !important;
                border: 2px solid #f2b6c2 !important;
                box-shadow: 0 8px 30px rgba(190, 70, 95, 0.20) !important;
            }
            .tituloRosa {
                color: #9e3049 !important;
                font-family: Arial, sans-serif !important;
            }
            .textoRosa {
                color: #7a4a54 !important;
                font-family: Arial, sans-serif !important;
            }
            .botonRosa {
                background-color: #c94f68 !important;
                border-radius: 10px !important;
                padding: 10px 25px !important;
                box-shadow: 0 4px 10px rgba(201, 79, 104, 0.25) !important;
            }
            .botonRosa:hover {
                background-color: #a93650 !important;
            }
        </style>
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
        imageURL: "https://unsplash.it/400/200",
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: "Datos incorrectos",

        background: "#fff1f4",
        color: "#7a263a",
        confirmButtonColor: "#c94f68",
        confirmButtonText: "Aceptar",
    });
    </script>
    <style>
        .alertaRoja {
            border-radius: 22px !important;
            border: 2px solid #ed9eae !important;
            box-shadow: 0 8px 30px rgba(190, 60, 85, 0.22) !important;
        }
        .tituloRojo {
            color: #a52f48 !important;
            font-family: Arial, sans-serif !important;
        }
        .textoRojo {
            color: #7a4a54 !important;
            font-family: Arial, sans-serif !important;
        }
        .botonRojo {
            background-color: #c94f68 !important;
            border-radius: 10px !important;
            padding: 10px 25px !important;
            box-shadow: 0 4px 10px rgba(201, 79, 104, 0.25) !important;
        }
        .botonRojo:hover {
            background-color: #a93650 !important;
        }
    </style>
    </body>
    </html>
    ';
}

$conn->close();
?>
