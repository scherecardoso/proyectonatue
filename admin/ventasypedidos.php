<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'administrador') {
    header("Location: ../pagina/login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$sql = "SELECT * FROM ventas ORDER BY id DESC";
$resultado = $conexion->query($sql);

if (!$resultado) {
    die("Error en la consulta: " . $conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>

body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 330px 1fr;
    grid-template-rows: 70px 1fr;
    grid-template-areas:
        "barra barra"
        "menu contenido";
    min-height: 100vh;
    background: #fff;
}

.menu {
    grid-area: menu;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background: #fff;
    padding: 15px;
    margin-top: 27px;
    width: 330px;
    border-right: 1px solid #ececec;
}

.menu a {
    text-decoration: none;
    color: #000;
}

.titulo-menu {
    font-size: 15px;
    color: #ff5ca8;
    margin-bottom: 10px;
}

.menu div {
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
    cursor: pointer;
}

.menu div:hover {
    background: #ffdcec;
    color: #ff5ca8;
    padding-left: 22px;
}

.contenido {
    grid-area: contenido;
    padding: 40px;
}

.titulo {
    text-align: center;
    margin: 10px 0 35px;
    color: #ff4f94;
    font-family: "Playfair Display", serif;
    font-size: 32px;
}

.contenedorVentas {
    width: 100%;
    max-width: 850px;
    margin: 0 auto;
}

.contenedor {
    background: #fff;
    padding: 25px 30px;
    margin: 0 auto 25px;
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

.informacion {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 20px;
}

.dato {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.dato strong {
    font-size: 12px;
    color: #888;
    text-transform: uppercase;
}

.dato span {
    font-size: 16px;
    color: #333;
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

.acciones {
    margin-top: 25px;
    padding-top: 18px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
}

.btn-ver {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: #ffdcec;
    color: #d63f7b;
    text-decoration: none;
    border-radius: 10px;
    font-size: 14px;
    transition: .2s;
}

.btn-ver:hover {
    background: #ffcade;
    transform: translateY(-2px);
}

.sin-ventas {
    text-align: center;
    color: #777;
}

@media (max-width: 800px) {

    body {
        display: block;
    }

    .menu {
        width: auto;
        margin-top: 0;
        border-right: none;
        border-bottom: 1px solid #eee;
    }

    .contenido {
        padding: 20px;
    }

    .informacion {
        grid-template-columns: 1fr;
    }

    .contenedor {
        padding: 20px;
    }
}

.btn-editar,
.btn-eliminar {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    text-decoration: none;
    border-radius: 10px;
    font-size: 14px;
    transition: .2s;
    margin-left: 8px;
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

</style>
</head>

<body>

<?php include("../includes/header.php"); ?>

<aside class="menu">
    <div class="titulo-menu">MENU ADMINISTRADOR</div>
    <a href="../admin/06.admin.php"><div><i class="fa-solid fa-house"></i> Inicio</div>
    <a href="../usuario/13.formeditarusuario.php"><div><i class="fa-solid fa-users"></i> Gestión de Usuarios</div></a>
    <div><i class="fa-solid fa-shield-halved"></i> Roles y Permisos</div>
     <a href="../admin/gestionproductos.php"><div><i class="fa-solid fa-box"></i> Gestión de Productos</div>
    <div><i class="fa-solid fa-chart-line"></i> Reportes</div>
    <a href="../admin/ventasypedidos.php"><div><i class="fa-solid fa-cart-shopping"></i> Ventas y Pedidos</div></a>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><i class="fa-solid fa-clock-rotate-left"></i> Actividad</div>
    <div><i class="fa-solid fa-right-from-bracket"><a href="../auth/26.cerrarsesion.php"></i> Cerrar sesión</div>
    
</aside>
<main class="contenido">

    <h1 class="titulo">Historial de Ventas</h1>

    <div class="contenedorVentas">

        <?php if ($resultado && $resultado->num_rows > 0): ?>

            <?php while ($fila = $resultado->fetch_assoc()): ?>

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

    <a
        href="../admin/detallepedido.php?id=<?php echo $fila['pedidos_id']; ?>"
        class="btn-ver"
    >
        <i class="fa-solid fa-eye"></i>
        Ver pedido
    </a>

    <a
        href="../ventas/editarventa.php?id=<?php echo $fila['id']; ?>"
        class="btn-editar"
    >
        <i class="fa-solid fa-pen"></i>
        Editar
    </a>

    <a
        href="../ventas/deleteventas.php?id=<?php echo $fila['id']; ?>"
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
$conexion->close();
?>
