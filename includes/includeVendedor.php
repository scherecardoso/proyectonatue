<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

<style>

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
    font-size: 22px;
    color: #000000;
    margin-bottom: 20px;
    text-transform: uppercase;
}

.menu-titulo h2 {
    margin: 0;
}

.menu-lateral > a {
    text-decoration: none;
    color: black;
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
    cursor: pointer;
    display: block;
}

.menu-lateral > a:hover {
    background: #ffdcec;
    color: #ff5ca8;
    padding-left: 22px;
}

.reportes-menu {
    width: 100%;
    position: relative;
}

.boton-reportes {
    text-decoration: none;
    color: black;
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
}

.boton-reportes:hover {
    background: #ffdcec;
    color: #ff5ca8;
    padding-left: 22px;
}

.flecha-reportes {
    margin-left: auto;
    font-size: 14px;
}

.submenu-reportes {
    display: none;
    flex-direction: column;
    margin-left: 15px;
    margin-top: 3px;
    gap: 4px;
}

.submenu-reportes.activo {
    display: flex;
}

.submenu-reportes a {
    text-decoration: none;
    color: #555555;
    padding: 11px 12px;
    border-radius: 10px;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 9px;
    transition: .3s;
}

.submenu-reportes a:hover {
    background: #fff0f6;
    color: #ff5ca8;
    padding-left: 17px;
}


@media (max-width: 1199px) {

    .menu-lateral {
        flex-direction: row;
        flex-wrap: wrap;             
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
        margin-top: 0;
        padding: 8px 10px;
        border-right: none;
        border-bottom: 1px solid #eeeeee;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        position: relative;
        z-index: 50;
    }

    .menu-titulo {
        display: none;                 
    }

    .menu-lateral > a,
    .boton-reportes {
        padding: 9px 14px;
        font-size: 14px;
        white-space: nowrap;
    }

    .menu-lateral > a:hover,
    .boton-reportes:hover {
        padding-left: 14px;            
    }

    .menu-lateral i {
        margin-right: 6px;
        font-size: 14px;
    }

    .boton-reportes {
        gap: 0;
    }

    .reportes-menu {
        width: auto;
    }

    .flecha-reportes {
        margin-left: 8px;
        margin-right: 0 !important;
        font-size: 11px;
    }

    .submenu-reportes {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 240px;
        margin: 4px 0 0;
        padding: 8px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        z-index: 100;
    }

    .submenu-reportes a {
        white-space: nowrap;
    }

    .submenu-reportes a i {
        margin-right: 0;
    }

    .submenu-reportes a:hover {
        padding-left: 12px;
    }
}


@media (max-width: 600px) {
    .menu-lateral {
        gap: 4px;
        padding: 6px 6px;
    }

    .menu-lateral > a,
    .boton-reportes {
        padding: 8px 10px;
        font-size: 12px;
    }

    .menu-lateral > a:hover,
    .boton-reportes:hover {
        padding-left: 10px;
    }

    .menu-lateral i {
        margin-right: 4px;
        font-size: 12px;
    }

    .submenu-reportes {
        min-width: 210px;
    }

    .submenu-reportes a {
        font-size: 13px;
    }
}
</style>

<aside class="menu-lateral">

    <div class="menu-titulo">
        <h2>Menú Vendedor</h2>
    </div>

    <a href="../vendedor/07.vendedor.php">
        <i class="fa-solid fa-house"></i>
        Inicio
    </a>

    <a href="../productos/16.formproductos.php">
        <i class="fa-solid fa-cart-shopping"></i>
        Registrar Productos
    </a>

    <a href="../productos/22.readproductos.php">
        <i class="fa-solid fa-box"></i>
        Stock de Productos
    </a>

    <a href="../pedidos/pedidosclientes.php">
        <i class="fa-solid fa-truck"></i>
        Pedidos de Clientes
    </a>

    <a href="../ventas/readventas.php">
        <i class="fa-solid fa-history"></i>
        Historial de Ventas
    </a>

    <div class="reportes-menu">

        <div class="boton-reportes" onclick="mostrarReportesVendedor()">
            <i class="fa-solid fa-chart-line"></i>
            Reportes
            <i id="flechaReportesVendedor" class="fa-solid fa-chevron-down flecha-reportes"></i>
        </div>

        <div id="submenuReportesVendedor" class="submenu-reportes">

            <a href="../vendedor/graficoventasvend.php">
                <i class="fa-solid fa-money-bill"></i>
                Ventas totales del día
            </a>

            <a href="../vendedor/graficoproductosvend.php">
                <i class="fa-solid fa-trophy"></i>
                Producto más vendido
            </a>

            <a href="../vendedor/graficoingresosvend.php">
                <i class="fa-solid fa-chart-line"></i>
                Reporte de ingresos
            </a>

            <a href="../vendedor/graficoclientesvend.php">
                <i class="fa-solid fa-user-group"></i>
                Cliente más frecuente
            </a>

        </div>
    </div>

    <a href="../auth/26.cerrarsesion.php">
        <i class="fa-solid fa-right-from-bracket"></i>
        Cerrar Sesión
    </a>

</aside>

<script>
function mostrarReportesVendedor() {
    let submenu = document.getElementById("submenuReportesVendedor");
    let flecha = document.getElementById("flechaReportesVendedor");

    if (submenu.classList.contains("activo")) {
        submenu.classList.remove("activo");
        flecha.classList.remove("fa-chevron-up");
        flecha.classList.add("fa-chevron-down");
    } else {
        submenu.classList.add("activo");
        flecha.classList.remove("fa-chevron-down");
        flecha.classList.add("fa-chevron-up");
    }
}


</script>