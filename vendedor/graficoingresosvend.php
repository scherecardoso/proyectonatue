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

    $sql = "SELECT
                YEAR(p.fecha) AS anio,
                SUM(v.costo) AS total_ingresos
            FROM ventas v
            INNER JOIN pedidos p ON v.pedidos_id = p.id
            WHERE p.fecha IS NOT NULL
            GROUP BY YEAR(p.fecha)
            ORDER BY anio ASC";

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


$sqlTotal = "SELECT
                SUM(v.costo) AS total
             FROM ventas v
             INNER JOIN pedidos p ON v.pedidos_id = p.id
             WHERE p.fecha IS NOT NULL";

$resultadoTotal = $conn->query($sqlTotal);

$totalIngresos = 0;

if ($resultadoTotal) {

    $filaTotal = $resultadoTotal->fetch_assoc();

    $totalIngresos = (float)($filaTotal["total"] ?? 0);

}


$sqlMetodos = "SELECT
                    v.metodo,
                    SUM(v.costo) AS total
               FROM ventas v
               INNER JOIN pedidos p ON v.pedidos_id = p.id
               WHERE p.fecha IS NOT NULL
               GROUP BY v.metodo
               ORDER BY total DESC";

$resultadoMetodos = $conn->query($sqlMetodos);

$metodos = [];
$totalesMetodos = [];

