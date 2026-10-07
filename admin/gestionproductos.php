<?php
// Se inicia la sesión para verificar que el usuario actual tenga acceso autorizado.
// Si no existe una sesión o el rol no es administrador, se le redirige al login.
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    // Si el usuario no es administrador, no puede entrar a esta vista.
    header("Location: ../pagina/login.php");
    exit();
}

// Se crea la conexión a la base de datos local.
// Los datos corresponden a la BD "shena" del proyecto.
$conn = new mysqli("localhost", "root", "", "shena");

// Si la conexión falla, se corta la ejecución para evitar errores en la página.
if ($conn->connect_error) {
    die("Error de conexión");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Se cargan fuentes tipográficas para lograr el estilo visual del sitio. -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

<style>

/*
    Este bloque CSS define el diseño general de la vista de administración.
    Se usa una estructura tipo dashboard con una barra superior y un contenido principal.
*/

html {
    overflow-x: hidden;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #ffffff;
    min-height: 100vh;
    max-width: 100%;
    overflow-x: hidden;

    /* El layout general divide el espacio entre el menú lateral y el contenido. */
    display: grid;
    grid-template-columns: 330px minmax(0, 1fr);
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "barra barra"
        "menu  contenido";
    gap: 0;
}

@media (max-width: 1199px) {
    body {
        /* En pantallas medianas y pequeñas, la estructura se vuelve vertical. */
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto auto 1fr;
        grid-template-areas:
            "barra"
            "menu"
            "contenido";
    }
}

/* Contenedor principal donde se muestra el listado de productos. */
.contenido {
    grid-area: contenido;
    padding: clamp(12px, 3vw, 30px);\n    box-sizing: border-box;
    width: 100%;
    min-width: 0;
}

/* Caja blanca que contiene la tabla y el título de la sección. */
.contenedor {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    background: #fff;
    padding: clamp(15px, 3vw, 30px);
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0,0,0,.08);
    border: 1px solid #f3f3f3;
    box-sizing: border-box;
}

.contenedor h1 {
    text-align: center;
    margin-top: 0;
    margin-bottom: 30px;
    color: #ff5ca8;
    font-family: "Playfair Display", serif;
    font-size: clamp(26px, 4vw, 35px);
}

/* Contenedor con desplazamiento horizontal para la tabla en distintos tamaños. */
.tabla-contenedor {
    width: 100%;
    overflow-x: auto;
}

/*
    Estilos base de la tabla.
    Se usa un diseño elegante con bordes redondeados y separación visual entre filas.
*/
table {
    width: 100%;
    min-width: 900px;
    border-collapse: separate;
    border-spacing: 0 12px;
    color: inherit;
}

th {
    background: #fff1f7;
    padding: 16px;
    font-size: 14px;
    color: #ff5ca8;
    text-align: center;
}

td {
    background: #ffffff;
    padding: 16px;
    font-size: 14px;
    text-align: center;
    border-top: 1px solid #f3f3f3;
    border-bottom: 1px solid #f3f3f3;
}

tr td:first-child {
    border-left: 1px solid #f3f3f3;
    border-radius: 15px 0 0 15px;
}

tr td:last-child {
    border-right: 1px solid #f3f3f3;
    border-radius: 0 15px 15px 0;
}

tr:hover td {
    background: #fff8fb;
}

/* Ajusta las imágenes de cada producto dentro de la tabla. */
.producto-imagen {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #eee;
}

/* Área con los botones de edición y eliminación. */
.acciones {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

/* Estilo general para los botones. */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: .2s;
}

.editar {
    background: #ffe4ef;
    color: #ff4f8b;
}

.editar:hover {
    background: #ffd0e2;
    transform: translateY(-2px);
}

.eliminar {
    background: #fff0f0;
    color: #ff4d4d;
}

.eliminar:hover {
    background: #ffdada;
    transform: translateY(-2px);
}

/* Mensaje que se muestra cuando la base de datos no tiene resultados. */
.sin-datos {
    text-align: center;
    margin: 30px 0;
    color: #777;
}

