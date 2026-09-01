<?php
session_start();

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ['administrador', 'vendedor'])) {
    header("Location: ../pagina/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "shena");

if ($conn->connect_error) {
    die("Error de conexión");
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
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">


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


.contenido {
    grid-area: contenido;
    display: flex;
    justify-content: center;
    padding: 40px 30px;
}


.icono {
    width: 50px;
    height: 50px;
    background: #ffdcec;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icono i {
    color: #ff5ca8;
    font-size: 20px;
}

.contenedor {
    width: 90%;
    max-width: 1150px;
    margin: 20px auto;
    background: #fff;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 35px rgba(0,0,0,.08);
    border: 1px solid #f3f3f3;
}


.contenedor h1 {
    text-align: center;
    margin-top: 0;
    margin-bottom: 30px;
    color: #ff5ca8;
    font-family: "Playfair Display", serif;
}

.tabla-contenedor {
    width: 100%;
    overflow-x: auto;
}

h2{
    font-size: 35px;
}

p{
    font-size: 20px;
}

div{
  color: black;
}

i{
    color:black;
}

table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
    text-decoration: none;
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
    background: #fff;
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

.producto-imagen {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #eee;
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
.menu a {
    text-decoration: none;
    color: inherit;
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

@media (max-width: 900px) {
    body {
        display: flex;
        flex-direction: column;
    }

    .menu {
        width: 100%;
        margin-top: 0;
        border-right: none;
        border-bottom: 1px solid #ececec;
    }

    .contenido {
        padding: 15px;
    }

    .contenedor {
        width: 100%;
        padding: 20px;
    }
}

</style>
</head>

<body>

<?php include("../includes/header.php"); ?>
<?php include("../includes/includeadmin.php"); ?>

<main class="contenido">

    <div class="contenedor">

        <h1>Lista de Productos</h1>

        <div class="tabla-contenedor">

<?php

$sql = "SELECT * FROM productos ORDER BY codigo ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {

?>

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

    $codigo = $fila['codigo'];
    $archivoImagen = "../img/" . $fila['imagen'];

?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($fila['codigo']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($fila['nombre']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($fila['descripcion']); ?>
                    </td>

                    <td>
                        Bs <?php echo htmlspecialchars($fila['precio']); ?>
                    </td>

                    <td>
                        Bs <?php echo htmlspecialchars($fila['costo']); ?>
                    </td>


                    
                    <td>
<?php
    $stock = (int)$fila['stock'];

    if ($stock <= 5) {
        $colorStock = "#ff0000";
    } else {
        $colorStock = "#008000";
    }
?>
                        <span style="color:<?php echo $colorStock; ?>; font-weight:bold;">
                            <?php echo htmlspecialchars($stock); ?>
                        </span>
                    </td>

                    <td>

<?php if (!empty($fila['imagen']) && file_exists($archivoImagen)) { ?>

                        <img
                            src="<?php echo htmlspecialchars($archivoImagen); ?>"
                            alt="<?php echo htmlspecialchars($fila['nombre']); ?>"
                            class="producto-imagen"
                        >

<?php } else { ?>

                        <span>No imagen</span>

<?php } ?>

                    </td>

                    <td>

                        <div class="acciones">

                            <a
                                class="btn editar"
                                href="../productos/18.formeditarproductos.php?codigo=<?php echo $codigo; ?>"
                            >
                                <i class="fa-solid fa-pen"></i>
                                Editar
                            </a>

                            <a
                                class="btn eliminar"
                                href="../productos/20.eliminarproductos.php?codigo=<?php echo $codigo; ?>"
                                onclick="return confirm('¿Está seguro de eliminar este producto?');"
                            >
                                <i class="fa-solid fa-trash"></i>
                                Eliminar
                            </a>

                        </div>

                    </td>

                </tr>

<?php } ?>

            </table>

<?php } else { ?>

            <p class="sin-datos">No hay productos registrados.</p>

<?php } ?>

        </div>

    </div>

</main>

</body>
</html>

<?php
$conn->close();
?>
