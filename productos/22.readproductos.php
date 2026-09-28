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
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

<style>

body {
  display: grid; 
  font-family: Arial, sans-serif;
  margin: 0;
  grid-template-areas:
    "barra barra"
    "menu-lateral contenido";
  grid-template-columns: 320px 1fr;
  grid-template-rows: 70px 1fr 70px;
  min-height: 100vh;
  gap: 5px;
}




.contenedor{
    grid-area:contenido;
    width:90%;
    max-width:1200px;
    margin:40px auto;
    background:white;
    padding:35px;
    border-radius:28px;
    box-shadow:0 10px 35px rgba(0,0,0,0.08);
    border:1px solid #f3f3f3;
}

.contenedor h1 {
    text-align: center;
    margin-top: 0;
    margin-bottom: 30px;
    color: #ff5ca8;
    font-family: "Playfair Display", serif;
}

table{
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

@media (max-width:768px){

body{
    display:flex;
    flex-direction:column;
}

.menu{
    width:100%;
    border-right:none;
}

.contenedor{
    width:95%;
    padding:15px;
    margin:20px auto;
}

table{
    font-size:12px;
}

th,
td{
    padding:10px;
}

h1{
    font-size:28px;
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
    while($fila = $result->fetch_assoc()) {

    $codigo = $fila['codigo'];
    $archivoImagen = "../img/" . $fila['imagen'];
    $stock = (int)$fila['stock'];

    if ($stock <= 5) {
        $colorStock = "#ff0000";
    } else {
        $colorStock = "#008000";
    }
?>

        <tr>
                    <td><?php echo htmlspecialchars($fila['codigo']); ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                    <td>Bs <?php echo htmlspecialchars($fila['precio']); ?></td>
                    <td>Bs <?php echo htmlspecialchars($fila['costo']); ?></td>

                    <td>
                        <span style="color:<?php echo $colorStock; ?>; font-weight:bold;">
                            <?php echo htmlspecialchars($stock); ?>
                        </span>
                    </td>

                    <td>


<?php if (!empty($fila['imagen']) && file_exists($archivoImagen)) { ?>
                        <img
                            src="<?php echo htmlspecialchars($archivoImagen); ?>"
                            alt="<?php echo htmlspecialchars($fila['nombre']); ?>"
                            class="producto-imagen">
<?php } else { ?>
                        <span>No imagen</span>
<?php } ?>
                    </td>


                    <td>
                        <div class="acciones">
                            <a
                                class="btn editar"
                                href="../productos/18.formeditarproductos.php?codigo=<?php echo $codigo; ?>">
                                <i class="fa-solid fa-pen"></i>
                                Editar
                            </a>

                            <a
                                class="btn eliminar"
                                href="../productos/20.eliminarproductos.php?codigo=<?php echo $codigo; ?>"
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

            </table>

<?php
} else {
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
$conn->close();
?>
