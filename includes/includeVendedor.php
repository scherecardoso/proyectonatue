<style>

.menu-lateral {
  grid-area: menu;
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
  color: #f7b5d4;
  margin-bottom: 20px;
  text-transform: uppercase;
}

.menu-lateral a{
  text-decoration: none;
  color: black;
  padding: 15px;
  border-radius: 12px;
  font-size: 20px;
  transition: .3s;
  cursor: pointer;
  display: block;
}
.menu-lateral a:hover{
  background: #ffe4ec;
  color: #f7a1c9;
  padding-left: 22px;
}

.reportes-menu {
    width: 100%;
}

.boton-reportes {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    cursor: pointer;
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
}

.boton-reportes:hover {
    background: #ffe4ec;
    color: #f7a1c9;
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

@media (max-width: 768px) {
  body {
    grid-template-areas:
      "barra"
      "menu"
      "principal"
      "pie";
    grid-template-columns: 1fr;
    grid-template-rows: auto;
  }

  .menu-lateral {
   display: none;
  }
}
</style>

<aside class="menu-lateral">
  <div class="menu-titulo"><h2>Menu Vendedor</h2></div>

  <a href="../vendedor/07.vendedor.php"><i class="fa-solid fa-house"></i> Inicio</a>
  <a href="../productos/16.formproductos.php"><i class="fa-solid fa-cart-shopping"></i> Registrar Productos</a>
  <a href="../productos/22.readproductos.php"><i class="fa-solid fa-box"></i> Stock de Productos</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-truck"></i> Pedidos de Clientes</a>
  <a href="../ventas/readventas.php"><i class="fa-solid fa-history"></i> Historial de Ventas</a>

  <div class="reportes-menu">
    <div class="boton-reportes" onclick="mostrarReportes()" role="button" tabindex="0" onkeydown="if(event.key==='Enter'||event.key===' '){mostrarReportes();}">
      <i class="fa-solid fa-chart-line"></i> Reportes
      <i id="flechaReportes" class="fa-solid fa-chevron-down flecha-reportes"></i>
    </div>

    <div id="submenuReportes" class="submenu-reportes">
      <a href="../reportes/graficoventas.php"><i class="fa-solid fa-money-bill"></i> Ventas totales del día</a>
      <a href="../reportes/graficoproductos.php"><i class="fa-solid fa-trophy"></i> Producto más vendido</a>
      <a href="../reportes/graficoingresos.php"><i class="fa-solid fa-chart-line"></i> Reporte de ingresos</a>
      <a href="../reportes/graficoclientes.php"><i class="fa-solid fa-user-group"></i> Cliente más frecuente</a>
    </div>
  </div>

  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-info-circle"></i> Estado de Pedidos</a>
  <a href="../auth/26.cerrarsesion.php">Cerrar Sesión</a>
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