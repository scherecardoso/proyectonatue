<?php
session_start();

if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'vendedor' && $_SESSION['rol'] != 'administrador')) {
    header("Location: ../pagina/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&family=Tenor+Sans&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<title>Lista de Productos</title>
<style>



body {
    display: grid;
    font-family: Arial, sans-serif;
    margin: 0;
    grid-template-areas:
        "barra barra"
        "menu-lateral contenido";
    grid-template-columns: 320px minmax(0, 1fr);
    grid-template-rows: 88px 1fr;
    min-height: 100vh;
    gap: 5px;
}

.contenedor {
    grid-area: contenido;
    width: 90%;
    max-width: 1200px;
    min-width: 0;
    margin: 40px auto;
    background: white;
    padding: 35px;
    border-radius: 28px;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    border: 1px solid #f3f3f3;
}

.contenedor h1 {
    text-align: center;
    margin-top: 0;
    margin-bottom: 30px;
    color: #ff5ca8;
    font-family: "Playfair Display", serif;
}

.tabla-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

table {
    width: 100%;
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
    word-break: break-word;
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

.producto-imagen {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #eee;
}

.stock {
    font-weight: bold;
}

.stock-bajo {
    color: #ff0000;
}

.stock-ok {
    color: #008000;
}

.acciones {
    display: flex;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

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

.sin-datos {
    text-align: center;
    margin: 30px 0;
    color: #777;
}

@media (max-width: 1199px) {
    body {
        grid-template-areas:
            "barra"
            "menu-lateral"
            "contenido";
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto;
        gap: 0;
    }

    .contenedor {
        width: 95%;
        padding: 20px;
        margin: 15px auto;
    }
}

@media (max-width: 768px) {
    .contenedor {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border-radius: 0;
        border-left: none;
        border-right: none;
    }

    .contenedor h1 {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .tabla-scroll {
        overflow-x: visible;
    }

    table,
    tbody {
        display: block;
        width: 100%;
    }

    tr:has(th) {
        display: none;
    }

    tr {
        display: block;
        margin-bottom: 16px;
        background: #ffffff;
        border: 1px solid #f3d5e2;
        border-radius: 18px;
        padding: 8px 14px;
        box-shadow: 0 4px 14px rgba(255, 92, 168, 0.08);
    }

    tr:hover td {
        background: transparent;
    }

    td,
    tr td:first-child,
    tr td:last-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 10px 0;
        border: none;
        border-bottom: 1px dashed #f3d5e2;
        border-radius: 0;
        background: transparent;
        text-align: right;
        font-size: 14px;
    }

    td:last-child,
    tr td:last-child {
        border-bottom: none;
    }

    td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #ff5ca8;
        text-align: left;
        flex-shrink: 0;
        max-width: 40%;
    }

    td[data-label="Acciones"] {
        flex-direction: column;
        align-items: stretch;
    }

    td[data-label="Acciones"]::before {
        display: none;
    }

    .acciones {
        width: 100%;
        flex-direction: row;
    }

    .btn {
        flex: 1;
        padding: 10px;
        font-size: 13px;
    }

    .producto-imagen {
        width: 80px;
        height: 80px;
    }
}
</style>
</head>

<body>
<?php include("../includes/header.php"); ?>
<?php include("../includes/includeVendedor.php"); ?>

<div class="contenedor">
    <h1>Lista de Productos</h1>

<?php
$sql = "SELECT * FROM productos ORDER BY codigo ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
?>
    <div class="tabla-scroll">
        <table>
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

<?php
    while ($fila = $result->fetch_assoc()) {
        $codigo = urlencode($fila['codigo']);
        $archivoImagen = "../img/" . $fila['imagen'];
        $stock = (int)$fila['stock'];
        $claseStock = ($stock <= 5) ? "stock-bajo" : "stock-ok";
?>
            <tr>
                <td data-label="Código"><?php echo htmlspecialchars($fila['codigo']); ?></td>
                <td data-label="Nombre"><?php echo htmlspecialchars($fila['nombre']); ?></td>
                <td data-label="Descripción"><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                <td data-label="Precio">Bs <?php echo htmlspecialchars($fila['precio']); ?></td>
                <td data-label="Costo">Bs <?php echo htmlspecialchars($fila['costo']); ?></td>
                <td data-label="Stock">
                    <span class="stock <?php echo $claseStock; ?>"><?php echo $stock; ?></span>
                </td>
                <td data-label="Imagen">
<?php if (!empty($fila['imagen']) && file_exists($archivoImagen)) { ?>
                    <img
                        src="<?php echo htmlspecialchars($archivoImagen); ?>"
                        alt="<?php echo htmlspecialchars($fila['nombre']); ?>"
                        class="producto-imagen">
<?php } else { ?>
                    <span>No imagen</span>
<?php } ?>
                </td>
                <td data-label="Acciones">
                    <div class="acciones">
                        <a class="btn editar" href="../productos/18.formeditarproductos.php?codigo=<?php echo $codigo; ?>">
                            <i class="fa-solid fa-pen"></i>
                            Editar
                        </a>
                        <a class="btn eliminar" href="../productos/20.eliminarproductos.php?codigo=<?php echo $codigo; ?>" onclick="return confirm('¿Está seguro de eliminar este producto?');">
                            <i class="fa-solid fa-trash"></i>
                            Eliminar
                        </a>
                    </div>
                </td>
            </tr>
<?php
    }
?>
        </table>
    </div>
<?php
} else {
?>
    <p class="sin-datos">No hay productos registrados.</p>
<?php
}
?>
</div>

</body>
</html>
<?php
$conn->close();
?>