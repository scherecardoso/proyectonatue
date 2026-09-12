<?php
session_start();

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor", "usuario"])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre_usuario = $_SESSION['nombre'] ?? '';
$rol = $_SESSION['rol'];

$carpetaImagenes = "../img/";

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {

    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));

    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

    if (in_array($extension, $extensionesPermitidas)) {

        if ($_FILES["imagen"]["size"] <= 5242880) {

            $nuevoNombre = "perfil-" . str_replace(" ", "_", $nombre_usuario) . "." . $extension;

            $rutaCompleta = $carpetaImagenes . $nuevoNombre;

            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta)) {

                $sql = "UPDATE usuario SET imagen_perfil=? WHERE nombre=?";

                $stmt = $conexion->prepare($sql);

                if ($stmt) {

                    $stmt->bind_param("ss", $nuevoNombre, $nombre_usuario);

                    if ($stmt->execute()) {

                        $stmt->close();
                        $conexion->close();

                        if ($rol == "administrador") {
                            header("Location: ../perfil/perfiladmin.php?success=1");
                        } elseif ($rol == "vendedor") {
                            header("Location: ../perfil/perfilvendedor.php?success=1");
                        } else {
                            header("Location: ../usuario/perfilUser.php?success=1");
                        }

                        exit();

                    } else {
                        $error = "Error al actualizar BD: " . $stmt->error;
                    }

                    $stmt->close();

                } else {
                    $error = "Error en la consulta: " . $conexion->error;
                }

            } else {
                $error = "Error al subir el archivo. Verifica permisos de carpeta.";
            }

        } else {
            $error = "El archivo es muy grande. Máximo 5MB.";
        }

    } else {
        $error = "Extensión no permitida. Solo: jpg, jpeg, png, gif, webp, avif";
    }

} else {
    $error = "No se seleccionó imagen";
}

$conexion->close();

if (isset($error)) {

    if ($rol == "administrador") {
        header("Location: ../perfil/perfiladmin.php?error=" . urlencode($error));
    } elseif ($rol == "vendedor") {
        header("Location: ../perfil/perfilvendedor.php?error=" . urlencode($error));
    } else {
        header("Location: ../usuario/perfilUser.php?error=" . urlencode($error));
    }

    exit();
}
?>