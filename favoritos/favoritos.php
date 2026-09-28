<?php
session_start();

if (!isset($_SESSION['CI'])) {
    header("Location: ../pagina/23.autenticar.php");
    exit();
}

$CI = $_SESSION['CI'];

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "SELECT productos.*
        FROM favoritos
        INNER JOIN productos ON favoritos.codigo = productos.codigo
        WHERE favoritos.CI = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $CI);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<title>Mis Favoritos</title>

<style>

body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 330px minmax(0, 1fr);
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "barra barra"
        "menu info";
    gap: 10px;
    min-height: 100vh;
    background: #ffffff;
    overflow-x: hidden;
}

.contenedor {
    grid-area: info;
    width: 100%;
    min-width: 0;
    padding: 35px 30px;
    box-sizing: border-box;
}

.contenedor-interno {
    width: 100%;
    max-width: 1300px;
    margin: 0 auto;
}

h4 {
    margin: 0 0 30px 0;
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-size: 40px;
    font-weight: 600;
    color: #ff5ca8;
}

.lista-favoritos {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

.producto {
    width: 280px;
    background: white;
    border-radius: 20px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    box-sizing: border-box;
    transition: 0.3s;
}

.producto:hover {
    transform: translateY(-4px);
}

.producto img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 15px;
}

.producto h3 {
    margin: 10px 0;
    word-break: break-word;
}

.precio {
    font-size: 20px;
    font-weight: bold;
}

.corazon {
    color: #ff5ca8;
    font-size: 30px;
    margin-top: 10px;
}

.volver {
    display: block;
    width: 180px;
    margin: 40px auto 0;
    padding: 14px;
    background: #fb7cb7;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 25px;
    box-sizing: border-box;
    transition: 0.3s;
}

.volver:hover {
    background: #fd78b6;
    transform: scale(1.05);
}

.sin-favoritos {
    text-align: center;
    font-size: 20px;
    color: #777;
}


@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto;
        grid-template-areas:
            "barra"
            "menu"
            "info";
        gap: 0;
    }

    .contenedor {
        padding: 30px 20px 40px;
    }
}


@media (max-width: 850px) {
    h4 {
        font-size: 32px;
    }

    .lista-favoritos {
        gap: 20px;
    }

    .producto {
        width: calc(50% - 10px);
    }

    .producto img {
        height: 230px;
    }
}


@media (max-width: 600px) {
    .contenedor {
        padding: 15px 10px 30px;
    }

    h4 {
        font-size: 26px;
        margin-bottom: 20px;
    }

    .producto {
        width: 100%;
        max-width: 320px;
        border-radius: 16px;
    }

    .producto img {
        height: 260px;
    }

    .volver {
        width: 80%;
    }
}


@media (max-width: 400px) {
    h4 {
        font-size: 22px;
    }

    .producto img {
        height: 220px;
    }

    .precio {
        font-size: 18px;
    }
}

</style>

</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/includeuser.php"); ?>

<div class="contenedor">
<div class="contenedor-interno">

<h4>Mis Favoritos ♥</h4>

<div class="lista-favoritos">

<?php
if ($resultado && $resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {
?>

    <div class="producto">

        <img src="../img/<?php echo htmlspecialchars($fila['imagen']); ?>"
             alt="<?php echo htmlspecialchars($fila['nombre']); ?>">

        <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>

        <p>Código: <?php echo htmlspecialchars($fila['codigo']); ?></p>

        <p class="precio"><?php echo htmlspecialchars($fila['precio']); ?> Bs</p>

        <div class="corazon">♥</div>

    </div>

<?php
    }

} else {
    echo "<p class='sin-favoritos'>Todavía no tienes productos favoritos.</p>";
}
?>

</div>

<a class="volver" href="../pagina/03.productos.php">
    Volver a productos
</a>

</div>
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>