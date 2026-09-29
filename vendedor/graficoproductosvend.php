<?php
session_start();

require("../ajax/php/conexion.php");

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../pagina/login.php");
    exit();
}

$rol = $_SESSION['rol'];

$sql = "SELECT
            p.codigo,
            p.nombre,
            COALESCE(vm.cantidad_vendida, 0) AS cantidad_vendida
        FROM productos p
        LEFT JOIN (
            SELECT
                c.productos_codigo,
                SUM(c.cantidad) AS cantidad_vendida
            FROM carrito c
            INNER JOIN ventas v ON c.pedidos_id = v.pedidos_id
            INNER JOIN pedidos pe ON v.pedidos_id = pe.id
            WHERE MONTH(pe.fecha) = MONTH(CURDATE())
            AND YEAR(pe.fecha) = YEAR(CURDATE())
            GROUP BY c.productos_codigo
        ) vm ON p.codigo = vm.productos_codigo
        ORDER BY cantidad_vendida DESC, p.nombre ASC";

$resultado = $conn->query($sql);

$productos = [];
$nombresGrafico = [];
$cantidadesGrafico = [];
$productoMasVendido = "Sin ventas";
$cantidadMayor = 0;

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $cantidad = (int) $fila['cantidad_vendida'];
        $productos[] = [
            'codigo' => $fila['codigo'],
            'nombre' => $fila['nombre'],
            'cantidad' => $cantidad
        ];

        if ($cantidad > 0) {
            $nombresGrafico[] = $fila['nombre'];
            $cantidadesGrafico[] = $cantidad;
        }

        if ($cantidad > $cantidadMayor) {
            $cantidadMayor = $cantidad;
            $productoMasVendido = $fila['nombre'];
        }
    }
}

$meses = [
    1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril",
    5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto",
    9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"
];
$mesActual = $meses[(int) date("n")] . " " . date("Y");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Productos más vendidos</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 320px minmax(0, 1fr);
    grid-template-rows: 88px 1fr;
    grid-template-areas:
        "barra barra"
        "menu-lateral contenido";
    gap: 5px;
    min-height: 100vh;
    background: #ffffff;
}

.contenido {
    grid-area: contenido;
    padding: 30px;
    min-width: 0;
}

.contenedor {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.encabezado {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 30px;
}

.titulo h1 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: 32px;
    font-weight: 600;
    color: #ff5ca8;
}

.titulo p {
    margin: 8px 0 0;
    font-family: "Quicksand", sans-serif;
    font-size: 15px;
    color: #777777;
}

.mes {
    background: #fff1f7;
    color: #ff5ca8;
    padding: 10px 18px;
    border-radius: 20px;
    font-family: "Quicksand", sans-serif;
    font-size: 14px;
    font-weight: 600;
    white-space: nowrap;
}

.resumen {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.tarjeta {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 32px;
    min-height: 170px;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-width: 0;
}

.tarjeta .etiqueta {
    font-family: "Quicksand", sans-serif;
    font-size: 15px;
    color: #777777;
    margin-bottom: 12px;
}

.tarjeta .valor {
    font-family: "Playfair Display", serif;
    font-size: 28px;
    font-weight: 600;
    color: #2b2b2b;
    margin-bottom: 6px;
    word-break: break-word;
}

.tarjeta .numero {
    font-size: 16px;
    color: #ff5ca8;
    font-weight: 600;
}

.grafico {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
    margin-bottom: 30px;
    min-width: 0;
}

.titulo-grafico {
    margin-bottom: 25px;
}

.titulo-grafico h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: 24px;
    font-weight: 600;
}

.titulo-grafico p {
    margin: 6px 0 0;
    color: #888888;
    font-size: 14px;
}

.grafico-contenido {
    position: relative;
    width: 100%;
    height: 460px;
}

.sin-datos {
    text-align: center;
    padding: 40px 10px;
    color: #999999;
}

.tabla-contenedor {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
    min-width: 0;
}

.tabla-titulo {
    margin-bottom: 20px;
}

.tabla-titulo h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: 24px;
    font-weight: 600;
    color: #ff5ca8;
}

.tabla-scroll {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #fff1f7;
    padding: 15px;
    text-align: left;
    font-size: 14px;
    color: #ff5ca8;
    font-weight: 600;
}

td {
    padding: 15px;
    border-bottom: 1px solid #f3f3f3;
    border-top: 1px solid #f3f3f3;
    font-size: 14px;
    background: #ffffff;
    word-break: break-word;
}

tbody tr:hover td {
    background: #fff8fb;
}

.numero-tabla {
    color: #ff4f8b;
    font-weight: 600;
}

.sin-ventas {
    color: #999999;
}

@media (max-width: 1199px) {
    body {
        grid-template-columns: minmax(0, 1fr);
        grid-template-rows: auto;
        grid-template-areas:
            "barra"
            "menu-lateral"
            "contenido";
        gap: 0;
    }

    .contenido {
        padding: 25px;
    }
}

