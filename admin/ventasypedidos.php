<?php
// Se inicia la sesión para validar que el usuario tenga acceso como administrador.
// Si no existe una sesión o el usuario no es administrador, se redirige al login.
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    // El acceso a esta vista está restringido a administradores.
    // Si intenta entrar sin permisos, se lo envía al formulario de inicio de sesión.
    header("Location: ../pagina/login.php");
    exit();
}

// Se crea la conexión a la base de datos del proyecto.
// Aquí se conecta con la BD "shena" del servidor local.
$conexion = new mysqli("localhost", "root", "", "shena");

// Si la conexión falla, la ejecución del archivo termina para evitar errores posteriores.
if ($conexion->connect_error) {
    die("Error de conexión");
}

// Se consulta la tabla ventas para mostrar el historial ordenado desde la venta más reciente.
$sql = "SELECT * FROM ventas ORDER BY id DESC";
$resultado = $conexion->query($sql);

// Si la consulta no se ejecuta correctamente, se muestra el error de MySQL.
if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Se cargan las fuentes tipográficas y iconos para mantener el estilo visual del panel administrativo. -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
<style>

/*
    Este bloque CSS define el diseño general de la vista.
    La estructura está organizada como un dashboard con una barra superior,
    un menú lateral y el contenido principal donde aparecen las ventas.
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

    /* Se usa grid para repartir el layout general entre barra, menú y contenido. */
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
        /* En pantallas menores el layout pasa a una disposición vertical para mejorar la lectura. */
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto auto 1fr;
        grid-template-areas:
            "barra"
            "menu"
            "contenido";
    }
}

.contenido {
    grid-area: contenido;
    padding: clamp(15px, 3vw, 40px);
    box-sizing: border-box;
    width: 100%;
    min-width: 0;
}

.titulo {
    text-align: center;
    margin: 10px 0 35px;
    color: #ff5ca8;
    font-family: "Playfair Display", serif;
    font-size: clamp(26px, 4vw, 32px);
}

.contenedorVentas {
    width: 100%;
    max-width: 1100px;
    margin: 0 auto;
}

.contenedor {
    background: #fff;
    padding: clamp(18px, 3vw, 30px);
    margin: 0 0 25px;
    border-radius: 18px;
    border: 1px solid #f0f0f0;
    box-shadow: 0 4px 18px rgba(0,0,0,.08);
    transition: .2s;
}

.contenedor:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,.10);
}

.contenedor h3 {
    margin: 0;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
    font-size: 21px;
    color: #333;
}

/*
    El bloque informacion organiza los datos de cada venta en columnas responsivas.
    Así se puede mostrar código, costo, método de pago y estado de forma ordenada.
*/
.informacion {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.dato {
    display: flex;
    flex-direction: column;
    gap: 6px;
    min-width: 0;
}

.dato strong {
    font-size: 12px;
    color: #888;
    text-transform: uppercase;
}

.dato span {
    font-size: 16px;
    color: #333;
    word-break: break-word;
}

.estado {
    display: inline-block;
    width: fit-content;
    padding: 7px 13px;
    border-radius: 20px;
    background: #f4d6e2;
    color: #a33c67 !important;
    font-size: 14px !important;
}

/*
    Aquí se definen los estilos de los botones de acción para ver, editar o eliminar ventas.
    Cada botón tiene un color distinto para diferenciar la acción que realiza.
*/
.acciones {
    margin-top: 25px;
    padding-top: 18px;
    border-top: 1px solid #eee;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 10px;
}

.btn-ver,
.btn-editar,
.btn-eliminar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 18px;
    text-decoration: none;
    border-radius: 10px;
    font-size: 14px;
    transition: .2s;
}

.btn-ver {
    background: #ffdcec;
    color: #d63f7b;
}

.btn-ver:hover {
    background: #ffcade;
    transform: translateY(-2px);
}

.btn-editar {
    background: #fff0f6;
    color: #d63f7b;
}

.btn-editar:hover {
    background: #ffdcec;
    transform: translateY(-2px);
}

.btn-eliminar {
    background: #ffe8e8;
    color: #c0392b;
}

.btn-eliminar:hover {
    background: #ffd0d0;
    transform: translateY(-2px);
}

.sin-ventas {
    text-align: center;
    color: #777;
}

@media (max-width: 600px) {

    .contenedor {
        border-radius: 14px;
    }

    .contenedor h3 {
        font-size: 19px;
    }

    .informacion {
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .acciones {
        justify-content: stretch;
    }

    .btn-ver,
    .btn-editar,
    .btn-eliminar {
        flex: 1 1 auto;
        padding: 10px 12px;
        font-size: 13px;
    }
}
</style>
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/includeadmin.php"); ?>

<!--
    Este bloque es el contenido principal del panel de administración.
    Aquí se muestran todas las ventas registradas con sus detalles y botones de navegación.
-->
<main class="contenido">

    <h1 class="titulo">Historial de Ventas</h1>

    <div class="contenedorVentas">

        <?php if ($resultado && $resultado->num_rows > 0): ?>

            <?php while ($fila = $resultado->fetch_assoc()): ?>

                <!--
                    Cada tarjeta representa una venta distinta.
                    Se muestra la información principal y acciones rápidas para verla o gestionarla.
                -->
                <div class="contenedor">

                    <h3>
                        Venta #<?php echo htmlspecialchars($fila['id']); ?>
                    </h3>

                    <div class="informacion">

                        <div class="dato">
                            <strong>Pedido</strong>
                            <span>
                                #<?php echo htmlspecialchars($fila['pedidos_id']); ?>
                            </span>
                        </div>

                        <div class="dato">
                            <strong>Costo</strong>
                            <span>
                                Bs <?php echo htmlspecialchars($fila['costo']); ?>
                            </span>
                        </div>

                        <div class="dato">
                            <strong>Método de pago</strong>
                            <span>
                                <?php echo htmlspecialchars($fila['metodo']); ?>
                            </span>
                        </div>

                        <div class="dato">
                            <strong>Estado</strong>
                            <span class="estado">
                                <?php echo htmlspecialchars($fila['estado']); ?>
                            </span>
                        </div>

                    </div>

                    <div class="acciones">

                        <!-- Botón para abrir el detalle completo del pedido asociado a esta venta. -->
                        <a
                            href="../admin/detallepedido.php?id=<?php echo urlencode($fila['pedidos_id']); ?>"
                            class="btn-ver"
                        >
                            <i class="fa-solid fa-eye"></i>
                            Ver pedido
                        </a>

                        <!-- Botón para editar la venta seleccionada. -->
                        <a
                            href="../ventas/editarventa.php?id=<?php echo urlencode($fila['id']); ?>"
                            class="btn-editar"
                        >
                            <i class="fa-solid fa-pen"></i>
                            Editar
                        </a>

                        <!-- Botón para eliminar la venta con confirmación para evitar borrados accidentales. -->
                        <a
                            href="../ventas/deleteventas.php?id=<?php echo urlencode($fila['id']); ?>"
                            class="btn-eliminar"
                            onclick="return confirm('¿Estás seguro de eliminar esta venta?');"
                        >
                            <i class="fa-solid fa-trash"></i>
                            Eliminar
                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <!-- Se muestra este mensaje cuando todavía no hay ventas registradas en la base de datos. -->
            <div class="contenedor sin-ventas">
                <h3>No hay ventas registradas</h3>
                <p>Todavía no se han registrado ventas.</p>
            </div>

        <?php endif; ?>

    </div>

</main>

</body>
</html>

<?php
// Se cierra la conexión a la base de datos al final del archivo.
$conexion->close();
?>