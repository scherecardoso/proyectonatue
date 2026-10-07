
<?php
// Inicia o recupera la sesión para consultar los datos del usuario conectado.
session_start();

// Define la página de perfil a la que volverá el usuario al cancelar la edición.
if ($_SESSION['rol'] == 'administrador') {
    $perfil = '../perfil/perfiladmin.php';
} elseif ($_SESSION['rol'] == 'usuario') {
    $perfil = '../perfil/perfilusuario.php';
} 
// Conecta con la base de datos del proyecto.
$conn = new mysqli('localhost', 'root', '', 'shena');

// Detiene la página si no se pudo establecer la conexión.
if ($conn->connect_error) {
    die('Conexión fallida: ' . $conn->connect_error);
}

// Obtiene el CI de la sesión como texto para usarlo en la consulta.
$CI = (string) $_SESSION['CI'];

// Prepara una consulta parametrizada para obtener los datos del usuario.
$stmt = $conn->prepare('SELECT nombre, direccion, celular FROM usuario WHERE CI = ?');
// Vincula el CI al parámetro de la consulta (s indica que es una cadena).
$stmt->bind_param('s', $CI);
// Ejecuta la búsqueda del usuario.
$stmt->execute();

// Guarda el resultado y obtiene la fila encontrada como arreglo asociativo.
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Libera los recursos de consulta y conexión una vez obtenidos los datos.
$stmt->close();
$conn->close();

// Si no existe el usuario asociado al CI de la sesión, muestra un aviso y termina.
if (!$usuario) {
    die('Usuario no encontrado');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Configuración de caracteres y adaptación del diseño a dispositivos móviles. -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Texto que se muestra en la pestaña del navegador. -->
    <title>Editar mi información</title>

    <!-- Estilos visuales de la página y del formulario. -->
    <style>
        /* Usa el mismo modelo de caja y tipografía en todos los elementos. */
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Establece el fondo, el alto mínimo y el espacio exterior de la página. */
        body {
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            background: #f3f3f3;
        }

        /* Centra el formulario y le da apariencia de tarjeta. */
        form {
            width: min(550px, 100%);
            margin: 0 auto;
            padding: 40px;
            background: white;
            border: 2px solid #f8c6e5;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        /* Presenta el título centrado sobre los campos. */
        h2 {
            margin: 0 0 30px;
            color: #222;
            text-align: center;
        }

        /* Estilo común de los campos donde se editan los datos. */
        input {
            width: 100%;
            height: 52px;
            margin-bottom: 18px;
            padding: 15px 20px;
            border: 1px solid #f5a3d5;
            border-radius: 40px;
            background: #fafafa;
            color: #333;
            font-size: 15px;
            outline: none;
        }

        /* Cambia el borde para indicar cuál campo está seleccionado. */
        input:focus {
            border-color: #f06ac3;
        }

        /* Comparte tamaño y alineación entre el botón y el enlace de cancelar. */
        button,
        .volver {
            display: block;
            width: 100%;
            padding: 14px;
            border-radius: 40px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        /* Color y borde del botón que guarda los cambios. */
        button {
            border: 1px solid #f34bb3;
            background: #f06ac3;
            color: white;
        }

        /* Apariencia del enlace que permite cancelar y regresar al perfil. */
        .volver {
            margin-top: 12px;
            border: 1px solid #ddd;
            background: white;
            color: #555;
        }
    </style>
</head>

<body>

<!-- Envía los datos modificados al archivo que procesa la actualización del perfil. -->
<form action="../usuario/17.actualizarperfil.php" method="post">
    <!-- Campo oculto con la ruta que se enviará al procesador del formulario. -->
    <input type="hidden" name="redirect" value="../usuario/perfilUser.php">

    <!-- Encabezado que identifica el propósito del formulario. -->
    <h2>Editar mi información</h2>

    <!-- Campo de nombre precargado; htmlspecialchars protege el valor al imprimirlo en HTML. -->
    <input
        type="text"
        name="nombre"
        value="<?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?>"
        placeholder="Nombre completo"
        required
    >

    <!-- Campo de dirección precargado con los datos actuales del usuario. -->
    <input
        type="text"
        name="direccion"
        value="<?= htmlspecialchars($usuario['direccion'], ENT_QUOTES, 'UTF-8') ?>"
        placeholder="Dirección"
        required
    >

    <!-- Campo de celular precargado con los datos actuales del usuario. -->
    <input
        type="text"
        name="celular"
        value="<?= htmlspecialchars($usuario['celular'], ENT_QUOTES, 'UTF-8') ?>"
        placeholder="Celular"
        required
    >

    <!-- Envía los campos del formulario para guardar la información actualizada. -->
    <button type="submit">Guardar cambios</button>

<!-- Enlace para volver al perfil definido según el rol de la sesión. -->
<a class="volver" href="<?= $perfil ?>">
    Cancelar
</a>>

</form>

</body>
</html>