if ($resultadoMetodos) {

    while ($fila = $resultadoMetodos->fetch_assoc()) {

        $metodos[] = $fila["metodo"];
        $totalesMetodos[] = (float)$fila["total"];

    }
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





.encabezado {

    display: flex;

    justify-content: space-between;

    align-items: center;

    margin-bottom: 25px;
}


.titulo h1 {

    margin: 0;

    font-family: "Playfair Display", serif;

    font-size: 32px;

    font-weight: 600;

    color: #292929;
}


.titulo p {

    margin: 7px 0 0;

    color: #777;

    font-family: "Quicksand", sans-serif;

    font-size: 15px;
}


.badge {

    background: #f8e5ee;

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

    gap: 22px;

    margin-bottom: 25px;
}


.tarjeta {

    background: white;

    border: 1px solid #eeeeee;

    border-radius: 18px;

    padding: 30px;

    min-height: 155px;

    box-shadow: 0 5px 18px rgba(0,0,0,0.07);

    display: flex;

    flex-direction: column;

    justify-content: center;
}


.tarjeta-titulo {

    color: #777;

    font-family: "Quicksand", sans-serif;

    font-size: 15px;

    margin-bottom: 10px;
}


.tarjeta-valor {

    font-family: "Playfair Display", serif;

    font-size: 32px;

    font-weight: 600;

    color: #292929;
}


.tarjeta-sub {

    margin-top: 7px;

    color: #d94f87;

    font-size: 14px;

    font-weight: 600;
}


.botones {

    display: flex;

    justify-content: center;

    gap: 10px;

    margin-bottom: 25px;

    flex-wrap: wrap;
}


.botones a {

    text-decoration: none;

    color: #555;

    background: #ffffff;

    border: 1px solid #dddddd;

    padding: 11px 25px;

    border-radius: 25px;

    font-family: "Quicksand", sans-serif;

    font-size: 14px;

    font-weight: 600;

    transition: 0.2s;
}


.botones a:hover {

    background: #f8e5ee;

    color: #d94f87;

    border-color: #f0bfd2;
}


.botones a.activo {

    background: #d94f87;

    color: white;

    border-color: #d94f87;
}


.grafico-principal {

    background: white;

    border: 1px solid #eeeeee;

    border-radius: 18px;

    padding: 30px;

    box-shadow: 0 5px 18px rgba(0,0,0,0.07);

    margin-bottom: 25px;
}


.grafico-titulo {

    margin-bottom: 20px;
}


.grafico-titulo h2 {

    margin: 0;

    font-family: "Playfair Display", serif;

    font-size: 24px;

    font-weight: 600;

    color: #292929;
}


.grafico-titulo p {

    margin: 6px 0 0;

    color: #888;

    font-size: 14px;
}


.grafico {

    height: 390px;

    width: 100%;
}


.graficos-secundarios {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 25px;

    margin-bottom: 25px;
}


.grafico-metodo {

    background: white;

    border: 1px solid #eeeeee;

    border-radius: 18px;

    padding: 30px;

    box-shadow: 0 5px 18px rgba(0,0,0,0.07);
}


.grafico-metodo h2 {

    margin: 0;

    font-family: "Playfair Display", serif;

    font-size: 23px;

    font-weight: 600;
}


.grafico-metodo p {

    color: #888;

    font-size: 14px;

    margin: 7px 0 20px;
}


.grafico-dona {

    height: 330px;

    display: flex;

    justify-content: center;

    align-items: center;
}


.grafico-dona canvas {

    max-width: 100%;

    max-height: 320px;
}


.informacion {

    background: #fafafa;

    border-radius: 15px;

    padding: 25px;

}


.informacion h2 {

    margin: 0 0 15px;

    font-family: "Playfair Display", serif;

    font-size: 22px;
}


.dato {

    display: flex;

    justify-content: space-between;

    align-items: center;

    padding: 13px 0;

    border-bottom: 1px solid #e8e8e8;

    font-size: 14px;
}


.dato:last-child {

    border-bottom: none;
}


.dato strong {

    color: #d94f87;
}


.tabla-contenedor {

    background: white;

    border: 1px solid #eeeeee;

    border-radius: 18px;

    padding: 30px;

    box-shadow: 0 5px 18px rgba(0,0,0,0.07);

    margin-top: 25px;
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


.tabla-titulo p {

    margin: 6px 0 0;

    color: #888;

    font-size: 14px;
}


table {

    width: 100%;

    border-collapse: collapse;
}


th {

    background: #333333;

    color: white;

    padding: 15px;

    text-align: center;

    font-size: 14px;

    font-weight: 600;
}


td {

    padding: 15px;

    text-align: center;

    border-bottom: 1px solid #eeeeee;

    font-size: 14px;
}


tr:hover td {

    background: #fff8fb;
}


.ingreso {

    color: #d94f87;

    font-weight: 700;
}


@media (max-width: 1000px) {

    .contenido {

        padding: 20px;

    }

    .graficos-secundarios {

        grid-template-columns: 1fr;

    }

}


@media (max-width: 700px) {

    .resumen {

        grid-template-columns: 1fr;

    }

    .encabezado {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }

    .contenedor {

        width: 100%;

    }

    .grafico {

        height: 320px;

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

    include("../includes/includeVendedor.php");

}

?>


<main class="contenido">

<div class="contenedor">


<div class="encabezado">

    <div class="titulo">

        <h1>Reporte de ingresos</h1>

        <p>Consulta los ingresos obtenidos por las ventas registradas</p>

    </div>

    <div class="badge">

        Reporte de ventas

    </div>

</div>


<div class="resumen">


    <div class="tarjeta">

        <div class="tarjeta-titulo">

            Ingresos totales

        </div>

        <div class="tarjeta-valor">

            Bs <?php echo number_format($totalIngresos, 2); ?>

        </div>

        <div class="tarjeta-sub">

            Total registrado en ventas

        </div>

    </div>


    <div class="tarjeta">

        <div class="tarjeta-titulo">

            Periodo seleccionado

        </div>

        <div class="tarjeta-valor">

            <?php echo $titulo; ?>

        </div>

        <div class="tarjeta-sub">

            <?php echo count($periodos); ?> registros encontrados

        </div>

    </div>


</div>


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


<div class="grafico-principal">

    <div class="grafico-titulo">

        <h2><?php echo $titulo; ?></h2>

        <p>
            Evolución de los ingresos según las ventas registradas
        </p>

    </div>

    <div class="grafico">

        <canvas id="graficoIngresos"></canvas>

    </div>

</div>


<div class="graficos-secundarios">


    <div class="grafico-metodo">

        <h2>Ingresos por método de pago</h2>

        <p>
            Distribución de los ingresos según el método utilizado
        </p>

        <div class="grafico-dona">

            <canvas id="graficoMetodos"></canvas>

        </div>

    </div>


    <div class="informacion">

        <h2>Resumen del reporte</h2>

        <?php

        if(count($periodos) > 0){

            $mayorIngreso = max($ingresos);

            $posicionMayor = array_search($mayorIngreso, $ingresos);

        } else {

            $mayorIngreso = 0;

            $posicionMayor = false;

        }

        ?>


        <div class="dato">

            <span>Total de registros</span>

            <strong>
                <?php echo count($periodos); ?>
            </strong>

        </div>


        <div class="dato">

            <span>Mayor ingreso</span>

            <strong>
                Bs <?php echo number_format($mayorIngreso, 2); ?>
            </strong>

        </div>


        <div class="dato">

            <span>Periodo con mayor ingreso</span>

            <strong>

                <?php

                if($posicionMayor !== false){

                    echo htmlspecialchars($periodos[$posicionMayor]);

                } else {

                    echo "Sin datos";

                }

                ?>

            </strong>

        </div>


        <div class="dato">

            <span>Total general</span>

            <strong>
                Bs <?php echo number_format($totalIngresos, 2); ?>
            </strong>

        </div>


    </div>

</div>


<div class="tabla-contenedor">

    <div class="tabla-titulo">

        <h2>Detalle de ingresos</h2>

        <p>Ingresos agrupados según el periodo seleccionado</p>

    </div>


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

        if(count($periodos) > 0){

            for($i = 0; $i < count($periodos); $i++){

        ?>

        <tr>

            <td>
                <?php echo htmlspecialchars($periodos[$i]); ?>
            </td>

            <td class="ingreso">
                Bs <?php echo number_format($ingresos[$i], 2); ?>
            </td>

        </tr>

        <?php

            }

        } else {

        ?>

        <tr>

            <td colspan="2">
                No hay ingresos registrados.
            </td>

        </tr>

        <?php

        }

        ?>

    </table>

</div>


</div>

</main>


<script>

const periodos = <?php echo json_encode($periodos); ?>;

const ingresos = <?php echo json_encode($ingresos); ?>;

const metodos = <?php echo json_encode($metodos); ?>;

const totalesMetodos = <?php echo json_encode($totalesMetodos); ?>;


const contextoIngresos =
    document.getElementById("graficoIngresos");


new Chart(contextoIngresos, {

    type: "line",

    data: {

        labels: periodos,

        datasets: [{

            label: "Ingresos (Bs)",

            data: ingresos,

            borderColor: "#d94f87",

            backgroundColor: "rgba(217, 79, 135, 0.12)",

            borderWidth: 3,

            pointBackgroundColor: "#d94f87",

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

        interaction: {

            intersect: false,

            mode: "index"

        },

        plugins: {

            legend: {

                display: true

            },

            tooltip: {

                callbacks: {

                    label: function(context) {

                        return " Bs " +
                            Number(context.raw).toFixed(2);

                    }

                }

            }

        },

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


const contextoMetodos =
    document.getElementById("graficoMetodos");


new Chart(contextoMetodos, {

    type: "doughnut",

    data: {

        labels: metodos,

        datasets: [{

            data: totalesMetodos,

            backgroundColor: [

                "#d94f87",

                "#f28eb4",

                "#f7c4d7",

                "#bdbdbd",

                "#777777",

                "#444444"

            ],

            borderColor: "#ffffff",

            borderWidth: 3,

            hoverOffset: 10

        }]

    },

    options: {

        responsive: true,

        maintainAspectRatio: false,

        cutout: "58%",

        plugins: {

            legend: {

                position: "bottom",

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

                        return " " +
                            context.label +
                            ": Bs " +
                            Number(context.raw).toFixed(2);

                    }

                }

            }

        }

    }

});

</script>


</body>

</html>