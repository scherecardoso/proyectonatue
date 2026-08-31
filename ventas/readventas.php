<?php

session_start();


// ==========================================
// CONEXIÓN
// ==========================================

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "shena"
);


if ($conexion->connect_error) {

    die("Error de conexión");

}


// ==========================================
// CONSULTAR VENTAS
// ==========================================

$sql = "
    SELECT *
    FROM ventas
    ORDER BY id DESC
";

$resultado = $conexion->query($sql);


?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>


<link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap"
    rel="stylesheet"
>

<link
    href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap"
    rel="stylesheet"
>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
>

<link
    href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap"
    rel="stylesheet"
>


<title>Historial de Ventas</title>


<style>

/* ==========================================
   BODY
========================================== */

body {

    display: grid;

    font-family: Arial, sans-serif;

    margin: 0;

    grid-template-areas:
        "barra barra"
        "menu-lateral contenido"
        "pie pie";

    grid-template-columns: 320px 1fr;

    grid-template-rows: 70px 1fr 70px;

    min-height: 100vh;

    gap: 5px;

    background: #f8f8f8;

}


/* ==========================================
   MENU LATERAL
========================================== */

.menu-lateral {

    grid-area: menu-lateral;

    display: flex;

    flex-direction: column;

    gap: 10px;

    background-color: #ffffff;

    padding: 15px;

    margin-top: 27px;

    width: 280px;

    border-right: 1px solid #ececec;

}


.menu-titulo {

    font-size: 15px;

    color: #ff5ca8;

    margin-bottom: 20px;

    text-transform: uppercase;

}


.menu-lateral a {

    text-decoration: none;

    color: black;

    padding: 15px;

    border-radius: 12px;

    font-size: 20px;

    transition: .3s;

    cursor: pointer;

    display: block;

}


.menu-lateral a:hover {

    background: #ffdcec;

    color: #ff5ca8;

    padding-left: 22px;

}


/* ==========================================
   CONTENIDO
========================================== */

.contenido {

    grid-area: contenido;

    padding: 40px;

}


/* ==========================================
   TITULO
========================================== */

.titulo {

    text-align: center;

    margin-bottom: 30px;

    color: #ff4f94;

    font-family: "Playfair Display", serif;

}


/* ==========================================
   CONTENEDOR DE VENTAS
========================================== */

.contenedorVentas {

    width: 100%;

    max-width: 900px;

    margin: 0 auto;

}


/* ==========================================
   CAJA DE CADA VENTA
========================================== */

.contenedor {

    background: white;

    padding: 25px;

    margin: 20px auto;

    max-width: 800px;

    border-radius: 15px;

    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);

    transition: .2s;

}


.contenedor:hover {

    transform: translateY(-2px);

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.09);

}


/* ==========================================
   TITULO DE LA VENTA
========================================== */

.contenedor h3 {

    margin-top: 0;

    padding-bottom: 15px;

    border-bottom: 1px solid #eeeeee;

}


/* ==========================================
   INFORMACIÓN
========================================== */

.informacion {

    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 20px;

    margin-top: 20px;

}


/* ==========================================
   DATO
========================================== */

.dato {

    display: flex;

    flex-direction: column;

    gap: 6px;

}


.dato strong {

    font-size: 13px;

    color: #888;

    text-transform: uppercase;

}


.dato span {

    font-size: 16px;

    color: #333;

}


/* ==========================================
   ESTADO
========================================== */

.estado {

    display: inline-block;

    width: fit-content;

    padding: 6px 12px;

    border-radius: 20px;

    background: #f4d6e2;

    color: #a33c67;

    font-size: 14px !important;

}


/* ==========================================
   RESPONSIVE
========================================== */

@media (max-width: 700px) {

    body {

        display: block;

    }


    .menu-lateral {

        width: auto;

        margin-top: 0;

    }


    .contenido {

        padding: 20px;

    }


    .informacion {

        grid-template-columns: 1fr;

    }

}

</style>

</head>


<body>


<?php include("../includes/header.php"); ?>


<!-- ==========================================
     MENU
========================================== -->

<aside class="menu-lateral">
  <a class="menu-titulo"><h2>Menu Vendedor</h2></a>
  <a href="../vendedor/07.vendedor.php"><i class="fa-solid fa-house"></i> Inicio</a>
  <a href="../productos/16.formproductos.php"><i class="fa-solid fa-cart-shopping"></i> Registrar Productos</a>
  <a href="../productos/22.readproductos.php"><i class="fa-solid fa-box"></i> Stock de Productos</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-truck"></i> Pedidos de Clientes</a>
  <a href="../ventas/readventas.php"><i class="fa-solid fa-history"></i> Historial de Ventas</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-info-circle"></i> Estado de Pedidos</a>
  <a href=""><i class="fa-solid fa-user"></i> Mi perfil</a>
  <a href="../auth/26.cerrarsesion.php">Cerrar Sesión</a>
</aside>



<!-- ==========================================
     CONTENIDO
========================================== -->

<main class="contenido">


    <h1 class="titulo">

        Historial de Ventas

    </h1>


    <div class="contenedorVentas">


        <?php

        if ($resultado && $resultado->num_rows > 0) {

            while ($fila = $resultado->fetch_assoc()) {

        ?>


                <!-- ==================================
                     CAJA DE VENTA
                ================================== -->

                <div class="contenedor">


                    <h3>

                        Venta #

                        <?php echo htmlspecialchars($fila['id']); ?>

                    </h3>


                    <div class="informacion">


                        <div class="dato">

                            <strong>
                                Pedido
                            </strong>

                            <span>

                                #

                                <?php
                                echo htmlspecialchars(
                                    $fila['pedidos_id']
                                );
                                ?>

                            </span>

                        </div>


                        <div class="dato">

                            <strong>
                                Costo
                            </strong>

                            <span>

                                Bs

                                <?php
                                echo htmlspecialchars(
                                    $fila['costo']
                                );
                                ?>

                            </span>

                        </div>


                        <div class="dato">

                            <strong>
                                Método
                            </strong>

                            <span>

                                <?php
                                echo htmlspecialchars(
                                    $fila['metodo']
                                );
                                ?>

                            </span>

                        </div>


                        <div class="dato">

                            <strong>
                                Estado
                            </strong>

                            <span class="estado">

                                <?php
                                echo htmlspecialchars(
                                    $fila['estado']
                                );
                                ?>

                            </span>

                        </div>
                        <div class="dato">

                            <strong>
                                fecha
                            </strong>

                            <span class="fecha">

                                <?php
                                echo htmlspecialchars(
                                    $fila['fecha']
                                );
                                ?>

                            </span>

                        </div>

                    </div>


                </div>


        <?php

            }

        } else {

        ?>


            <div class="contenedor">

                <h3>
                    No hay ventas registradas
                </h3>

                <p>
                    Todavía no se han registrado ventas.
                </p>

            </div>


        <?php

        }

        ?>


    </div>


</main>


</body>

</html>


<?php

$conexion->close();

?>
