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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        "menu  contenido";
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
            "contenido";
    }
}


/* =========================
   CONTENIDO
========================== */
.contenido {
    grid-area: contenido;
    padding: clamp(15px, 3vw, 30px);
    box-sizing: border-box;
    width: 100%;
    min-width: 0;
}

.contenedor {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.encabezado {
    display: flex;
    flex-wrap: wrap;                 /* el mes baja debajo del título si no cabe */
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 30px;
}

.titulo h1 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: clamp(26px, 4vw, 32px);
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
}


/* =========================
   TARJETAS RESUMEN (se acomodan solas)
========================== */
.resumen {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(100%, 260px), 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.tarjeta {
    min-width: 0;
    box-sizing: border-box;
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: clamp(20px, 3vw, 32px);
    min-height: 150px;
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
    font-size: clamp(22px, 3.5vw, 28px);
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


/* =========================
   GRÁFICO
========================== */
.grafico {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: clamp(18px, 3vw, 30px);
    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
    margin-bottom: 30px;
    min-width: 0;
    box-sizing: border-box;
}

.titulo-grafico {
    margin-bottom: 25px;
}

.titulo-grafico h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: clamp(20px, 3vw, 24px);
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
    max-width: 750px;
    height: 480px;
    margin: 0 auto;
}


/* =========================
   TABLA
========================== */
.tabla-contenedor {
    background: #ffffff;
    border: 1px solid #eeeeee;
    border-radius: 18px;
    padding: clamp(18px, 3vw, 30px);
    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
    min-width: 0;
    box-sizing: border-box;
}

.tabla-titulo {
    margin-bottom: 20px;
}

.tabla-titulo h2 {
    margin: 0;
    font-family: "Playfair Display", serif;
    font-size: clamp(20px, 3vw, 24px);
    font-weight: 600;
    color: #ff5ca8;
}

.tabla-scroll {
    width: 100%;
    overflow-x: auto;
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

tr:hover td {
    background: #fff8fb;
}

.numero-tabla {
    color: #ff4f8b;
    font-weight: 600;
}

.sin-ventas {
    color: #999999;
}


/* =========================
   TABLET (900px o menos)
========================== */
@media (max-width: 900px) {
    .grafico-contenido {
        height: 420px;
    }
}


/* =========================
   CELULAR (600px o menos)
========================== */
@media (max-width: 600px) {
    .contenido {
        padding: 15px 12px;
    }

    .encabezado {
        margin-bottom: 20px;
    }

    .resumen {
        gap: 15px;
        margin-bottom: 20px;
    }

    .grafico,
    .tabla-contenedor {
        margin-bottom: 20px;
        border-radius: 14px;
    }

    .grafico-contenido {
        height: 400px;          /* más alto porque la leyenda pasa abajo */
    }

    th,
    td {
        padding: 10px 8px;
    }
}
</style>
</head>
<body>

<?php
include("../includes/header.php");
include("../includes/includeadmin.php");
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
</div>

<script>
const nombres = <?php echo json_encode($nombres); ?>;
const cantidades = <?php echo json_encode($cantidades); ?>;

const ctx = document.getElementById("graficoProductos");

/* La leyenda va a la derecha en pantallas anchas y abajo en celular */
function posicionLeyenda() {
    return window.innerWidth < 700 ? "bottom" : "right";
}

const grafico = new Chart(ctx, {
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
                position: posicionLeyenda(),
                labels: {
                    padding: 14,
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

window.addEventListener("resize", function () {
    const nueva = posicionLeyenda();
    if (grafico.options.plugins.legend.position !== nueva) {
        grafico.options.plugins.legend.position = nueva;
        grafico.update();
    }
});
</script>

</body>
</html>