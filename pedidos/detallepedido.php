<?php

session_start();

require("../ajax/php/conexion.php");

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != "vendedor"){
    echo "Acceso denegado";
    exit();
}

if(!isset($_GET['id']) || empty($_GET['id'])){
    echo "No se recibió el número del pedido";
    exit();
}

$idPedido = intval($_GET['id']);
$sqlPedido = "SELECT *FROM pedidosWHERE id = '$idPedido'";
$resultadoPedido = $conn->query($sqlPedido);

if(!$resultadoPedido || $resultadoPedido->num_rows == 0){
    echo "Pedido no encontrado";
    exit();
}

$pedido = $resultadoPedido->fetch_assoc();


$sqlProductos = "SELECT
    p.codigo,
    p.nombre,
    p.precio,
    c.cantidad,
    c.costototal
FROM carrito c
INNER JOIN productos p
    ON c.productos_codigo = p.codigo
WHERE c.pedidos_id = '$idPedido'
";

$resultadoProductos = $conn->query($sqlProductos);
$total = 0;

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del pedido</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Arial, Helvetica, sans-serif;
            background:#f5f5f5;
            color:#444;
            padding:20px 15px;
        }

        .detalle{
            width:850px;
            max-width:100%;
            margin:auto;
            background:#fff;
            border:1px solid #ddd;
            border-radius:10px;
            padding:20px;
        }

        .cabecera{
            display:flex;
            justify-content:space-between;
            align-items:center;
            border-bottom:1px solid #ddd;
            padding-bottom:10px;
            margin-bottom:15px;
        }

        .cabecera h1{
            font-size:23px;
            font-weight:600;
            color:#3f3f3f;
        }

        .numero{
            font-size:13px;
            color:#777;
        }

        .informacion{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:2px 20px;
            margin-bottom:18px;
        }

        .informacion p{
            font-size:13px;
            color:#666;
            padding:2px 0;
        }

        .informacion strong{
            color:#444;
        }

        .productos h2{
            font-size:18px;
            font-weight:600;
            color:#444;
            margin-bottom:10px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#ededed;
            color:#555;
            font-size:12px;
            font-weight:600;
            padding:9px 7px;
            border-bottom:1px solid #d5d5d5;
            text-align:center;
        }

        th:nth-child(2){
            text-align:left;
        }

        td{
            padding:9px 7px;
            font-size:13px;
            color:#555;
            border-bottom:1px solid #ededed;
            text-align:center;
        }

        td:nth-child(2){
            text-align:left;
        }

        tr:last-child td{
            border-bottom:none;
        }

        .total{
            display:flex;
            justify-content:flex-end;
            align-items:center;
            gap:7px;
            margin-top:12px;
            padding-top:10px;
            border-top:1px solid #ddd;
            font-size:18px;
            font-weight:bold;
            color:#444;
        }

        .total span{
            font-size:13px;
            font-weight:normal;
            color:#777;
        }

        .acciones{
            margin-top:15px;
            padding-top:10px;
            border-top:1px solid #ddd;
        }

        .volver{
            display:inline-flex;
            align-items:center;
            gap:6px;
            text-decoration:none;
            background:#666;
            color:#fff;
            padding:8px 14px;
            border-radius:6px;
            font-size:13px;
        }

        .volver:hover{
            background:#555;
        }

        @media(max-width:650px){

            body{
                padding:12px 8px;
            }

            .detalle{
                padding:15px;
            }

            .cabecera{
                flex-direction:column;
                align-items:flex-start;
                gap:3px;
            }

            .informacion{
                grid-template-columns:1fr;
            }

            .productos{
                overflow-x:auto;
            }

            table{
                min-width:600px;
            }
        }

    </style>

</head>

<body>

<div class="detalle">

    <div class="cabecera">

        <h1>Detalle del pedido</h1>

        <span class="numero">
            Pedido #<?php echo $pedido['id']; ?>
        </span>

    </div>


    <div class="informacion">

        <p>
            <strong>Cliente:</strong>
            <?php echo htmlspecialchars($pedido['nombre']); ?>
        </p>

        <p>
            <strong>Teléfono:</strong>
            <?php echo htmlspecialchars($pedido['telefono']); ?>
        </p>

        <p>
            <strong>Dirección:</strong>
            <?php echo htmlspecialchars($pedido['direccion']); ?>
        </p>

        <p>
            <strong>Estado:</strong>
            <?php echo htmlspecialchars($pedido['estado']); ?>
        </p>

    </div>


    <div class="productos">

        <h2>Productos</h2>

        <table>

            <thead>

                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>

            </thead>

            <tbody>

                <?php

                if($resultadoProductos && $resultadoProductos->num_rows > 0){

                    while($producto = $resultadoProductos->fetch_assoc()){

                        $subtotal = (float)$producto['costototal'];

                        $total += $subtotal;

                ?>

                    <tr>

                        <td>
                            <?php echo $producto['codigo']; ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($producto['nombre']); ?>
                        </td>

                        <td>
                            Bs <?php echo number_format($producto['precio'],2); ?>
                        </td>

                        <td>
                            <?php echo $producto['cantidad']; ?>
                        </td>

                        <td>
                            Bs <?php echo number_format($subtotal,2); ?>
                        </td>

                    </tr>

                <?php

                    }

                }else{

                ?>

                    <tr>

                        <td colspan="5">
                            No hay productos en este pedido.
                        </td>

                    </tr>

                <?php

                }

                ?>

            </tbody>

        </table>


        <div class="total">

            <span>Total:</span>

            Bs <?php echo number_format($total,2); ?>

        </div>

    </div>


    <div class="acciones">

        <a
            href="../vendedor/07.vendedor.php"
            class="volver"
        >

            <i class="fa-solid fa-arrow-left"></i>

            Volver

        </a>

    </div>

</div>

</body>

</html>