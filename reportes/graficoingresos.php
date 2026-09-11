<?php
session_start();

if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], ["administrador", "vendedor"])) {
    header("Location: ../usuario/09.register.php");
    exit();
}

$rol = $_SESSION['rol'];
require("../ajax/php/conexion.php");
$periodo = $_GET['periodo'] ?? 'dia';
$periodos = [];
$ingresos = [];
$titulo = "";

if ($periodo == "dia") {
    $titulo = "Ingresos por día";
    $sql = "SELECT
                p.fecha,
                SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY p.fecha
            ORDER BY p.fecha ASC";

    $resultado = $conn->query($sql);
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {

            $periodos[] = date("d/m/Y", strtotime($fila["fecha"]));
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }
}

elseif ($periodo == "semana") {
    $titulo = "Ingresos por semana";
    $sql = "SELECT
                YEAR(p.fecha) AS anio,
                WEEK(p.fecha, 1) AS semana,
                SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha), WEEK(p.fecha, 1)
            ORDER BY anio ASC, semana ASC";
    $resultado = $conn->query($sql);
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $periodos[] = "Semana " . $fila["semana"] . " - " . $fila["anio"];
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }
}

elseif ($periodo == "mes") {
    $titulo = "Ingresos por mes";
    $sql = "SELECT
                YEAR(p.fecha) AS anio,
                MONTH(p.fecha) AS mes,
                SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha), MONTH(p.fecha)
            ORDER BY anio ASC, mes ASC";
    $resultado = $conn->query($sql);
    $meses = [
        1 => "Enero",
        2 => "Febrero",
        3 => "Marzo",
        4 => "Abril",
        5 => "Mayo",
        6 => "Junio",
        7 => "Julio",
        8 => "Agosto",
        9 => "Septiembre",
        10 => "Octubre",
        11 => "Noviembre",
        12 => "Diciembre"
    ];
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {

            $periodos[] = $meses[(int)$fila["mes"]] . " " . $fila["anio"];
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }
}


elseif ($periodo == "anio") {
    $titulo = "Ingresos por año";
    $sql = "SELECT YEAR(p.fecha) AS anio, SUM(v.costo) AS total_ingresos FROM ventas v INNER JOIN pedidos p ON v.pedidos_id = p.id WHERE p.fecha IS NOT NULL GROUP BY YEAR(p.fecha) ORDER BY anio ASC";
    $resultado = $conn->query($sql);
    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {
            $periodos[] = $fila["anio"];
            $ingresos[] = (float)$fila["total_ingresos"];
        }
    }
}


else {
    $periodo = "dia";
    $titulo = "Ingresos por día";
}

$sqlTotal = "SELECT SUM(v.costo) AS total FROM ventas v INNER JOIN pedidos p ON v.pedidos_id = p.id WHERE p.fecha IS NOT NULL";
$resultadoTotal = $conn->query($sqlTotal);
$totalIngresos = 0;

if ($resultadoTotal) {
    $filaTotal = $resultadoTotal->fetch_assoc();
    $totalIngresos = (float)($filaTotal["total"] ?? 0);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte de ingresos</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        "menu contenido contenido"; 

    gap: 10px; 
    min-height: 100vh; 
    background: #ffffff; 
}

.contenido {
    grid-area: contenido;
    padding: 30px;
    box-sizing: border-box;
    width: 100%;
    min-width: 0;
}
.contenedor {
    width: 90%;
    max-width: 1000px;
    margin: 30px auto;
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-sizing: border-box;
}

    h1 {
        text-align: center;
        margin-bottom: 25px;
    }

    .botones {
        text-align: center;
        margin-bottom: 25px;
    }

    .botones a {
        display: inline-block;
        padding: 10px 18px;
        margin: 5px;
        text-decoration: none;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: white;
    }

    .botones a:hover {
        background: #eeeeee;
    }

    .botones a.activo {
        background: #333;
        color: white;
    }

    .total {
        text-align: center;
        font-size: 20px;
        margin-bottom: 25px;
    }

    .grafico {
        width: 800px;
        max-width: 100%;
        margin: 30px auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
    }

    th {
        background: #333;
        color: white;
    }

    @media (max-width: 768px) {

        body {
            padding: 15px;
        }

        .contenedor {
            padding: 20px;
        }

    }

</style>

</head>

<body>

<?php include("../includes/header.php"); ?>

<?php
if ($rol == "administrador") {
    include("../includes/includeadmin.php");
} else {
    include("../includes/includevendedor.php");
}
?>

<main class="contenido">

<div class="contenedor">
    <h1>Reporte de ingresos</h1>
    <div class="botones">

        <a href="?periodo=dia"
           class="<?php echo ($periodo == 'dia') ? 'activo' : ''; ?>">
            Día
        </a>

        <a href="?periodo=semana"
           class="<?php echo ($periodo == 'semana') ? 'activo' : ''; ?>">
            Semana
        </a>

        <a href="?periodo=mes"
           class="<?php echo ($periodo == 'mes') ? 'activo' : ''; ?>">
            Mes
        </a>

        <a href="?periodo=anio"
           class="<?php echo ($periodo == 'anio') ? 'activo' : ''; ?>">
            Año
        </a>

    </div>

    <div class="total">

        <strong>
            Ingresos totales:
            Bs <?php echo number_format($totalIngresos, 2); ?>
        </strong>

    </div>

    <h2><?php echo $titulo; ?></h2>

    <div class="grafico">

        <canvas id="graficoIngresos"></canvas>

    </div>

    <h2>Detalle de ingresos</h2>

    <table>

        <tr>

            <th>
                Periodo
            </th>

            <th>
                Ingresos
            </th>

        </tr>


        <?php

        for ($i = 0; $i < count($periodos); $i++) {

        ?>

        <tr>
            <td><?php echo $periodos[$i]; ?></td>
            <td>Bs <?php echo number_format($ingresos[$i], 2); ?></td>
        </tr>

<?php
}

?>

    </table>

</div>


<script>
    const periodos =
        <?php echo json_encode($periodos); ?>;
    const ingresos =
        <?php echo json_encode($ingresos); ?>;
    const contexto =
        document.getElementById("graficoIngresos");
    new Chart(contexto, {
        type: "line",
        data: {
            labels: periodos,
            datasets: [{
                label: "Ingresos (Bs)",
                data: ingresos,
                tension: 0.3,
                fill: false
            }]

        },

        options: {
            responsive: true,
            scales: {

                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Ingresos en Bs"
                    }
                },

                x: {
                    title: {
                        display: true,
                        text: "<?php echo $titulo; ?>"

                    }

                }

            }

        }

    });

</script>
</main>
</body>

</html>