/*
    En pantallas pequeñas se transforma la tabla en tarjetas para mejorar legibilidad.
    Esto se logra ocultando los encabezados y mostrando etiquetas en cada fila.
*/
@media (max-width: 768px) {

    .tabla-contenedor {
        overflow-x: visible;
    }

    table,
    tbody,
    tr,
    td {
        display: block;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }

    thead {
        display: none;
    }

    tr {
        margin-bottom: 18px;
        padding: 8px 14px;
        border: 1px solid #f0d5e2;
        border-radius: 16px;
        background: #fffafc;
    }

    td,
    tr td:first-child,
    tr td:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 9px 0;
        text-align: right;
        background: transparent;
        border: none;
        border-bottom: 1px solid #f3e3ea;
        border-radius: 0;
        font-size: 15px;
        word-break: break-word;
    }

    tr:hover td {
        background: transparent;
    }

    td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #ff5ca8;
        text-align: left;
        flex-shrink: 0;
    }

    td.celda-acciones,
    tr td.celda-acciones:last-child {
        display: block;
        border-bottom: none;
        padding-top: 12px;
        text-align: left;
    }

    td.celda-acciones::before {
        display: none;
    }

    .acciones {
        justify-content: flex-start;
    }
}
</style>
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/includeadmin.php"); ?>

<!-- Se muestra la vista principal del administrador con el listado de productos. -->
<main class="contenido">
    <div class="contenedor">
        <h1>Lista de Productos</h1>

        <div class="tabla-contenedor">

<?php
// Consulta para traer todos los productos ordenados por código.
$sql = "SELECT * FROM productos ORDER BY codigo ASC";
$result = $conn->query($sql);

// Si la consulta devolvió filas, se imprimen en una tabla; de lo contrario se muestra un aviso.
if ($result && $result->num_rows > 0) {
?>

            <table>
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Costo</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
                </thead>

                <tbody>
<?php
// Recorre cada producto para crear una fila en la tabla.
while ($fila = $result->fetch_assoc()) {
    // Se extraen los valores principales de cada producto.
    $codigo = $fila['codigo'];
    $archivoImagen = "../img/" . $fila['imagen'];
    $stock = (int)$fila['stock'];

    // Si el stock es bajo, se resalta en rojo para avisar que queda poco inventario.
    if ($stock <= 5) {
        $colorStock = "#ff0000";
    } else {
        $colorStock = "#008000";
    }
?>

                <tr>
                    <td data-label="Código"><?php echo htmlspecialchars($fila['codigo']); ?></td>
                    <td data-label="Nombre"><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td data-label="Descripción"><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                    <td data-label="Precio">Bs <?php echo htmlspecialchars($fila['precio']); ?></td>
                    <td data-label="Costo">Bs <?php echo htmlspecialchars($fila['costo']); ?></td>

                    <td data-label="Stock">
                        <span style="color:<?php echo $colorStock; ?>; font-weight:bold;">
                            <?php echo htmlspecialchars($stock); ?>
                        </span>
                    </td>

                    <td data-label="Imagen">
<?php if (!empty($fila['imagen']) && file_exists($archivoImagen)) { ?>
                        <!-- Si existe la imagen del producto, se muestra en la tabla. -->
                        <img
                            src="<?php echo htmlspecialchars($archivoImagen); ?>"
                            alt="<?php echo htmlspecialchars($fila['nombre']); ?>"
                            class="producto-imagen">
<?php } else { ?>
                        <!-- Si la imagen no existe, se muestra un texto alternativo. -->
                        <span>No imagen</span>
<?php } ?>
                    </td>

                    <td class="celda-acciones">
                        <div class="acciones">
                            <!-- Enlace para abrir el formulario de edición del producto. -->
                            <a
                                class="btn editar"
                                href="../productos/18.formeditarproductos.php?codigo=<?php echo urlencode($codigo); ?>">
                                <i class="fa-solid fa-pen"></i>
                                Editar
                            </a>

                            <!-- Enlace para eliminar el producto con confirmación antes de borrar. -->
                            <a
                                class="btn eliminar"
                                href="../productos/20.eliminarproductos.php?codigo=<?php echo urlencode($codigo); ?>"
                                onclick="return confirm('¿Está seguro de eliminar este producto?');">
                                <i class="fa-solid fa-trash"></i>
                                Eliminar
                            </a>
                        </div>
                    </td>
                </tr>

<?php
}
?>
                </tbody>
            </table>

<?php
} else {
    // Si no hay productos registrados, se muestra un mensaje amigable.
?>

            <p class="sin-datos">No hay productos registrados.</p>

<?php
}
?>

        </div>
    </div>
</main>

</body>
</html>

<?php
// Se cierran los recursos de la conexión a la base de datos.
$conn->close();
?>