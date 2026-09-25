<style>

header {
  grid-area: barra;
  background-color: #ffffffb5;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  padding: 15px 6%;
  top: 0;
  position: sticky;
  height: 60px;
  z-index: 100;
  box-sizing: border-box;
  width: 100%;
  flex-wrap: wrap;
}

.logo {
  font-family: 'Playfair Display', serif;
  font-size: 13px;
  color: #000000;
  margin: 0;
}


/* =========================
   MENU PRINCIPAL
========================= */

nav {
  display: flex;
  align-items: center;
  gap: 40px;
  flex: 1 1 320px;
  justify-content: center;
  min-width: 0;
}

nav ul {
  list-style: none;
  display: flex;
  gap: 25px;
  margin: 0;
  padding: 0;
  flex-wrap: wrap;
  justify-content: center;
}

nav li {
  position: relative;
}

nav a {
  text-decoration: none;
  color: #2b2b2b;
  font-weight: 500;
  font-size: 15px;
  position: relative;
}


/* =========================
   SUBMENUS
========================= */

.submenu {
  position: absolute;

  top: 100%;
  left: 50%;

  transform: translateX(-50%) translateY(10px);

  min-width: 170px;

  background: white;

  padding: 10px 0;

  border-radius: 10px;

  box-shadow: 0 5px 20px rgba(0,0,0,.12);

  display: block;

  opacity: 0;
  visibility: hidden;

  transition: all .2s ease;

  z-index: 200;
}


/* Mostrar submenu al pasar el mouse */

nav li:hover > .submenu {
  opacity: 1;
  visibility: visible;

  transform: translateX(-50%) translateY(0);
}


/* Elementos del submenu */

.submenu li {
  width: 100%;
}

.submenu a {
  display: block;

  padding: 10px 18px;

  font-size: 14px;

  color: #333;

  white-space: nowrap;
}


/* Efecto al pasar el mouse */

.submenu a:hover {
  background: #ffdcec;

  color: #fb7cb7;
}


/* Flechita */

.menu-con-submenu > a::after {
  content: "⌄";

  font-size: 13px;

  margin-left: 6px;

  position: relative;

  top: -1px;
}


/* =========================
   ENLACE ACTIVO
========================= */

nav a.activo::after {
  content: "";

  position: absolute;

  left: 0;

  bottom: -6px;

  width: 100%;

  height: 1px;

  background-color: #333333;
}


/* =========================
   ICONOS
========================= */

.iconos-barra {
  display: flex;
  align-items: center;
  gap: 25px;
  flex-wrap: wrap;
  justify-content: flex-end;
}

.iconos-barra a {
  color: #2b2b2b;
  font-size: 18px;
  position: relative;
}

.usuario-info {
  display: flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  color: #2b2b2b;
}

.nombre-usuario {
  font-size: 14px;
  white-space: nowrap;
}


/* =========================
   ICONO AMBIENTAL
========================= */

.icono-ambiental {
  background-color: #dce8d5;
  color: #4f6848 !important;

  padding: 10px;

  border-radius: 50%;

  border: 2px solid #8fa586;

  font-size: 20px !important;
}

.icono-ambiental:hover {
  background-color: #6f8568;
  color: white !important;
}


/* =========================
   RESPONSIVE
========================= */

@media(max-width: 768px) {

  header {
    padding: 20px;

    gap: 10px;

    height: auto;

    display: flex;

    flex-direction: column;

    justify-content: center;

    align-items: center;
  }

  nav ul {
    gap: 15px;

    flex-wrap: wrap;

    justify-content: center;
  }

  .iconos-barra {
    display: flex;

    flex-direction: row;

    gap: 20px;
  }

  .iconos-barra a {
    display: flex;

    align-items: center;
  }

  /*
   * En celular los submenús se mantienen
   * debajo de su opción correspondiente.
   */

  .submenu {
    left: 0;

    transform: translateY(10px);

    min-width: 150px;
  }

  nav li:hover > .submenu {
    transform: translateY(0);
  }

}

</style>


<header>

  <div class="logo">
    <h1>Natué</h1>
  </div>


  <nav>

    <ul>


      <!-- =========================
           INICIO
      ========================== -->

      <li>

        <a href="../pagina/02.inicio.php">
          Inicio
        </a>

      </li>


      <!-- =========================
           PRODUCTOS
      ========================== -->

      <li class="menu-con-submenu">

        <a href="#">
          Productos
        </a>


        <ul class="submenu">

          <li>
            <a href="../pagina/03.productos.php">
              Cuidado
            </a>
          </li>

          <li>
            <a href="../pagina/04.productos2.php">
              Cosméticos
            </a>
          </li>

        </ul>

      </li>


      <!-- =========================
           NOSOTROS
      ========================== -->

      <li class="menu-con-submenu">

        <a href="#">
          Nosotros
        </a>


        <ul class="submenu">

          <li>
            <a href="../pagina/historia.php">
              Nuestra mision y vision 
            </a>
          </li>

          <li>
            <a href="../pagina/equipo.php">
              Nuestro equipo
            </a>
          </li>

            <li>
            <a href="../pagina/equipo.php">
              Nuestros valores 
            </a>
          </li>

        </ul>

      </li>


      <!-- =========================
           CONTACTANOS
      ========================== -->

      <li>

        <a href="../pagina/005.contactanos.php">
          Contáctanos
        </a>

      </li>


    </ul>

  </nav>


  <!-- =========================
       ICONOS
  ========================== -->

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

            echo htmlspecialchars($_SESSION['nombre']);

        }else{

            echo 'Invitado';

        }

        ?>

      </span>


    </a>


    <a href="../ajax/index.php">

      <i class="fa-solid fa-bag-shopping"></i>

    </a>


    <a href="../fichaaaaaaaaaaaaaaaaaa(1).pdf"
       class="icono-ambiental"
       title="Ficha ambiental">

      <i class="fa-solid fa-seedling"></i>

    </a>


  </div>

</header>