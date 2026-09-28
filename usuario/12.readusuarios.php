<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != "administrador") {
  header("Location: ../usuario/09.register.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<title>Lista de Usuarios</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
<style>

/* =========================
   BASE
========================== */
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

    /* Computadora (1200px o más): menú lateral + contenido */
    display: grid;
    grid-template-columns: 330px minmax(0, 1fr);
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "barra barra"
        "menu  info";
    gap: 0;
}

/* Tablet y celular: el menú sube arriba en horizontal */
@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto auto 1fr;
        grid-template-areas:
            "barra"
            "menu"
            "info";
    }
}


/* =========================
   CONTENEDOR
========================== */
.contenedor {
    grid-area: info;
    justify-self: center;
    align-self: start;
    box-sizing: border-box;
    width: calc(100% - 2 * clamp(12px, 3vw, 40px));
    max-width: 1400px;
    min-width: 0;
    margin: 25px 0;
    padding: clamp(15px, 3vw, 30px);
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

h2 {
    text-align: center;
    color: #ff5ca8;
    margin: 0 0 25px;
    font-size: clamp(26px, 4vw, 35px);
    font-family: 'Playfair Display', serif;
}

h3 {
    color: #000000;
}


/* =========================
   TABLA (computadora y tablet)
========================== */
.tabla-scroll {
    width: 100%;
    overflow-x: auto;            /* si no cabe, se desliza de lado sin romper la página */
}

table {
    width: 100%;
    min-width: 800px;
    border-collapse: collapse;
    border-spacing: 0 15px;
}

th {
    background: #fff1f7;
    padding: 16px;
    font-size: 14px;
    color: #ff5ca8;
    text-align: center;
}

td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    word-break: break-word;
}

.btn {
    padding: 10px 18px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 14px;
    margin: 3px;
    display: inline-block;
    font-weight: bold;
    transition: 0.2s;
}

.editar {
    background: #f8d8e5;
    color: #d63384;
}

.eliminar {
    background: #ffe1e1;
    color: #dc3545;
}

.cambiar {
    background: #ffe1e1;
    color: #E9967A;
}

.btn:hover {
    transform: translateY(-2px);
}

.sin-datos {
    text-align: center;
    margin-top: 20px;
    color: #777;
    font-size: 18px;
}


/* =========================
   CELULAR (768px o menos): cada usuario es una tarjeta
========================== */
@media (max-width: 768px) {

    .tabla-scroll {
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
        display: none;             /* los títulos pasan a cada dato con data-label */
    }

    tr {
        margin-bottom: 18px;
        padding: 8px 14px;
        border: 1px solid #f0d5e2;
        border-radius: 16px;
        background: #fffafc;
    }

    td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 9px 0;
        text-align: right;
        border-bottom: 1px solid #f3e3ea;
        font-size: 15px;
    }

    td::before {
        content: attr(data-label);
        font-weight: bold;
        color: #ff5ca8;
        text-align: left;
        flex-shrink: 0;
    }

    /* La celda de acciones: botones en fila que se acomodan */
    td.acciones {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        border-bottom: none;
        padding-top: 12px;
    }

    td.acciones::before {
        display: none;
    }

    .btn {
        padding: 9px 14px;
        font-size: 13px;
        margin: 3px 6px 3px 0;
    }
}
</style>

</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/includeadmin.php"); ?>
<div class="contenedor">

<h2>Lista de Usuarios</h2>

<?php

$servidor = "localhost";
$usuario = "root";
$contra = "";
$baseDeDatos = "shena";

$conn = new mysqli($servidor,$usuario,$contra,$baseDeDatos);

if($conn->connect_error){
    die("Error de conexión");
}

$sql = "SELECT * FROM usuario";
$result = $conn->query($sql);

?>

<?php if($result && $result->num_rows > 0){ ?>

<div class="tabla-scroll">
<table>

    <thead>
    <tr>
        <th>CI</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Celular</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    </thead>

    <tbody>
    <?php while($fila = $result->fetch_assoc()){ ?>

    <tr>

        <td data-label="CI"><?= htmlspecialchars($fila["CI"]) ?></td>
        <td data-label="Nombre"><?= htmlspecialchars($fila["nombre"]) ?></td>
        <td data-label="Dirección"><?= htmlspecialchars($fila["direccion"]) ?></td>
        <td data-label="Celular"><?= htmlspecialchars($fila["celular"]) ?></td>
        <td data-label="Rol"><?= htmlspecialchars($fila["rol"]) ?></td>
        <td data-label="Estado"><?= htmlspecialchars($fila["estado"]) ?></td>

        <td class="acciones">

            <a class="btn editar"
               href="../usuario/13.formeditarusuario.php?CI=<?= urlencode($fila['CI']) ?>">
               Editar
            </a>

            <a class="btn eliminar"
               href="../usuario/15.eliminarusuario.php?CI=<?= urlencode($fila['CI']) ?>"
               onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">
               Eliminar
            </a>

            <?php if($fila["rol"]=="usuario"){ ?>

                <a class="btn cambiar" href="../admin/cambiarrolVendedor.php?CI=<?= urlencode($fila['CI']) ?>">
                   Hacer Vendedor
                </a>

            <?php }elseif($fila["rol"]=="vendedor"){ ?>

                <a class="btn cambiar" href="../admin/cambiarrolUsuario.php?CI=<?= urlencode($fila['CI']) ?>">
                   Hacer Usuario
                </a>

            <?php } ?>

            <?php if($fila["estado"]=="activo"){ ?>

                <a class="btn cambiar" href="../admin/bloquear.php?CI=<?= urlencode($fila['CI']) ?>">
                   Bloquear
                </a>

            <?php }elseif($fila["estado"]=="bloqueado"){ ?>

                <a class="btn cambiar" href="../admin/desbloqueado.php?CI=<?= urlencode($fila['CI']) ?>">
                   Activar
                </a>

            <?php } ?>

        </td>

    </tr>

    <?php } ?>
    </tbody>

</table>
</div>

<?php }else{ ?>

<p class="sin-datos">No hay usuarios registrados.</p>

<?php } ?>

<?php $conn->close(); ?>

</div>

</body>
</html>