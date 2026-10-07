<?php
// Se inicia la sesión para poder guardar datos del usuario autenticado.
// Esto permite luego consultar el rol, nombre y demás información en otras páginas.
session_start();

// Datos de conexión a la base de datos local del proyecto.
// Aquí se indica el servidor, usuario, contraseña y nombre de la BD.
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "shena";

// Se crea la conexión con MySQL usando la extensión mysqli.
// Si la conexión falla, se corta la ejecución del script.
$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

// Verifica si hubo un error al intentar conectarse a la base de datos.
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Se obtienen los datos enviados desde el formulario del login.
// Se usa el operador ?? para evitar errores si el campo no llega definido.
$CI = $_POST["CI"] ?? "";
$direccion = $_POST["direccion"] ?? "";

// Validación inicial: si la cédula o la dirección vienen vacías,
// se muestra un mensaje de error y no se consulta a la base de datos.
if ($CI == "" || $direccion == "") {
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
        imageUrl: "../img/perrito-triste.gif",
        imageWidth: 200,
        imageHeight: 200,
        imageAlt: "Perrito triste",
        background: "#fff1f4",
        color: "#7a263a",
        confirmButtonColor: "#c94f68",
        confirmButtonText: "Aceptar"
    });
    </script>

    </body>
    </html>
    ';
    // Se cierra la conexión antes de salir para liberar recursos.
    $conn->close();
    exit();
}

// Se prepara la consulta SQL para buscar al usuario por CI y dirección.
// Se usa una sentencia preparada para evitar inyección SQL y manejar mejor los valores.
$sql = "SELECT CI, nombre, rol, estado
        FROM usuario
        WHERE CI = ?
        AND direccion = ?";

// Prepara la consulta en la base de datos.
$stmt = $conn->prepare($sql);

// Si la preparación falla, se muestra el error para depurar.
if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

// Se enlazan los parámetros con la consulta:
// "ss" significa que ambos valores son cadenas de texto.
$stmt->bind_param("ss", $CI, $direccion);
$stmt->execute();

// Se obtiene el resultado de la consulta.
$resultado = $stmt->get_result();

// Si existe al menos una fila, significa que el usuario fue encontrado.
if ($resultado->num_rows > 0) {

    // Se extrae la fila de datos del usuario encontrado.
    $fila = $resultado->fetch_assoc();

    // Se guardan los datos principales del usuario en la sesión.
    // Eso permitirá reconocer al usuario en otras páginas del proyecto.
    $_SESSION['CI'] = $fila['CI'];
    $_SESSION['nombre'] = $fila['nombre'];
    $_SESSION['direccion'] = $fila['direccion'];
    $_SESSION['celular'] = $fila['celular'];
    $_SESSION['rol'] = $fila['rol'];
    $_SESSION['estado'] = $fila['estado'];
    $_SESSION['fecha'] = $fila['fecha'];

    // Se redirige según el rol del usuario autenticado.
    // Cada rol tiene una vista diferente dentro del sistema.
    if ($fila['rol'] == "vendedor") {

        // Si el rol es vendedor, va al panel del vendedor.
        header("Location: ../vendedor/07.vendedor.php");
        exit();

    } elseif ($fila['rol'] == "administrador") {

        // Si el rol es administrador, va al panel administrativo.
        header("Location: ../admin/06.admin.php");
        exit();

    } elseif ($fila['rol'] == "usuario") {

        // Si el rol es usuario normal, va al panel del cliente/usuario.
        header("Location: ../usuario/08.usuario.php");
        exit();

    } else {

        // Si el rol no coincide con ninguno de los esperados,
        // se muestra una alerta de error para evitar una redirección incorrecta.
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
            imageUrl: "../img/perrito-triste.gif",
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: "Perrito triste",
            background: "#fff5f7",
            color: "#7a263a",
            confirmButtonColor: "#c94f68",
            confirmButtonText: "Aceptar"
        });
        </script>
        </body>
        </html>
        ';
    }

} else {

    // Si la consulta no devuelve filas, quiere decir que
    // no existe un usuario con esa CI y dirección.
    // Se muestra el mismo mensaje de error que en la validación inicial.
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
        imageUrl: "../img/perrito-triste.gif",
        imageWidth: 200,
        imageHeight: 200,
        imageAlt: "Perrito triste",
        background: "#fff1f4",
        color: "#7a263a",
        confirmButtonColor: "#c94f68",
        confirmButtonText: "Aceptar"
    });
    </script>

    </body>
    </html>
    ';
}

// Se cierran el statement y la conexión para liberar recursos del servidor.
$stmt->close();
$conn->close();
?>
