<?php
session_start();

require("../ajax/php/conexion.php");

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../usuario/09.register.php");
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

$nombres = [];
$cantidades = [];

$productoMasVendido = "Sin ventas";
$cantidadMayor = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $nombres[] = $fila['nombre'];
        $cantidades[] = (int)$fila['cantidad_vendida'];

        if ((int)$fila['cantidad_vendida'] > $cantidadMayor) {
            $cantidadMayor = (int)$fila['cantidad_vendida'];
            $productoMasVendido = $fila['nombre'];
        }
    }
}

$mesActual = date("F Y");
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
    grid-template-columns: 198px 1fr 260px;
    grid-template-rows: 70px 1fr;
    grid-template-areas:
        "barra barra barra"
        "menu-lateral contenido contenido";
    gap: 10px;
    min-height: 100vh;
    background: #ffffff;
}

.contenido {
    grid-area: contenido;
    padding: 30px;
    box-sizing: border-box;
    width: 80%;
    min-width: 0;
    margin-left: 10%;
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
    margin-bottom: 30px;
}

.titulo h1 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: 32px;
    font-weight: 600;
    color: #222222;
}

.titulo p {
    margin: 8px 0 0;
    font-family: "Quicksand", sans-serif;
    font-size: 15px;
    color: #777777;
}

.mes {
    background: #f8e6ee;
    color: #d94f87;
    padding: 10px 18px;
    border-radius: 20px;
    font-family: "Quicksand", sans-serif;
    font-size: 14px;
    font-weight: 600;
}

.resumen {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-bottom: 30px;
}

.tarjeta {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 32px;
    min-height: 170px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
    display: flex;
    flex-direction: column;
    justify-content: center;
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
}

.tarjeta .numero {
    font-size: 16px;
    color: #d94f87;
    font-weight: 600;
}

.grafico {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
    margin-bottom: 30px;
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
    height: 520px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.grafico-contenido canvas {
    max-width: 650px;
    max-height: 500px;
}

.tabla-contenedor {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
}

.tabla-titulo {
    margin-bottom: 20px;
}

.tabla-titulo h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: 24px;
    font-weight: 600;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #f7f7f7;
    padding: 15px;
    text-align: left;
    font-size: 14px;
    color: #555555;
    font-weight: 600;
}

td {
    padding: 15px;
    border-bottom: 1px solid #eeeeee;
    font-size: 14px;
}

tr:hover td {
    background: #fff8fb;
}

.numero-tabla {
    color: #d94f87;
    font-weight: 600;
}

.sin-ventas {
    color: #999999;
}

@media (max-width: 900px) {
    .contenido {
        padding: 30px;
    }
    .resumen {
        grid-template-columns: 1fr;
    }
    .encabezado {
        align-items: flex-start;
        gap: 15px;
        flex-direction: column;
    }
    .grafico-contenido {
        height: 450px;
    }
}
</style>
</head>
<body>

<?php
include("../includes/header.php");
include("../includes/includeVendedor.php");
?>

<div class="contenido">
    <div class="contenedor">

        <div class="encabezado">
            <div class="titulo">
                <h1>Productos más vendidos</h1>
                <p>Productos vendidos durante el mes actual</p>
            </div>
            <div class="mes"><?php echo $mesActual; ?></div>
        </div>

        <div class="resumen">

            <div class="tarjeta">
                <div class="etiqueta">Producto más vendido</div>
                <div class="valor"><?php echo htmlspecialchars($productoMasVendido); ?></div>
                <div class="numero"><?php echo $cantidadMayor; ?> unidades vendidas</div>
            </div>

            <div class="tarjeta">
                <div class="etiqueta">Total de productos registrados</div>
                <div class="valor"><?php echo count($nombres); ?></div>
                <div class="numero">Productos en el reporte</div>
            </div>

        </div>

        <div class="grafico">
            <div class="titulo-grafico">
                <h2>Ventas por producto</h2>
                <p>Cantidad de unidades vendidas durante el mes</p>
            </div>
            <div class="grafico-contenido">
                <canvas id="graficoProductos"></canvas>
            </div>
        </div>

        <div class="tabla-contenedor">
            <div class="tabla-titulo">
                <h2>Detalle de productos</h2>
            </div>

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
                    <?php
                    if ($resultado) {
                        $resultado->data_seek(0);
                        $contador = 1;

                        while ($fila = $resultado->fetch_assoc()) {
                            $cantidad = (int)$fila['cantidad_vendida'];

                            echo "<tr>";
                            echo "<td>" . $contador . "</td>";
                            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
                            echo "<td>" . htmlspecialchars($fila['codigo']) . "</td>";

                            if ($cantidad > 0) {
                                echo "<td class='numero-tabla'>" . $cantidad . " unidades</td>";
                            } else {
                                echo "<td class='sin-ventas'>Sin ventas</td>";
                            }

                            echo "</tr>";
                            $contador++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
const nombres = <?php echo json_encode($nombres); ?>;
const cantidades = <?php echo json_encode($cantidades); ?>;

const ctx = document.getElementById("graficoProductos");

new Chart(ctx, {
    type: "pie",
    data: {
        labels: nombres,
        datasets: [{
            data: cantidades,
            backgroundColor: [
                "#ff5ca8", "#ff8fc2", "#ffc0d9", "#f5d6e3",
                "#d9d9d9", "#bdbdbd", "#a5a5a5", "#8d8d8d"
            ],
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
                position: "right",
                labels: {
                    padding: 18,
                    usePointStyle: true,
                    font: {
                        size: 13
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

</body>
</html>