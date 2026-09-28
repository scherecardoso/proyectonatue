<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

<style>
.menu {
    grid-area: menu;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: #ffffff;
    padding: 15px;
    margin: 0;
    width: 330px;
    box-sizing: border-box;
    border-right: 3px solid #ececec;
    margin-top: 0;
}
 
.titulo-menu {
    font-size: 28px;
    color: #ff5ca8;
    margin-bottom: 10px;
    margin-left: 10px;
}
 
.menu > a > div,
.menu > div > div {
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
    cursor: pointer;
}
 
.menu a {
    text-decoration: none;
    color: black;
}
 
.menu i {
    color: black;
}
 
.reportes-menu {
    width: 100%;
    position: relative;
}
 
.boton-reportes {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
 
.flecha-reportes {
    margin-left: auto;
    font-size: 14px;
    transition: .3s;
}
 
.submenu-reportes {
    display: none;
    flex-direction: column;
    margin-top: 3px;
    padding-left: 10px;
    border-left: 2px solid #ffdcec;
}
 
.submenu-reportes.activo {
    display: flex;
}
 
.submenu-reportes a {
    text-decoration: none;
    color: #555;
    font-size: 15px;
    padding: 9px 10px;
    border-radius: 8px;
    transition: .3s;
}
 
.submenu-reportes a:hover {
    background: #fff0f7;
    color: #ff5ca8;
    padding-left: 15px;
}
 
.submenu-reportes i {
    font-size: 18px;
    color: #555;
}
 

@media (max-width: 1199px) {
 
    .menu {
        flex-direction: row;
        flex-wrap: wrap;              
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        min-width: 0;
        padding: 8px 10px;
        border-right: none;
        border-bottom: 1px solid #eeeeee;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        position: relative;
        z-index: 50;
    }
 
    .titulo-menu {
        display: none;                 
    }
 
    .menu > a > div,
    .menu > div > div {
        padding: 9px 14px;
        font-size: 14px;
        white-space: nowrap;
    }
 
    .menu > a > div:hover,
    .menu > div > div:hover {
        background: #fdeff6;
    }
 
    .menu > a > div:hover i,
    .menu > div > div:hover i {
        color: #ff5ca8;
    }
 
    .menu i {
        margin-right: 6px;
        font-size: 14px;
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
        margin-top: 4px;
        padding: 8px;
        background: #ffffff;
        border-left: none;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        z-index: 100;
    }
 
    .submenu-reportes a {
        white-space: nowrap;
    }
 
    .submenu-reportes a:hover {
        padding-left: 10px;
    }
}
 

@media (max-width: 600px) {
    .menu {
        gap: 4px;
        padding: 6px 6px;
    }
 
    .menu > a > div,
    .menu > div > div {
        padding: 8px 10px;
        font-size: 12px;
    }
 
    .menu i {
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

<aside class="menu">
    <div class="titulo-menu">MENU ADMINISTRADOR</div>

    <a href="../admin/06.admin.php">
        <div><i class="fa-solid fa-house"></i> Inicio</div>
    </a>

    <a href="../perfil/perfiladmin.php">
        <div><i class="fa-solid fa-user"></i> Mi Perfil</div>
    </a>

    <a href="../usuario/13.formeditarusuario.php">
        <div><i class="fa-solid fa-users"></i> Gestión de Usuarios</div>
    </a>

    <a href="../admin/gestionproductos.php">
        <div><i class="fa-solid fa-box"></i> Gestión de Productos</div>
    </a>




    <div class="reportes-menu">
        <div class="boton-reportes" onclick="mostrarReportes()">
            <i class="fa-solid fa-chart-line"></i>Reportes<i id="flechaReportes" class="fa-solid fa-chevron-down flecha-reportes"></i>
        </div>

        <div id="submenuReportes" class="submenu-reportes">
            <a href="../reportes/graficoventas.php"><i class="fa-solid fa-money-bill"></i> Ventas totales del día</a>
            <a href="../reportes/graficoproductos.php"><i class="fa-solid fa-trophy"></i> Producto más vendido</a>
            <a href="../reportes/graficoingresos.php"><i class="fa-solid fa-chart-line"></i> Reporte de ingresos</a>
            <a href="../reportes/graficoclientes.php"><i class="fa-solid fa-user-group"></i> Cliente más frecuente</a>
        </div>
    </div>

    <a href="../admin/ventasypedidos.php">
        <div><i class="fa-solid fa-cart-shopping"></i> Ventas y Pedidos</div>
    </a>

    <a href="../auth/26.cerrarsesion.php">
        <div><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</div>
    </a>
</aside>

<script>
function mostrarReportes() {
    let submenu = document.getElementById("submenuReportes");
    let flecha = document.getElementById("flechaReportes");

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