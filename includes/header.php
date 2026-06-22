
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
.usuario-info{
    display:flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:#2b2b2b;
}

.nombre-usuario{
    font-size:14px;
    white-space:nowrap;
}
@media(max-width: 768px){
    header {
    padding: 20px;
    gap: 0px;
    height: 130px; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .iconos-barra {
    display: flex;
    flex-direction: row;
  }

  .iconos-barra a {
    display: flex;
    flex-direction: row;
    gap: -100px;
  }

}
</style>

<header>
  <div class="logo">
    <h1>Natué</h1>
  </div>

  <nav>
    <ul>
      <li><a href="../pagina/02.inicio.php">Inicio</a></li>
      <li><a href="../pagina/03.productos.php">Cuidado</a></li>
      <li><a href="../pagina/04.productos2.php">Cosmeticos</a></li>
      <li><a href="../pagina/05.acercade.php">Nosotros</a></li>
       <li><a href="../pagina/005.contactanos.php">Contactanos</a></li>
    </ul>
  </nav>

<div class="iconos-barra">

<a href="<?php

if(isset($_SESSION['rol'])){

    if($_SESSION['rol'] == 'administrador'){
        echo '../admin/06.admin.php';
    }

    elseif($_SESSION['rol'] == 'vendedor'){
        echo '../vendedor/07.vendedor.php';
    }

    else{
        echo '../usuario/08.usuario.php';
    }

}else{
    echo '../usuario/09.register.php';
}

?>" class="usuario-info">

    <i class="fa-solid fa-user"></i>

    <span class="nombre-usuario">
        <?php
        if(isset($_SESSION['nombre'])){
            echo $_SESSION['nombre'];
        }else{
            echo 'Invitado';
        }
        ?>
    </span>

</a>

</a>
    <a href="../pedidos/1.formpedido.php">
        <i class="fa-solid fa-bag-shopping"></i>
    </a>

</div>
</header>
