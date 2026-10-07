<?php

// Configuración de la conexión a la base de datos.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se crea la conexión con la base de datos.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Verifica si ocurrió un error al conectar.
if ($conn->connect_error) {
    die("Error de conexión");
}

// Se obtiene la cédula del usuario que se va a modificar.
$CI = $_GET['CI'];

// Consulta para cambiar el rol del usuario a "usuario".
$sql = "UPDATE usuario SET rol='usuario' WHERE CI=$CI";

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
        Swal.fire({
            title: "Actualización exitosa",
            text: "El rol fue cambiado exitosamente.",
            imageUrl: "../img/perrito-felizz.jpg",
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
} else {
    // Si hubo un error en la actualización, se muestra el mensaje de error.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cierra la conexión con la base de datos.
$conn->close();

?>