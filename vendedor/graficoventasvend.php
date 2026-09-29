<?php
session_start();

require("../ajax/php/conexion.php");

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../pagina/login.php");
    exit();
}

$rol = $_SESSION['rol'];

$fechaConsulta = date('Y-m-d');
if (isset($_GET['fecha']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['fecha']) && strtotime($_GET['fecha'])) {
    $fechaConsulta = $_GET['fecha'];
}

$stmt = $conn->prepare(
    "SELECT v.id, v.pedidos_id, v.costo, v.metodo, v.estado, p.nombre, p.fecha
     FROM ventas v
     INNER JOIN pedidos p ON v.pedidos_id = p.id
     WHERE p.fecha = ? AND v.estado = 'Entregado'
     ORDER BY v.id ASC"
);
$stmt->bind_param("s", $fechaConsulta);
$stmt->execute();
$ventas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$cantidad = count($ventas);
$total = 0;
$etiquetasGrafico = [];
$ingresosGrafico = [];

foreach ($ventas as $v) {
    $total += (float) $v['costo'];
    $etiquetasGrafico[] = "Venta " . $v['id'];
    $ingresosGrafico[] = (float) $v['costo'];
}

$ventasTabla = array_reverse($ventas);
$fechaMostrar = date("d/m/Y", strtotime($fechaConsulta));
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ventas totales del día</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
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
    padding: 40px;
    min-width: 0;
}

.titulo {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    margin: 0 0 10px;
    color: #ff5ca8;
}

.fecha {
    color: #777;
    margin-bottom: 20px;
}

.filtro {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.filtro input[type="date"] {
    padding: 9px 12px;
    border: 1px solid #ddd;
    border-radius: 10px;
    font-size: 14px;
    color: #555;
}

.filtro button {
    padding: 10px 18px;
    border: none;
    border-radius: 10px;
    background: #ff5ca8;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
}

.filtro button:hover {
    background: #e64d96;
}

.tarjetas {
    display: flex;
    gap: 25px;
    margin-bottom: 35px;
    flex-wrap: wrap;
}

.tarjeta {
    background: white;
    width: 230px;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    transition: 0.3s;
}

.tarjeta:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(255, 92, 168, 0.15);
}

.tarjeta h3 {
    margin: 0 0 10px;
    font-size: 16px;
    color: #777;
}

.tarjeta p {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
    color: #ff5ca8;
}

.grafico-contenedor {
    background: white;
    padding: 28px;
    border-radius: 18px;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.07);
    margin-bottom: 35px;
    min-width: 0;
}

.grafico-contenedor h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
    margin-bottom: 25px;
    color: #333;
}

.grafico {
    position: relative;
    width: 100%;
    max-width: 900px;
    height: 350px;
    margin: auto;
}

.tabla-contenedor {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    min-width: 0;
}

.tabla-contenedor h2 {
    font-family: 'Playfair Display', serif;
    margin-top: 0;
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

tbody tr:hover td {
    background: #fff8fb;
}

.estado {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    background: #fff1f7;
    color: #ff5ca8;
    font-size: 13px;
    white-space: nowrap;
}

.sin-ventas {
    text-align: center;
    padding: 30px;
    color: #888;
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

    .titulo {
        font-size: 24px;
    }

    .tarjetas {
        gap: 12px;
    }

    .tarjeta {
        flex: 1 1 140px;
        width: auto;
        padding: 18px;
    }

    .tarjeta p {
        font-size: 22px;
    }

    .grafico-contenedor,
    .tabla-contenedor {
        padding: 16px;
    }

    .grafico {
        height: 260px;
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
        margin-bottom: 16px;
        background: #ffffff;
        border: 1px solid #f3d5e2;
        border-radius: 18px;
        padding: 8px 14px;
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

<main class="contenido">

    <h1 class="titulo">Ventas totales del día</h1>
    <div class="fecha"><?php echo htmlspecialchars($fechaMostrar); ?></div>

    <form class="filtro" method="get">
        <input type="date" name="fecha" value="<?php echo htmlspecialchars($fechaConsulta); ?>">
        <button type="submit">Ver día</button>
    </form>

    <div class="tarjetas">
        <div class="tarjeta">
            <h3>Ventas realizadas</h3>
            <p><?php echo $cantidad; ?></p>
        </div>

        <div class="tarjeta">
            <h3>Total vendido</h3>
            <p>Bs <?php echo number_format($total, 2); ?></p>
        </div>
    </div>

    <div class="grafico-contenedor">
        <h2>Ingresos de las ventas del día</h2>
        <div class="grafico">
            <canvas id="graficoVentas"></canvas>
        </div>
    </div>

    <div class="tabla-contenedor">
        <h2>Ventas registradas del día</h2>

<?php if ($cantidad > 0) { ?>
        <div class="tabla-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID Venta</th>
                        <th>Pedido</th>
                        <th>Cliente</th>
                        <th>Método de pago</th>
                        <th>Estado del pedido</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($ventasTabla as $venta) { ?>
                    <tr>
                        <td data-label="ID Venta"><?php echo htmlspecialchars($venta['id']); ?></td>
                        <td data-label="Pedido"><?php echo htmlspecialchars($venta['pedidos_id']); ?></td>
                        <td data-label="Cliente"><?php echo htmlspecialchars($venta['nombre']); ?></td>
                        <td data-label="Método"><?php echo htmlspecialchars($venta['metodo']); ?></td>
                        <td data-label="Estado">
                            <span class="estado"><?php echo htmlspecialchars($venta['estado']); ?></span>
                        </td>
                        <td data-label="Total">Bs <?php echo number_format((float) $venta['costo'], 2); ?></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div>
<?php } else { ?>
        <div class="sin-ventas">No hay ventas registradas para esta fecha.</div>
<?php } ?>
    </div>

</main>

<script>
const ventas = <?php echo json_encode($etiquetasGrafico); ?>;
const ingresos = <?php echo json_encode($ingresosGrafico); ?>;

new Chart(document.getElementById("graficoVentas"), {
    type: "line",
    data: {
        labels: ventas,
        datasets: [{
            label: "Ventas (Bs)",
            data: ingresos,
            borderColor: "#ff5ca8",
            backgroundColor: "rgba(255,92,168,0.15)",
            borderWidth: 3,
            pointBackgroundColor: "#ff5ca8",
            pointBorderColor: "#ffffff",
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: "#333",
                callbacks: {
                    label: function(context) {
                        return " Bs " + context.parsed.y.toFixed(2);
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: "rgba(0,0,0,0.06)" },
                title: { display: true, text: "Ingresos en Bs" }
            },
            x: {
                grid: { display: false },
                title: { display: true, text: "Ventas realizadas" }
            }
        }
    }
});
</script>

</body>
</html>
<?php
$conn->close();
?>