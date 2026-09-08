
<style>

body {
  display: grid; 
  font-family: Arial, sans-serif;
  margin: 0;
  grid-template-areas:
    "barra barra"
    "menu-lateral principal"
    "pie pie";
  grid-template-columns: 320px 1fr;
  grid-template-rows: 70px 1fr 70px;
  min-height: 100vh;
  gap: 5px;
}

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
@media (max-width: 768px) {
  body {
    grid-template-areas:
      "barra"
      "menu-lateral"
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

<body>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">

<aside class="menu-lateral">
  <a class="menu-titulo"><h2>Menu Vendedor</h2></a>
  <a href="../vendedor/07.vendedor.php"><i class="fa-solid fa-house"></i> Inicio</a>
  <a href="../productos/16.formproductos.php"><i class="fa-solid fa-cart-shopping"></i> Registrar Productos</a>
  <a href="../productos/22.readproductos.php"><i class="fa-solid fa-box"></i> Stock de Productos</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-truck"></i> Pedidos de Clientes</a>
  <a href="../ventas/readventas.php"><i class="fa-solid fa-history"></i> Historial de Ventas</a>
  <a href="../vendedor/reportesvendedor.php"><i class="fa-solid fa-chart-line"></i> Reportes</a>
  <a href="../pedidos/pedidosclientes.php"><i class="fa-solid fa-info-circle"></i> Estado de Pedidos</a>
  <a href=""><i class="fa-solid fa-user"></i> Mi perfil</a>
  <a href="../auth/26.cerrarsesion.php">Cerrar Sesión</a>
</aside>
</body>