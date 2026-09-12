
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
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
    font-size: 15px;
    color: #ff5ca8;
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

@media (max-width: 768px) {
    .menu-lateral {
        width: 100%;
        margin-top: 0;
        border-right: none;
    }
}
</style>
</head>

<body>

<aside class="menu-lateral">

    <a class="menu-titulo">
        <h2>Menú Vendedor</h2>
    </a>

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

    <a href="../pedidos/pedidosclientes.php">
        <i class="fa-solid fa-info-circle"></i>
        Estado de Pedidos
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

</body>
</html>

