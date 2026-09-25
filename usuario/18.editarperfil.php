<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'usuario' || empty($_SESSION['CI'])) {
    header('Location: ../pagina/login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'shena');

if ($conn->connect_error) {
    die('Conexión fallida: ' . $conn->connect_error);
}

$CI = (string) $_SESSION['CI'];
$stmt = $conn->prepare('SELECT nombre, direccion, celular FROM usuario WHERE CI = ? AND rol = ?');
$rol = 'usuario';
$stmt->bind_param('ss', $CI, $rol);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
$stmt->close();
$conn->close();

if (!$usuario) {
    die('Usuario no encontrado');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar mi información</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 40px 20px;
            background: #f3f3f3;
        }

        form {
            width: min(550px, 100%);
            margin: 0 auto;
            padding: 40px;
            background: white;
            border: 2px solid #f8c6e5;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin: 0 0 30px;
            color: #222;
            text-align: center;
        }

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

        input:focus {
            border-color: #f06ac3;
        }

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

        button {
            border: 1px solid #f34bb3;
            background: #f06ac3;
            color: white;
        }

        .volver {
            margin-top: 12px;
            border: 1px solid #ddd;
            background: white;
            color: #555;
        }
    </style>
</head>
<body>
    <form action="../usuario/17.actualizarperfil.php" method="post">
        <h2>Editar mi información</h2>

        <input
            type="text"
            name="nombre"
            value="<?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Nombre completo"
            required
        >

        <input
            type="text"
            name="direccion"
            value="<?= htmlspecialchars($usuario['direccion'], ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Dirección"
            required
        >

        <input type="text" name="celular" value="<?= htmlspecialchars($usuario['celular'], ENT_QUOTES, 'UTF-8') ?>" placeholder="Celular" required>

        <button type="submit">Guardar cambios</button>
        <a class="volver" href="../usuario/perfilUser.php">Cancelar</a>
    </form>
</body>
</html>
