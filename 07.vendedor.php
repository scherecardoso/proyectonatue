<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<title>Natué Dashboard Premium</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}
body{
  font-family:'Poppins',sans-serif;
  background:rgba(255,255,255,.95);
  color:#262626;
}
.header{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:85px;
  background:linear-gradient(white, pink);
  display:flex;
  align-items:center;
  justify-content:space-between;
  padding:28px;
  z-index:3;
}
.logo{
  font-size:2rem;
  font-weight:700;
  color:#ff4f93;
}
.nav{
  display:flex;
  align-items:center;
  gap:35px;
}
.nav a{
  text-decoration:none;
  color:#444;
  font-weight:500;
  position:relative;
}
.icons{
  display:flex;
  align-items:center;
  gap:15px;
}
.icons a{
  width:45px;
  height:45px;
  border-radius:50%;
  display:flex;
  align-items:center;
  justify-content:center;
  color:#ff4f93;
  transition: .3s; 
}
.icons a:hover{
  background:#ff4f93;
  color:white;
  transform:translateY(-3px);
}
.pepcuerpo{
  display:grid;
  grid-template-columns:290px 1fr;
  gap:25px;
  padding:115px 25px 25px;
}
.sidebar{
  background:rgba(255,255,255,.95);
  border-radius:30px;
  padding:25px;
  box-shadow:0 10px 30px rgba(0,0,0,.05);
  height:calc(100vh - 140px);
  position:sticky;
  top:105px;
}
.sidebar-title{
  color:#ff4f93;
  font-size:1.3rem;
  font-weight:700;
  margin-bottom:25px;
}
.sidebar-links{
  display:flex;
  flex-direction:column;
  gap:12px;
}
.sidebar-links a{
  text-decoration:none;
  color:#444;
  padding:16px;
  border-radius:18px;
  transition:.3s;
  display:flex;
  align-items:center;
  gap:14px;
  font-weight:500;
}
.sidebar-links a:hover{
  background:#fff0f6;
  color:#ff4f93;
  transform:translateX(6px);
}
.logout{
  margin-top:15px;
  background:#fff5f8;
}
.main{
  display:flex;
  flex-direction:column;
  gap:25px;
}
.hero{
  background:linear-gradient(135deg,#ff4f93,#ff9fc0);
  border-radius:35px;
  padding:35px;
  color:white;
  position:relative;
  overflow:hidden;
  box-shadow:0 15px 40px rgba(255,79,147,.18);
}
.hero::before{
  content:"";
  position:absolute;
  width:350px;
  height:350px;
  border-radius:50%;
  background:rgba(255,255,255,.12);
  top:-120px;
  right:-100px;
}
.hero-content{
  position:relative;
  z-index:2;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:30px;
  flex-wrap:wrap;
}
.hero-left{
  display:flex;
  align-items:center;
  gap:25px;
}
.profile-icon{
  width:110px;
  height:110px;
  border-radius:50%;
  background:rgba(255,255,255,.2);
  border:2px solid rgba(255,255,255,.4);
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:3rem;
}
.hero-text h1{
  font-size:2.5rem;
  margin-bottom:10px;
}
.hero-text p{
  line-height:1.7;
  max-width:500px;
}
.slider{
  position:relative;
  width:320px;
  height:210px;
  border-radius:28px;
  overflow:hidden;
  box-shadow:0 15px 35px rgba(0,0,0,.15);
}
.slide{
  position:absolute;
  width:100%;
  height:100%;
  object-fit:cover;
  opacity:0;
}
.section-title{
  font-size:1.8rem;
  color:#444;
}
.cards{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
  gap:20px;
}
.card{
  background:rgba(255,255,255,.95);
  border-radius:28px;
  padding:25px;
  box-shadow:0 10px 30px rgba(0,0,0,.05);
  transition:.35s;
}
.card:hover{
  transform:translateY(-8px);
}
.card-icon{
  width:70px;
  height:70px;
  border-radius:20px;
  background:#fff0f6;
  color:#ff4f93;
  display:flex;
  justify-content:center;
  align-items:center;
  font-size:28px;
  margin-bottom:18px;
}
.card h3{
  margin-bottom:10px;
}
.card p{
  color:#777;
  line-height:1.6;
}
.menu-toggle{
  width:48px;
  height:48px;
  border-radius:14px;
  background:white;
  display:none;
  justify-content:center;
  align-items:center;
  flex-direction:column;
  gap:5px;
  cursor:pointer;
  transition:.3s;
  box-shadow:0 5px 15px rgba(0,0,0,.06);
}
.menu-toggle span{
  width:24px;
  height:3px;
  background:#ff4f93;
  border-radius:20px;
  transition:.3s;
}
.pepe-grid{
  display:grid;
  grid-template-columns:2fr 1fr;
  gap:20px;
}
.orders,
.quick-box{
  background:rgba(255,255,255,.95);
  border-radius:28px;
  padding:25px;
  box-shadow:0 10px 30px rgba(0,0,0,.05);
}
.orders-header h2,
.quick-box h2{
  color:#ff4f93;
  margin-bottom:20px;
}
table{
  width:100%;
  border-collapse:collapse;
}
th{
  padding:15px;
  text-align:left;
  background:#fff0f6;
  color:#ff4f93;
}
td{
  padding:15px;
  border-bottom:1px solid #f2f2f2;
}
.status{
  padding:8px 15px;
  border-radius:30px;
  font-size:.8rem;
  font-weight:600;
}
.done{
  background:#dfffe9;
  color:#1f9b51;
}
.pending{
  background:#ffe7f1;
  color:#ff4f93;
}
.quick{
  display:flex;
  flex-direction:column;
  gap:20px;
}
.quick-btn{
  width:100%;
  height:70px;
  border:none;
  border-radius:20px;
  background:#fff0f6;
  color:#ff4f93;
  font-size:1rem;
  font-weight:600;
  cursor:pointer;
  margin-bottom:15px;
  transition:.3s;
}
.quick-btn:hover{
  background:#ff4f93;
  color:white;
  transform:scale(1.03);
}
.footer{
  background:rgba(255,255,255,.95);
  padding:35px;
  border-radius:30px;
  text-align:center;
  box-shadow:0 10px 30px rgba(0,0,0,.04);
}
.footer h3{
  color:#ff4f93;
  margin-bottom:20px;
}
.socials{
  display:flex;
  justify-content:center;
  gap:18px;
  flex-wrap:wrap;
}
.socials a{
  width:50px;
  height:50px;
  border-radius:50%;
  background:white;
  display:flex;
  justify-content:center;
  align-items:center;
  text-decoration:none;
  color:#ff4f93;
  transition:.3s;
  box-shadow:0 5px 15px rgba(0,0,0,.05);
}
.socials a:hover{
  background:#ff4f93;
  color:white;
  transform:translateY(-5px);
}
.overlay{
  position:fixed;
  inset:0;
  background:rgba(0,0,0,.35);
  opacity:0;
  visibility:hidden;
  transition:.3s;
  z-index:997;
}
.overlay.active{
  opacity:1;
  visibility:visible;
}
@media(max-width:1100px){
  .pepe-grid{
    grid-template-columns:1fr;
  }
}
@media(max-width:900px){
  .pepcuerpo{
    grid-template-columns:1fr;
  }
  .menu-toggle{
    display:flex;
  }
  .nav{
    display:none;
  }
  .sidebar{
    position:fixed;
    top:0;
    left:-320px;
    width:290px;
    height:100vh;
    z-index:9998;
    transition:.4s ease;
    border-radius:0 30px 30px 0;
  }
  .sidebar.active{
    left:0;
  }
}
@media(max-width:768px){

  .header{
    padding:0 18px;
  }
  .logo{
    font-size:1.6rem;
  }
  .hero{
    padding:25px;
  }
  .hero-content{
    flex-direction:column;
    text-align:center;
  }
  .hero-left{
    flex-direction:column;
  }
  .hero-text h1{
    font-size:2rem;
  }
  .slider{
    width:100%;
    height:230px;
  }
  .cards{
    grid-template-columns:1fr;
  }
  .orders{
    overflow-x:auto;
  }
  table{
    min-width:650px;
  }
}
@media(max-width:500px){
  .container{
    padding:105px 14px 14px;
  }
  .hero-text h1{
    font-size:1.7rem;
  }
  .profile-icon{
    width:90px;
    height:90px;
    font-size:2.3rem;
  }
  .section-title{
    font-size:1.5rem;
  }
}
</style>
</head>
<body>
<header class="header">
<div class="menu-toggle" id="menuToggle">
  <span></span>
  <span></span>
  <span></span>
</div>
  <div class="logo">Natué</div>
  <nav class="nav">
    <a href="#02.inicio.php">Inicio</a>
    <a href="#03.productos.php">Cuidado</a>
    <a href="#04.productos2.php">Cosméticos</a>
    <a href="#05.acercade.php">Nosotros</a>
  </nav>
  <div class="icons">
    <a href="#10.formusuarios.php"><i class="fa-solid fa-user"></i></a>
    <a href="#16.formproductos.php"><i class="fa-solid fa-bag-shopping"></i></a>
  </div>
</header>
<div class="pepcuerpo">
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-title">
      Panel Vendedor
    </div>
    <div class="sidebar-links">
      <a href="#"><i class="fa-solid fa-house"></i> Inicio</a>
      <a href="#"><i class="fa-solid fa-cart-shopping"></i> Registrar Ventas</a>
      <a href="#"><i class="fa-solid fa-box"></i> Stock Productos</a>
      <a href="#"><i class="fa-solid fa-truck"></i> Pedidos</a>
      <a href="#"><i class="fa-solid fa-clock-rotate-left"></i> Historial</a>
      <a href="#"><i class="fa-solid fa-chart-column"></i> Estadísticas</a>
      <a href="#"><i class="fa-solid fa-user"></i> Mi Perfil</a>
      <a href="#" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
    </div>
  </aside>
  <main class="main">
    <section class="hero">
      <div class="hero-content">
        <div class="hero-left">
          <div class="profile-icon">
            <i class="fa-solid fa-user"></i>
          </div>
          <div class="hero-text">
            <h1>Bienvenido/a ✨</h1>
            <p>
              Haz que cada día sea una oportunidad para brillar.
              Gestiona tus ventas, pedidos y productos desde un solo lugar.
            </p>
          </div>
        </div>
        <div class="slider">
          <img src="natue.jpeg" class="slide">
          <img src="nombre natue .jpeg" class="slide">
        </div>
      </div>
    </section>
    <section>
      <h2 class="section-title">Acciones Rápidas</h2>
      <div class="cards">
        <div class="card">
          <div class="card-icon">
            <i class="fa-solid fa-cart-shopping"></i>
          </div>
          <h3>Registrar Venta</h3>
          <p>Registra nuevas ventas de productos rápidamente.</p>
        </div>
        <div class="card">
          <div class="card-icon">
            <i class="fa-solid fa-box"></i>
          </div>
          <h3>Ver Stock</h3>
          <p>Consulta la disponibilidad actual de productos.</p>
        </div>
        <div class="card">
          <div class="card-icon">
            <i class="fa-solid fa-clipboard-list"></i>
          </div>
          <h3>Pedidos</h3>
          <p>Consulta todos los pedidos de tus clientes.</p>
        </div>
        <div class="card">
          <div class="card-icon">
            <i class="fa-solid fa-chart-line"></i>
          </div>
          <h3>Estadísticas</h3>
          <p>Visualiza el crecimiento y rendimiento de ventas.</p>
        </div>
      </div>
    </section>
    <section class="pepe-grid">
      <section class="orders">
        <div class="orders-header">
          <h2>Últimos Pedidos</h2>
        </div>
        <table>
          <tr>
            <th>Pedido</th>
            <th>Cliente</th>
            <th>Fecha</th>
            <th>Estado</th>
          </tr>
          <tr>
            <td>#COD12</td>
            <td>María López</td>
            <td>19/06/26</td>
            <td><span class="status done">ENTREGADO</span></td>
          </tr>
          <tr>
            <td>#COD13</td>
            <td>Jessica Copa</td>
            <td>04/03/26</td>
            <td><span class="status pending">PENDIENTE</span></td>
          </tr>
          <tr>
            <td>#COD14</td>
            <td>Lucas Salazar</td>
            <td>11/05/26</td>
            <td><span class="status done">ENTREGADO</span></td>
          </tr>
        </table>
      </section>
      <section class="quick">
        <div class="quick-box">
          <h2>Acceso Rápido</h2>
          <button class="quick-btn">
            Nuevo Pedido
          </button>
          <button class="quick-btn">
            Ver Catálogo
          </button>
          <button class="quick-btn">
            Reportes
          </button>
        </div>
      </section>
    </section>
    <footer class="footer">
      <h3>Síguenos en nuestras redes sociales hijuepichi :<</h3>
      <div class="socials">
        <a href="#"><i class="fa-solid fa-location-dot"></i></a>
        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
      </div>
    </footer>
  </main>
</div>
<div class="overlay" id="overlay"></div>
<script>
const menuToggle = document.getElementById("menuToggle");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");

menuToggle.addEventListener("click", () => {
  sidebar.classList.toggle("active");
  overlay.classList.toggle("active");
});

overlay.addEventListener("click", () => {
  sidebar.classList.remove("active");
  overlay.classList.remove("active");
});
</script>
</body>
</html>