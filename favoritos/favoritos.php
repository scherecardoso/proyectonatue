
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
        INNER JOIN productos
        ON favoritos.codigo = productos.codigo
        WHERE favoritos.CI = '$CI'";

$resultado = $conn->query($sql);
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
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f8f8f8;
}

.contenedor {
    width: 90%;
    max-width: 1200px;
    margin: 50px auto;
}

h1 {
    text-align: center;
    font-family: 'Playfair Display', serif;
    font-size: 40px;
    margin-bottom: 40px;
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
    box-shadow: 0 4px 15px rgba(0,0,0,0.10);
}

.producto img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 15px;
}

.producto h3 {
    margin: 10px 0;
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
    margin: 40px auto;
    padding: 14px;
    background: #ff5ca8;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 25px;
}

.sin-favoritos {
    text-align: center;
    font-size: 20px;
    color: #777;
}

</style>

</head>

<body>

<?php include("../includes/header.php"); ?>

<div class="contenedor">

<h1>Mis Favoritos ♥</h1>

<div class="lista-favoritos">

<?php

if ($resultado && $resultado->num_rows > 0) {

    while ($fila = $resultado->fetch_assoc()) {

?>

<div class="producto">

    <img src="../img/<?php echo $fila['imagen']; ?>"
         alt="<?php echo $fila['nombre']; ?>">

    <h3>
        <?php echo $fila['nombre']; ?>
    </h3>

    <p>
        Código: <?php echo $fila['codigo']; ?>
    </p>

    <p class="precio">
        <?php echo $fila['precio']; ?> Bs
    </p>

    <div class="corazon">
        ♥
    </div>

</div>

<?php

    }

} else {

    echo "<p class='sin-favoritos'>
            Todavía no tienes productos favoritos.
          </p>";

}

?>

</div>

<a class="volver" href="../pagina/03.productos.php">
    Volver a productos
</a>

</div>

</body>
</html>

<?php

$conn->close();

?>