@media (max-width: 768px) {
    .contenido {
        padding: 12px;
    }

    .encabezado {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .titulo h1 {
        font-size: 24px;
    }

    .resumen {
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }

    .tarjeta {
        min-height: 0;
        padding: 20px;
    }

    .tarjeta .valor {
        font-size: 22px;
    }

    .grafico,
    .tabla-contenedor {
        padding: 16px;
        margin-bottom: 20px;
    }

    .titulo-grafico h2,
    .tabla-titulo h2 {
        font-size: 20px;
    }

    .grafico-contenido {
        height: 380px;
    }

    .tabla-scroll {
        overflow-x: visible;
    }

    table,
    tbody {
        display: block;
        width: 100%;
    }

    thead {
        display: none;
    }

    tbody tr {
        display: block;
        margin-bottom: 14px;
        background: #ffffff;
        border: 1px solid #f3d5e2;
        border-radius: 18px;
        padding: 6px 14px;
        box-shadow: 0 4px 14px rgba(255, 92, 168, 0.08);
    }

    tbody tr:hover td {
        background: transparent;
    }

    td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 10px 0;
        border: none;
        border-bottom: 1px dashed #f3d5e2;
        background: transparent;
        text-align: right;
    }

    td:last-child {
        border-bottom: none;
    }

    td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #ff5ca8;
        text-align: left;
        flex-shrink: 0;
        max-width: 45%;
    }
}
</style>
</head>
<body>

<?php
include("../includes/header.php");

if ($rol == "administrador") {
    include("../includes/includeadmin.php");
} else {
    include("../includes/includeVendedor.php");
}
?>

<div class="contenido">
    <div class="contenedor">

        <div class="encabezado">
            <div class="titulo">
                <h1>Productos más vendidos</h1>
                <p>Productos vendidos durante el mes actual</p>
            </div>
            <div class="mes"><?php echo htmlspecialchars($mesActual); ?></div>
        </div>

        <div class="resumen">
            <div class="tarjeta">
                <div class="etiqueta">Producto más vendido</div>
                <div class="valor"><?php echo htmlspecialchars($productoMasVendido); ?></div>
                <div class="numero"><?php echo $cantidadMayor; ?> unidades vendidas</div>
            </div>

            <div class="tarjeta">
                <div class="etiqueta">Total de productos registrados</div>
                <div class="valor"><?php echo count($productos); ?></div>
                <div class="numero">Productos en el reporte</div>
            </div>
        </div>

        <div class="grafico">
            <div class="titulo-grafico">
                <h2>Ventas por producto</h2>
                <p>Cantidad de unidades vendidas durante el mes</p>
            </div>

<?php if (count($cantidadesGrafico) > 0) { ?>
            <div class="grafico-contenido">
                <canvas id="graficoProductos"></canvas>
            </div>
<?php } else { ?>
            <div class="sin-datos">Todavía no hay ventas este mes.</div>
<?php } ?>
        </div>

        <div class="tabla-contenedor">
            <div class="tabla-titulo">
                <h2>Detalle de productos</h2>
            </div>

<?php if (count($productos) > 0) { ?>
            <div class="tabla-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Código</th>
                            <th>Unidades vendidas</th>
                        </tr>
                    </thead>
                    <tbody>
<?php foreach ($productos as $indice => $producto) { ?>
                        <tr>
                            <td data-label="#"><?php echo $indice + 1; ?></td>
                            <td data-label="Producto"><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td data-label="Código"><?php echo htmlspecialchars($producto['codigo']); ?></td>
<?php if ($producto['cantidad'] > 0) { ?>
                            <td data-label="Unidades vendidas" class="numero-tabla"><?php echo $producto['cantidad']; ?> unidades</td>
<?php } else { ?>
                            <td data-label="Unidades vendidas" class="sin-ventas">Sin ventas</td>
<?php } ?>
                        </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
<?php } else { ?>
            <div class="sin-datos">No hay productos registrados.</div>
<?php } ?>
        </div>

    </div>
</div>

<?php if (count($cantidadesGrafico) > 0) { ?>
<script>
const nombres = <?php echo json_encode($nombresGrafico); ?>;
const cantidades = <?php echo json_encode($cantidadesGrafico); ?>;

const paleta = [
    "#ff5ca8", "#ff8fc2", "#ffc0d9", "#f5d6e3",
    "#fff5f8", "#e8dfe3", "#d9d9d9", "#bdbdbd", "#a5a5a5", "#8d8d8d"
];

const colores = nombres.map(function(_, i) {
    return paleta[i % paleta.length];
});

const esMovil = window.innerWidth <= 768;

new Chart(document.getElementById("graficoProductos"), {
    type: "pie",
    data: {
        labels: nombres,
        datasets: [{
            data: cantidades,
            backgroundColor: colores,
            borderColor: "#ffffff",
            borderWidth: 3,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: esMovil ? "bottom" : "right",
                labels: {
                    padding: esMovil ? 10 : 18,
                    usePointStyle: true,
                    font: {
                        size: esMovil ? 11 : 13
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ": " + context.raw + " unidades";
                    }
                }
            }
        }
    }
});
</script>
<?php } ?>

</body>
</html>
<?php
$conn->close();
?>