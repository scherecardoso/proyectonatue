 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Quicksand:wght@400;500&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet">
  
<style>

body {
    display: grid;
    margin: 0;
    font-family: Arial, sans-serif;
    grid-template-columns: 198px 1fr 260px;
    grid-template-rows: 70px 1fr;   
    grid-template-areas:
        "barra barra barra"
        "menu info act"
        "pie pie pie";
    gap: 10px;
    height: 100vh;
    background: #ffffff;
}


.menu {
    grid-area: menu;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background-color: #ffffff;
    padding: 15px;
    margin-top: 27px;
    width: 330px;
    border-right: 1px solid #ececec;
}

.titulo-menu {
    font-size: 15px;
    color: #ff5ca8; 
    margin-bottom: 10px;
}

.menu div{
    padding: 15px;
    border-radius: 12px;
    font-size: 20px;
    transition: .3s;
    cursor: pointer;
}

.menu div:hover{
    background: #ffdcec;
    color: #ff5ca8;
    padding-left: 22px;
} 

h2{
    font-size: 35px;
}

p{
    font-size: 20px;
}

div{
  color: black;
}

i{
    color:black;
}
.menu a{
    text-decoration: none;
    color: black;
}

@media (max-width: 768px) {

  body{
    grid-template-columns: 1fr;
    grid-template-rows: auto;
    grid-template-areas:
      "barra"
      "info";
  }

  .menu,
  .act {
    display: none;
  }

}
</style>
<body>
<aside class="menu">
    </a><div class="titulo-menu">MENU ADMINISTRADOR</div>
    <a href="../admin/06.admin.php"><div> <i class="fa-solid fa-house"></i> Inicio</div></a>
    <a href="../usuario/13.formeditarusuario.php"><div> <i class="fa-solid fa-users"></i> Gestión de Usuarios</div></a>
    <div><i class="fa-solid fa-shield-halved"></i> Roles y Permisos</div>
     <a href="../admin/gestionproductos.php"><div><i class="fa-solid fa-box"></i> Gestión de Productos</div>
    <div><i class="fa-solid fa-chart-line"></i> Reportes</div>
    <a href="../admin/ventasypedidos.php"><div><i class="fa-solid fa-cart-shopping"></i> Ventas y Pedidos</div></a>
    <div><i class="fa-solid fa-gear"></i> Configuración</div>
    <div><i class="fa-solid fa-clock-rotate-left"></i> Actividad</div>
    <div><i class="fa-solid fa-right-from-bracket"><a href="../auth/26.cerrarsesion.php"></i> Cerrar sesión</div>
    
</aside>
</body>