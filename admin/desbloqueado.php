<?php
// Inicia la sesión para mantener la autenticación del administrador.
session_start();

// Datos de conexión a la base de datos.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Crea la conexión con la base de datos.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Verifica si hubo un error al conectarse.
if ($conn->connect_error) {
    die("Error de conexión");
}

// Obtiene la cédula del usuario que se va a desbloquear.
$CI = $_GET['CI'];

// Actualiza el estado del usuario a activo.
$sql = "UPDATE usuario SET estado='activo' WHERE CI=$CI";

// Si la actualización fue exitosa, muestra un mensaje con SweetAlert.
if ($conn->query($sql) === TRUE) {
    echo'
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title></title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>

        <body>

        <script>
        // Muestra un mensaje de éxito cuando el usuario fue desbloqueado.
        Swal.fire({
            title: "Actualización exitosa",
            text: "El usuario fue desbloqueado correctamente.",
            imageUrl: "../img/perrito-feliz.png",
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: "Perrito feliz",
            background: "#fff1f4",
            color: "#767c80",
            confirmButtonColor: "#5e6466",
            confirmButtonText: "Aceptar"
         }).then((result) => {
            // Redirige a la vista de usuarios después de aceptar.
            if (result.isConfirmed) {
                window.location.href = "../usuario/12.readusuarios.php"; 
            }
        });

        </script>

        </body>
        </html>
        ';
} else {
    // Muestra el error si la actualización falló.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cierra la conexión a la base de datos.
$conn->close();

?>