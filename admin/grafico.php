<?php
session_start();
require("../ajax/php/conexion.php");

$periodo = $_GET['periodo'] ?? 'dia';

$labels = [];
$ingresos = [];
$titulo = "";

if ($periodo == "dia") {

    $titulo = "Ingresos por día";

    $sql = " SELECT 
            p.fecha AS periodo,
            SUM(v.costo) AS ingresos
        FROM ventas v
        INNER JOIN pedidos p ON v.pedidos_id = p.id
        WHERE p.fecha IS NOT NULL
        GROUP BY p.fecha
        ORDER BY p.fecha ASC
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {

            $labels[] = date("d/m/Y", strtotime($fila['periodo']));
            $ingresos[] = (float)$fila['ingresos'];

        }
    }

} elseif ($periodo == "semana") {

    $titulo = "Ingresos por semana";

    $sql = "
        SELECT 
            YEAR(p.fecha) AS anio,
            WEEK(p.fecha, 1) AS semana,
            SUM(v.costo) AS ingresos
        FROM ventas v
        INNER JOIN pedidos p ON v.pedidos_id = p.id
        WHERE p.fecha IS NOT NULL
        GROUP BY YEAR(p.fecha), WEEK(p.fecha, 1)
        ORDER BY anio ASC, semana ASC
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {

            $labels[] = "Semana " . $fila['semana'] . " - " . $fila['anio'];
            $ingresos[] = (float)$fila['ingresos'];

        }
    }



} elseif ($periodo == "mes") {

    $titulo = "Ingresos por mes";

    $sql = "
        SELECT 
            YEAR(p.fecha) AS anio,
            MONTH(p.fecha) AS mes,
            SUM(v.costo) AS ingresos
        FROM ventas v
        INNER JOIN pedidos p ON v.pedidos_id = p.id
        WHERE p.fecha IS NOT NULL
        GROUP BY YEAR(p.fecha), MONTH(p.fecha)
        ORDER BY anio ASC, mes ASC
    ";

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

            $labels[] = $meses[(int)$fila['mes']] . " " . $fila['anio'];
            $ingresos[] = (float)$fila['ingresos'];

        }
    }



} elseif ($periodo == "anio") {

    $titulo = "Ingresos por año";

    $sql = "
        SELECT 
            YEAR(p.fecha) AS anio,
            SUM(v.costo) AS ingresos
        FROM ventas v
        INNER JOIN pedidos p ON v.pedidos_id = p.id
        WHERE p.fecha IS NOT NULL
        GROUP BY YEAR(p.fecha)
        ORDER BY anio ASC
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        while ($fila = $resultado->fetch_assoc()) {

            $labels[] = $fila['anio'];
            $ingresos[] = (float)$fila['ingresos'];

        }
    }



} else {

    $periodo = "dia";
    $titulo = "Ingresos por día";

}



$sqlTotal = " SELECT 
        SUM(v.costo) AS total
    FROM ventas v
    INNER JOIN pedidos p ON v.pedidos_id = p.id
    WHERE p.fecha IS NOT NULL
";

$resultadoTotal = $conn->query($sqlTotal);
$totalIngresos = 0;

if ($resultadoTotal) {

    $filaTotal = $resultadoTotal->fetch_assoc();
    $totalIngresos = (float)($filaTotal['total'] ?? 0);

}

?>

<div class="reporte-ingresos">
<h3><?php echo $titulo; ?></h3>

<div class="botones-periodo">

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

<div class="total-ingresos">
    <span>Ingresos totales:</span>
    <strong>
        Bs <?php echo number_format($totalIngresos, 2); ?>
    </strong>
</div>|
<div class="contenedor-grafico">

    <canvas id="graficoIngresos"></canvas>

</div>

<style>

.reporte-ingresos {
    width: 100%;
    margin: 20px auto;
}

.reporte-ingresos h3 {
    margin-bottom: 15px;
}


.botones-periodo {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.botones-periodo a {
    text-decoration: none;
    padding: 8px 18px;
    border: 1px solid #999;
    border-radius: 5px;
    color: #333;
    background: #fff;
    cursor: pointer;
}

.botones-periodo a:hover {
    background: #eee;
}

.botones-periodo a.activo {
    background: #333;
    color: #fff;
}


.total-ingresos {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 15px;
    margin-bottom: 20px;

    border: 1px solid #ddd;
    border-radius: 8px;
}

.total-ingresos strong {
    font-size: 22px;
}



.contenedor-grafico {
    width: 100%;
    height: 400px;
}

</style>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const etiquetasIngresos = <?php echo json_encode($labels); ?>;
const datosIngresos = <?php echo json_encode($ingresos); ?>;
const ctxIngresos = document.getElementById('graficoIngresos');
new Chart(ctxIngresos, {

    type: 'line',

    data: {

        labels: etiquetasIngresos,

        datasets: [{

            label: 'Ingresos (Bs)',

            data: datosIngresos,

            borderWidth: 3,

            tension: 0.3,

            fill: false,

            pointRadius: 5

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        scales: {

            y: {

                beginAtZero: true,

                title: {

                    display: true,

                    text: 'Ingresos en Bs'

                }

            },

            x: {

                title: {

                    display: true,

                    text: '<?php echo $titulo; ?>'

                }

            }

        },

        plugins: {

            legend: {

                display: true

            },

            tooltip: {

                callbacks: {

                    label: function(context) {

                        return 'Bs ' + Number(context.raw).toFixed(2);

                    }

                }

            }

        }

    }

});

</script>
