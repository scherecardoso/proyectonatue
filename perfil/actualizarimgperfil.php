<?php
// Inicia la sesión para consultar el rol y el nombre del usuario actual.
session_start();

// Solo se permite continuar a usuarios con uno de estos roles autorizados.
if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor", "usuario"])) {
    // Si la sesión no tiene un rol válido, se envía al usuario a la página de registro.
    header("Location: ../usuario/09.register.php");
    exit();
}

// Conecta con la base de datos del proyecto.
$conexion = new mysqli("localhost", "root", "", "shena");

// Si falla la conexión, se detiene el proceso y se muestra el motivo.
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtiene el nombre de usuario de la sesión y conserva el rol para las redirecciones.
$nombre_usuario = $_SESSION['nombre'] ?? '';
$rol = $_SESSION['rol'];

// Directorio relativo en el que se almacenarán las imágenes de perfil.
$carpetaImagenes = "../img_perfil/";

// Verifica que el formulario haya enviado un archivo en el campo "imagen".
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["name"] != "") {

    // Obtiene la extensión original del archivo y la normaliza a minúsculas.
    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));

    // Lista de extensiones aceptadas para las imágenes de perfil.
    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

    // Comprueba que la extensión del archivo esté permitida.
    if (in_array($extension, $extensionesPermitidas)) {

        // Acepta archivos de hasta 5 MB.
        if ($_FILES["imagen"]["size"] <= 5242880) {

            // Genera un nombre de archivo a partir del nombre del usuario y la extensión.
            $nuevoNombre = "perfil-" . str_replace(" ", "_", $nombre_usuario) . "." . $extension;

            // Construye la ruta relativa completa donde se guardará el archivo.
            $rutaCompleta = $carpetaImagenes . $nuevoNombre;

            // Mueve el archivo desde la ubicación temporal a la carpeta de destino.
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaCompleta)) {

                // Prepara una consulta para actualizar la imagen del usuario en la base de datos.
                $sql = "UPDATE usuario SET imagen_perfil=? WHERE nombre=?";

                // Prepara la consulta antes de asociar sus valores y ejecutarla.
                $stmt = $conexion->prepare($sql);

                if ($stmt) {

                    // Asocia el nombre de imagen y el nombre del usuario a los parámetros SQL.
                    $stmt->bind_param("ss", $nuevoNombre, $nombre_usuario);

                    // Ejecuta la actualización del registro del usuario.
                    if ($stmt->execute()) {

                        // Cierra la consulta y la conexión antes de abandonar este archivo.
                        $stmt->close();
                        $conexion->close();

                        // Redirige al perfil correspondiente e indica que la operación fue exitosa.
                        if ($rol == "administrador") {
                            header("Location: ../perfil/perfiladmin.php?success=1");
                        } elseif ($rol == "vendedor") {
                            header("Location: ../perfil/perfilvendedor.php?success=1");
                        } else {
                            header("Location: ../usuario/perfilUser.php?success=1");
                        }

                        exit();

                    } else {
                        // Guarda el mensaje de error si la actualización de la base de datos falla.
                        $error = "Error al actualizar BD: " . $stmt->error;
                    }

                    $stmt->close();

                } else {
                    // Guarda el error que ocurrió al preparar la consulta.
                    $error = "Error en la consulta: " . $conexion->error;
                }

            } else {
                // Indica que no se pudo mover el archivo a la carpeta de imágenes.
                $error = "Error al subir el archivo. Verifica permisos de carpeta.";
            }

        } else {
            // Informa que se excedió el tamaño máximo aceptado.
            $error = "El archivo es muy grande. Máximo 5MB.";
        }

    } else {
        // Informa que la extensión del archivo no está admitida.
        $error = "Extensión no permitida. Solo: jpg, jpeg, png, gif, webp, avif";
    }

} else {
    // Informa que no se seleccionó ningún archivo para cargar.
    $error = "No se seleccionó imagen";
}

// Cierra la conexión una vez finalizado el intento de carga y actualización.
$conexion->close();

// Si ocurrió un error, prepara la redirección al perfil con el mensaje correspondiente.
if (isset($error)) {

    // El destino depende del rol del usuario que inició sesión.
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