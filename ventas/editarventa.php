<?php
// Inicia la sesión para poder comprobar el rol del usuario que solicita esta página.
session_start();

// Solo los usuarios administradores tienen permiso para editar ventas.
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "administrador") {
    die("Acceso denegado");
}

// Abre la conexión con la base de datos del proyecto.
$conexion = new mysqli("localhost", "root", "", "shena");

// Detiene la ejecución si no se pudo establecer la conexión.
if ($conexion->connect_error) {
    die("Error de conexión");
}

// Obtiene de la URL el identificador de la venta que se quiere editar.
$id = $_GET['id'] ?? null;

// No se puede buscar ni editar una venta sin recibir su identificador.
if ($id == null) {
    die("No se recibió el ID de la Venta");
}

// Busca en la tabla ventas el registro correspondiente al identificador recibido.
$sql = "SELECT * FROM ventas WHERE id='$id'";
$resultado = $conexion->query($sql);

// Si existe la venta, guarda los datos que se mostrarán en el formulario.
if ($resultado->num_rows > 0) {

    $fila = $resultado->fetch_assoc();

    $costo = $fila['costo'];
    $metodo = $fila['metodo'];
    $estado = $fila['estado'];

} else {
    // Informa que el identificador no corresponde a ninguna venta registrada.
    die("Venta no encontrada");
}
?>

<!-- Estructura del documento y contenido visual del formulario de edición. -->
<!DOCTYPE html>
<html lang="es">

<head>

<!-- Define la codificación de caracteres y adapta la página a dispositivos móviles. -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Carga una fuente decorativa y los iconos usados junto a los campos. -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<!-- jQuery y su complemento de validación para comprobar el formulario en el navegador. -->
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


<!-- Título que aparece en la pestaña del navegador. -->
<title>Editar Venta</title>

<!-- Estilos propios de esta página: formulario compacto con detalles rosados. -->
<style>

/* Normaliza márgenes y rellenos, y usa el mismo modelo de caja en todos los elementos. */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial;
}

/* Centra el formulario en la ventana y establece el fondo general. */
body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ffffff;
}

/* Caja principal que agrupa el título, los campos y los enlaces. */
.contenedor {
    width: 360px;
    padding: 25px;
    border-radius: 18px;
    background: rgba(255,255,255,0.6);
    border: 2px solid #f8c6e5;
}

/* Presentación del encabezado principal del formulario. */
h2 {
    text-align: center;
    font-size: 22px;
    color: #222;
    margin-bottom: 8px;
}

/* Estilo del texto que muestra el número de venta. */
p {
    text-align: center;
    font-size: 13px;
    color: #222;
    margin-bottom: 20px;
}

/* Cada campo usa este contenedor para ubicar el icono sobre el lado izquierdo. */
.campo {
    position: relative;
    display: block;
    margin-bottom: 12px;
}

/* Coloca los iconos dentro de los campos, antes del texto o valor. */
.campo i {
    position: absolute;
    left: 12px;
    top: 12px;
    color: #f5a3d5;
}

/* Apariencia común para las cajas de texto y la lista desplegable. */
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

/* Resalta el campo activo para indicar que el usuario lo ha seleccionado. */
.campo input:focus,
.campo select:focus {
    border-color: #ed8fc9;
}

/* Diferencia visualmente el costo, que se muestra solo como lectura. */
.campo input[readonly] {
    background: #f8f8f8;
    color: #888;
}

/* Estilo del botón que envía los cambios al servidor. */
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

/* Efecto visual al pasar el cursor sobre el botón de actualización. */
button:hover {
    transform: scale(1.03);
    background: #f765c6;
}

/* Estilo del enlace para regresar a la lista de ventas. */
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

/* Cambia el fondo del enlace al pasar el cursor sobre él. */
.volver:hover {
    background: #fff3f9;
}

</style>

</head>

<body>

<!-- Contenedor visible del formulario para modificar los datos permitidos de la venta. -->
<div class="contenedor">

    <!-- Encabezado que identifica la operación actual. -->
    <h2>Editar Venta</h2>

    <!-- Muestra el identificador de la venta usando escape HTML para evitar insertar marcado. -->
    <p>Venta Nro. <?php echo htmlspecialchars($id); ?></p>

    <!-- Envía los cambios al archivo de actualización mediante una solicitud POST. -->
    <form  id="formEditarVenta" action="updateventa.php" method="POST">

        <!-- El servidor necesita el identificador para saber qué venta debe actualizar. -->
        <input
            type="hidden"
            name="id"
            value="<?php echo htmlspecialchars($id); ?>"
        >

        <!-- El costo se presenta, pero no se permite modificarlo desde este formulario. -->
        <label class="campo">

            <i class="fa-solid fa-money-bill"></i>

            <input
                type="number"
                name="costo"
                value="<?php echo htmlspecialchars($costo); ?>"
                readonly
            >

        </label>


        <!-- Campo editable para indicar el método de pago de la venta. -->
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


        <!-- Selector de los estados disponibles para la venta. -->
        <label class="campo">

            <i class="fa-solid fa-clock"></i>

            <select name="estado" required>

                <option value="En proceso"
                    <?php echo ($estado == "En proceso") ? "selected" : ""; ?>>
                    En proceso
                </option>

                <option value="Entregado"
                    <?php echo ($estado == "Entregado") ? "selected" : ""; ?>>
                    Entregado
                </option>

            </select>

        </label>


        <!-- Envía el formulario una vez que el usuario termina la edición. -->
        <button type="submit">
            Actualizar Venta
        </button>

    </form>


    <!-- Permite cancelar la edición y volver al listado administrativo de ventas. -->
    <a href="../admin/ventasypedidos.php" class="volver">
        Volver a Ventas
    </a>

</div>

<script>
// Espera a que el documento esté listo antes de preparar la validación del formulario.
$(document).ready(function(){

    // Configura reglas para comprobar los campos antes de enviarlos al servidor.
    $("#formEditarVenta").validate({

        // El método de pago es obligatorio y debe contener al menos tres caracteres.
        rules:{
            metodo:{
                required:true,
                minlength:3
            },
            estado:{
                required:true
            }
        },

        // Mensajes en español que se muestran cuando algún campo no cumple las reglas.
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
// Cierra la conexión a la base de datos una vez generada la página.
$conexion->close();
?>