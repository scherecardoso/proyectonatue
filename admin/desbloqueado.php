<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Error de conexión");
}
$CI = $_GET['CI'];

$sql = "UPDATE usuario SET estado='activo' WHERE CI=$CI";

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
            if (result.isConfirmed) {
                window.location.href = "../usuario/12.readusuarios.php"; 
            }
        });

        </script>

        </body>
        </html>
        ';
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

?>