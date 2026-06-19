<style>
header {
  grid-area: barra;
  background-color: #ffffffb5;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 120px;
  top: 0;
  position: sticky;
  height: 60px;
  z-index: 100;
}

.logo {
  font-family: 'Playfair Display', serif;
  font-size: 13px;
  color: #000000;
  margin: 0;
}

nav {
  display: flex;
  align-items: center;
  gap: 40px;
}

nav ul {
  list-style: none;
  display: flex;
  gap: 25px;
  margin: 0;
  padding: 0;
}

nav a {
  text-decoration: none;
  color: #2b2b2b;
  font-weight: 500;
  font-size: 15px;
  position: relative;
}

nav a.activo::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -6px;
  width: 100%;
  height: 1px;
  background-color: #333333;
}

.iconos-barra {
  display: flex;
  align-items: center;
  gap: 25px;
}

.iconos-barra a {
  color: #2b2b2b;
  font-size: 18px;
  position: relative;
}
</style>

<header>
  <div class="logo">
    <h1>Natué</h1>
  </div>

  <nav>
    <ul>
      <li><a href="02.inicio.php" class="activo">Inicio</a></li>
      <li><a href="03.productos.php">Cuidado</a></li>
      <li><a href="04.productos2.php">Cosmeticos</a></li>
      <li><a href="05.acercade.php">Nosotros</a></li>
    </ul>
  </nav>

  <div class="iconos-barra">
    <a href="09.register.php">
      <i class="fa-solid fa-user"></i>
    </a>

    <a href="16.formproductos.php">
      <i class="fa-solid fa-bag-shopping"></i>
    </a>
  </div>
</header>
