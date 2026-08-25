<?php
session_start();

if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador") {
    die("Acceso denegado");
}

$conexion = new mysqli("localhost", "root", "", "shena");

if ($conexion->connect_error) {
    die("Error de conexión");
}

$id = $_GET['id'] ?? null;

if ($id == null) {
    die("No se recibió el ID de la Venta");
}

$sql = "SELECT * FROM ventas WHERE id='$id'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $costo = $fila['costo'];
    $metodo = $fila['metodo'];
    $estado = $fila['estado'];

} else {
    die("Venta no encontrada");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<title>Editar Venta</title>

<style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial;
}

body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ffffff;
}

.contenedor {
    width: 360px;
    padding: 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.6);
    border: 2px solid #f8c6e5;
}

h2 {
    text-align: center;
    font-size: 22px;
    color: #222;
    margin-bottom: 8px;
}

p {
    text-align: center;
    font-size: 13px;
    color: #222;
    margin-bottom: 20px;
}

.campo {
    position: relative;
    display: block;
    margin-bottom: 12px;
}

.campo i {
    position: absolute;
    left: 12px;
    top: 12px;
    color: #f5a3d5;
}

.campo input,
.campo select {
    width: 100%;
    padding: 10px 10px 10px 38px;
    border: 1px solid #f5a3d5;
    border-radius: 12px;
    outline: none;
    font-size: 14px;
    color: #444;
    background: #fff;
}

.campo input:focus,
.campo select:focus {
    border-color: #ed8fc9;
}

.campo input[readonly] {
    background: #f8f8f8;
    color: #888;
}

button {
    width: 100%;
    padding: 10px;
    border: 1px solid #f34bb3;
    border-radius: 12px;
    background: #f06ac3;
    color: #fff;
    margin-top: 5px;
    cursor: pointer;
}

button:hover {
    transform: scale(1.03);
    background: #f765c6;
}

.volver {
    display: block;
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #f5a3d5;
    border-radius: 12px;
    background: #fff;
    color: #d66ba9;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
}

.volver:hover {
    background: #fff3f9;
}

</style>

</head>

<body>

<div class="contenedor">

    <h2>Editar Venta</h2>

    <p>Venta Nro. <?php echo htmlspecialchars($id); ?></p>

    <form  id="formEditarVenta" action="updateventa.php" method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo htmlspecialchars($id); ?>"
        >

        <label class="campo">

            <i class="fa-solid fa-money-bill"></i>

            <input
                type="number"
                name="costo"
                value="<?php echo htmlspecialchars($costo); ?>"
                readonly
            >

        </label>


        <label class="campo">

            <i class="fa-solid fa-credit-card"></i>

            <input
                type="text"
                name="metodo"
                value="<?php echo htmlspecialchars($metodo); ?>"
                placeholder="Método de pago"
                required
            >

        </label>


        <label class="campo">

            <i class="fa-solid fa-clock"></i>

            <select name="estado" required>

                <option value="Pendiente"
                    <?php echo ($estado == "Pendiente") ? "selected" : ""; ?>>
                    Pendiente
                </option>

                <option value="Aceptado"
                    <?php echo ($estado == "Aceptado") ? "selected" : ""; ?>>
                    Aceptado
                </option>

                <option value="Rechazado"
                    <?php echo ($estado == "Rechazado") ? "selected" : ""; ?>>
                    Rechazado
                </option>

            </select>

        </label>


        <button type="submit">
            Actualizar Venta
        </button>

    </form>


    <a href="../admin/ventasypedidos.php" class="volver">
        Volver a Ventas
    </a>

</div>

<script>
$(document).ready(function(){

    $("#formEditarVenta").validate({

        rules:{
            metodo:{
                required:true,
                minlength:3
            },
            estado:{
                required:true
            }
        },

        messages:{
            metodo:{
                required:"Debes indicar el método de pago",
                minlength:"El método de pago debe tener al menos 3 caracteres"
            },
            estado:{
                required:"Debes seleccionar un estado"
            }
        }

    });

});
</script>

</body>

</html>

<?php
$conexion->close();
?>