<?php

// Datos de conexión a la base de datos.
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

// Se obtiene la cédula del usuario a modificar desde la URL.
$CI = $_GET['CI'];

// Consulta para cambiar el rol del usuario a vendedor.
$sql = "UPDATE usuario SET rol='vendedor' WHERE CI=$CI";

// Si la actualización se ejecuta correctamente, muestra un mensaje de éxito.
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
    // Si ocurre un error en la actualización, se muestra el detalle.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Se cierra la conexión con la base de datos.
$conn->close();

?>