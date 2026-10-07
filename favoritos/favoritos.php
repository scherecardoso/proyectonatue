<?php
// Se inicia la sesión para verificar que el usuario esté autenticado antes de acceder a sus favoritos.
// Si la sesión no existe, el usuario es redirigido al inicio de sesión.
session_start();

// Se valida que exista la sesión con la cédula del cliente.
// Esto garantiza que solo un usuario logueado pueda ver su lista de favoritos.
if (!isset($_SESSION['CI'])) {
    header("Location: ../pagina/23.autenticar.php");
    exit();
}

// Se guarda la cédula del usuario actual para consultar solo sus productos favoritos.
$CI = $_SESSION['CI'];

// Datos de conexión a la base de datos local.
$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

// Se crea la conexión a MySQL usando los datos anteriores.
$conn = new mysqli($servidor, $usuario, $contra, $baseDeDatos);

// Si la conexión falla, se corta la ejecución y se muestra el error.
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// Consulta principal:
// Se obtiene la información de los productos que el usuario actual tiene guardados en favoritos.
// Se une la tabla favoritos con la tabla productos usando el campo codigo.
$sql = "SELECT productos.*
        FROM favoritos
        INNER JOIN productos ON favoritos.codigo = productos.codigo
        WHERE favoritos.CI = ?";

// Se prepara la consulta para evitar inyección SQL.
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

<!-- Fuentes y iconos para mantener el estilo visual del sitio. -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<title>Mis Favoritos</title>

<style>

/*
    La estructura general del layout se divide en dos columnas:
    - una parte para la barra superior o menú lateral del sitio
    - otra parte para el contenido principal.
*/
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

/* Contenedor principal donde se muestran los productos favoritos. */
.contenedor {
    grid-area: info;
    width: 100%;
    min-width: 0;
    padding: 35px 30px;
    box-sizing: border-box;
}

/* Ajusta el ancho interno para que la lista se vea centrada y ordenada. */
.contenedor-interno {
    width: 100%;
    max-width: 1300px;
    margin: 0 auto;
}

/* Título de la sección con estilo elegante. */
h4 {
    margin: 0 0 30px 0;
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-size: 40px;
    font-weight: 600;
    color: #ff5ca8;
}

/* Contenedor flexible para mostrar cada producto favorito en tarjetas. */
.lista-favoritos {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}

/* Cada tarjeta de producto tiene imagen, nombre, precio y un corazón como indicador de favorito. */
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

/* Icono del corazón que representa que ese producto está en favoritos. */
.corazon {
    color: #ff5ca8;
    font-size: 30px;
    margin-top: 10px;
}

/* Botón para volver a la sección de productos. */
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

/* Mensaje mostrado cuando el usuario no tiene productos favoritos. */
.sin-favoritos {
    text-align: center;
    font-size: 20px;
    color: #777;
}

/* Responsive para tabletas y pantallas medianas. */
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

/* Responsive para móviles medianos. */
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

/* Responsive para celulares pequeños. */
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

/* Ajustes extra para pantallas muy pequeñas. */
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

<!-- Aquí empieza el contenido visible de la sección de favoritos. -->
<div class="contenedor">
<div class="contenedor-interno">

<!-- Título principal para la sección. -->
<h4>Mis Favoritos ♥</h4>

<div class="lista-favoritos">

<?php
// Si la consulta devolvió resultados, se muestran las tarjetas de productos favoritos.
if ($resultado && $resultado->num_rows > 0) {

    // Se recorre cada fila del resultado para construir una tarjeta por producto.
    while ($fila = $resultado->fetch_assoc()) {
?>

    <div class="producto">

        <!-- Se muestra la imagen del producto con una ruta relativa al directorio img. -->
        <img src="../img/<?php echo htmlspecialchars($fila['imagen']); ?>"
             alt="<?php echo htmlspecialchars($fila['nombre']); ?>">

        <!-- Nombre del producto. -->
        <h3><?php echo htmlspecialchars($fila['nombre']); ?></h3>

        <!-- Código del producto para identificarlo. -->
        <p>Código: <?php echo htmlspecialchars($fila['codigo']); ?></p>

        <!-- Precio del producto en bolívares. -->
        <p class="precio"><?php echo htmlspecialchars($fila['precio']); ?> Bs</p>

        <!-- Símbolo visual que indica que el producto está marcado como favorito. -->
        <div class="corazon">♥</div>

    </div>

<?php
    }

} else {
    // Si no hay favoritos registrados para este usuario, se muestra un mensaje amigable.
    echo "<p class='sin-favoritos'>Todavía no tienes productos favoritos.</p>";
}
?>

</div>

<!-- Enlace para regresar a la vista de productos. -->
<a class="volver" href="../pagina/03.productos.php">
    Volver a productos
</a>

</div>
</div>

</body>
</html>

<?php
// Se cierran los recursos de la consulta y la conexión final.
$stmt->close();
$conn->close();
?>