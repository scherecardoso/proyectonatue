<?php
session_start();

if ($_SESSION['rol'] != "usuario") {
    header("Location: ../usuario/09.register.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre_usuario = $_SESSION['nombre'] ?? '';
$carpetaImagenes = "../img/";

// Validar que se subió archivo
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {
    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
    
    // Validar extensión
    if (in_array($extension, $extensionesPermitidas)) {
        // Validar tamaño (máximo 5MB)
        if ($_FILES["imagen"]["size"] <= 5242880) {
            // Generar nombre único: perfil-[nombre].[extension]
            $nuevoNombre = "perfil-" . str_replace(" ", "_", $nombre_usuario) . "." . $extension;
            $rutaCompleta = $carpetaImagenes . $nuevoNombre;
            
            // Mover archivo a la carpeta
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta)) {
                // Actualizar en BD
                $sql = "UPDATE usuario SET imagen_perfil=? WHERE nombre=?";
                $stmt = $conexion->prepare($sql);
                
                if ($stmt) {
                    $stmt->bind_param("ss", $nuevoNombre, $nombre_usuario);
                    
                    if ($stmt->execute()) {
                        $stmt->close();
                        $conexion->close();
                        header("Location: ../usuario/perfilUser.php?success=1");
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
    header("Location: ../usuario/perfilUser.php?error=" . urlencode($error));
    exit();
}
?>