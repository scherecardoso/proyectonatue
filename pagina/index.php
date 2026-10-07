<?php
// Inicia o recupera la sesión actual para que la página pueda acceder a los datos del usuario.
session_start();

// Carga la conexión compartida con la base de datos.
require("../ajax/php/conexion.php");

// Consulta los cuatro productos más vendidos durante el mes y el año actuales.
// Se obtiene el código, nombre, descripción e imagen para poder mostrar cada producto en la página.
$sqlDestacados = "SELECT
                    p.codigo,
                    p.nombre,
                    p.descripcion,
                    p.imagen,
          // Suma las unidades vendidas de cada producto y asigna el resultado a esta columna.
                    SUM(c.cantidad) AS cantidad_vendida
                FROM carrito c
        // Relaciona los artículos del carrito con la información de sus productos.
                INNER JOIN productos p ON c.productos_codigo = p.codigo
        // Vincula los artículos con las ventas realizadas.
                INNER JOIN ventas v ON c.pedidos_id = v.pedidos_id
        // Une cada venta con su pedido para poder filtrar usando la fecha del pedido.
                INNER JOIN pedidos pe ON v.pedidos_id = pe.id
        // Incluye únicamente los pedidos del mes y año actuales.
                WHERE MONTH(pe.fecha) = MONTH(CURDATE())
                AND YEAR(pe.fecha) = YEAR(CURDATE())
        // Agrupa los registros por producto para calcular el total vendido de cada uno.
                GROUP BY p.codigo, p.nombre, p.descripcion, p.imagen
        // Omite cualquier producto cuyo total vendido sea cero o menor.
                HAVING cantidad_vendida > 0
        // Ordena desde el producto con más unidades vendidas hasta el de menos ventas.
                ORDER BY cantidad_vendida DESC
        // Limita el resultado a cuatro productos destacados.
                LIMIT 4";

// Ejecuta la consulta y guarda el resultado para mostrar los productos destacados en la página.
$destacados = $conn->query($sqlDestacados);
?>

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
  width: 100%;
  max-width: 100%;
  font-family: Arial, sans-serif;
  grid-template-columns: 1fr;
  grid-template-areas:
    "barra"
    "banner"
    "nompro"
    "productos"
    "contenido"
    "coment"
    "pie";
  gap: 5px;
  overflow-x: hidden;
  min-height: 100vh;
}

h2 {
    font-size: 28px;
}

h3{
    color: #000000;
}
  
.banner {
  grid-area: banner;
  background-color: pink;
  position: relative;
  }

.banner-img {
  width: 100%;
  height: auto;
  display: block;
}

.img-logo {
  position: relative;
  top: 200px;
  margin-left: 10%;
  background-color: #000;
  width: 300px;
  height: 100px;

}

 .caja-correo {
  position: absolute;
  top: 55%;      
  left:10%;
  display: flex;
  gap: 15px;          

}

.input-correo {
  border-radius: 50px;
  border: 1px solid rgba(255, 255, 255, 0.666);
  background-color: rgba(255, 255, 255, 0.308);
  color: #ffffff;
  font-size: 18px;
  text-align: center;
  width: 500px;
  height: 80px;
}

.boton-enviar {
  width: 100px;
  height: 80px;
  border-radius: 50px;
  border: 1px solid rgba(255, 255, 255, 0.666);
  background-color: rgba(255, 255, 255, 0.308);
  cursor: pointer;
 
}

.imagenes img:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.productos {
  grid-area: productos;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  gap: 45px;
  padding: 60px 30px;
  box-sizing: border-box;
  background-color: #ffffff;
  position: relative;
  top: 0;
  border-radius: 40px;
}

.titulo-productos {
    width: 100%;
    height: auto;
    background-color: #ffffff;
    text-align: center;
    font-family: 'Playfair Display', serif;
    color: #000;
    margin: 14px 0 20px;
}

.titulo-productos h2 {
    font-size: 42px;
    margin: 0;
    font-weight: 600;
}

.rectangulo-titulo {
  width: 300px;
  height: 50px;
  background-color: #ffffff;
  border-radius: 20px;
  font-family: Tenor Sans, sans-serif;
  font-size: 28px;
  margin: 0 auto 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.cuadro-grande {
  width: 350px;
  height: 480px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-radius: 80px;
}
.cuadro-grande img {
  width: 100%;
  height: 100%;
  border-radius: 80px;
  object-fit: cover;
}

.cuadro-grande:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.rectangulo-info {
  width: 300px;
  height: 95px;
  background-color: #ffffff;
  border-radius: 20px;
  font-family: Tenor Sans, sans-serif;
  font-size: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  margin: 20px auto 0;
}


.contenido {
  grid-area: contenido;
  background-color: rgb(255, 255, 255);
  min-height: 900px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 50px;
  padding: 60px 40px;
  box-sizing: border-box;
}

.texto-contenido {
  width: 50%;
  max-width: 700px;
  padding-left: 50px;
  margin-top: -78px;
  margin-left: 20px;
  justify-content: space-between;
  font-size: 20px;
  font-family:'Open Sans';
  font-weight: 400;
  line-height: 1.7;
}

.texto-contenido p {
  margin: 0;
}

.img-contenido {
  width: min(550px, 42vw);
  max-width: 550px;
  aspect-ratio: 1 / 1;
  border-radius: 50px;
  margin-left: 50px;
  object-fit: cover;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.img-contenido:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}

.comentario{
  grid-area: coment;
  border-radius: 30px;
  background: #F1F1F1;
  height: 350px;
  width: 500px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 25px;
  text-align: center;
  margin: 0 auto 80px;
  border: 1px solid #DADADA;
}

.contenido-comentario {
  width: auto;
  margin: 0;
  padding: 0;
  font-size: 30px;
  font-family: 'Playfair Display', serif;
  font-weight: 600;
  color: #4F4F4F;
}

.icono-comentario {
  width: 70px;
  height: 70px;
  border: 1px solid #C7C7C7;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #FFFFFF;
  transition: 0.3s ease;
}

.icono-comentario a {
  color: #666666;
  font-size: 28px;
}

.icono-comentario:hover {
  background-color: #E2E2E2;
  transform: scale(1.05);
}


@media (max-width: 1100px) {

  .productos {
    gap: 35px;
    padding-left: 25px;
    padding-right: 25px;
  }

  .cuadro-grande {
    width: 300px;
    height: 420px;
  }

  .rectangulo-titulo,
  .rectangulo-info {
    width: 280px;
  }

  .contenido {
    gap: 30px;
    padding: 40px;
  }

  .img-contenido {
    width: 42%;
    max-width: 450px;
  }

  .texto-contenido {
    font-size: 18px;
  }
}



@media (max-width: 900px) {

  .productos {
    gap: 30px;
    padding: 80px 20px;
  }

  .cuadro-grande {
    width: 280px;
    height: 390px;
  }

  .rectangulo-titulo,
  .rectangulo-info {
    width: 260px;
  }

  .contenido {
    flex-direction: column;
    justify-content: center;
    gap: 35px;
    padding: 60px 30px;
    min-height: auto;
  }

  .texto-contenido {
    width: 100%;
    max-width: 750px;
    margin: 0;
    padding: 0;
    font-size: 17px;
    line-height: 1.7;
    text-align: justify;
  }

  .img-contenido {
    width: 70%;
    max-width: 450px;
    height: auto;
  }

  .comentario {
    width: 80%;
    max-width: 500px;
  }
}



@media (max-width: 768px) {

  .productos {
    position: relative;
    top: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    padding: 40px 15px 60px;
    background-color: white;
    border-radius: 0;
  }

  .producto {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .rectangulo-titulo {
    width: 90%;
    max-width: 300px;
    min-height: 50px;
    height: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 22px;
  }

  .rectangulo-titulo p {
    margin: 10px;
  }

  .cuadro-grande {
    width: 90%;
    max-width: 320px;
    height: 400px;
    border-radius: 50px;
  }

  .cuadro-grande img {
    width: 100%;
    height: 100%;
    border-radius: 50px;
    object-fit: cover;
  }

  .rectangulo-info {
    width: 90%;
    max-width: 300px;
    height: auto;
    min-height: 95px;
    padding: 10px;
    text-align: center;
    font-size: 18px;
  }

  .rectangulo-info p {
    margin: 10px;
  }

  .contenido {
    width: 100%;
    min-height: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 35px;
    padding: 50px 20px;
    text-align: center;
  }

  .texto-contenido {
    width: 100%;
    max-width: 600px;
    padding: 0;
    margin: 0;
    font-size: 16px;
    line-height: 1.7;
    text-align: justify;
  }

  .img-contenido {
    width: 90%;
    max-width: 400px;
    height: auto;
    aspect-ratio: 1 / 1;
    border-radius: 40px;
  }

  .comentario {
    width: 90%;
    max-width: 500px;
    height: auto;
    min-height: 280px;
    margin: 40px auto;
    padding: 30px 20px;
    gap: 20px;
  }

  .contenido-comentario {
    width: 100%;
    font-size: 24px;
    text-align: center;
  }

  .contenido-comentario p {
    margin: 0;
  }
}



@media (max-width: 500px) {

  .titulo-productos {
    margin: 30px 0 10px;
  }

  .titulo-productos h2 {
    font-size: 26px;
  }

  .productos {
    gap: 40px;
    padding: 20px 10px 50px;
  }

  .cuadro-grande {
    width: 90%;
    max-width: 300px;
    height: 370px;
  }

  .rectangulo-titulo {
    max-width: 280px;
    font-size: 20px;
  }

  .rectangulo-info {
    max-width: 280px;
    font-size: 16px;
  }

  .contenido {
    padding: 40px 15px;
  }

  .texto-contenido {
    font-size: 15px;
    line-height: 1.6;
  }

  .img-contenido {
    width: 90%;
    max-width: 320px;
    border-radius: 30px;
  }

  .comentario {
    width: 92%;
    min-height: 250px;
  }

  .contenido-comentario {
    font-size: 21px;
  }
}


@media (max-width: 360px) {

  .titulo-productos h2 {
    font-size: 23px;
  }

  .cuadro-grande {
    width: 90%;
    height: 330px;
  }

  .rectangulo-titulo {
    font-size: 18px;
  }

  .rectangulo-info {
    font-size: 15px;
  }

  .texto-contenido {
    font-size: 14px;
  }

  .contenido-comentario {
    font-size: 19px;
  }
}
</style>
</head>


<body>

<?php include("../includes/header.php"); ?>
<?php require("../ajax/php/conexion.php");?>
  <section>
    <img src="../img/banner4 - Copy.png" alt="Banner" class="banner-img" id="banner">
  </section>


  <div class="titulo-productos"><h2>Productos Destacados</h2></div>

 <section class="productos">

<?php if ($destacados && $destacados->num_rows > 0): ?>

    <?php while ($producto = $destacados->fetch_assoc()): ?>

        <div class="producto">

            <div class="rectangulo-titulo">
                <p>
                    <?php echo htmlspecialchars($producto['nombre']); ?>
                </p>
            </div>

            <div class="cuadro-grande">
                <img 
                    src="../img/<?php echo htmlspecialchars($producto['imagen']); ?>" 
                    alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                >
            </div>

            <div class="rectangulo-info">
                <p>
                    <?php echo htmlspecialchars($producto['descripcion'] ?? ''); ?>
                </p>
            </div>

        </div>

    <?php endwhile; ?>

<?php else: ?>

    <div class="sin-destacados">
        <p>Aún no hay productos vendidos este mes.</p>
    </div>

<?php endif; ?>

</section>


<section class="contenido">
  <div class="texto-contenido">
    <p>En Natue creemos en una belleza responsable y en equilibrio con la naturaleza.
      Nuestro propósito es promover un estilo de vida sostenible, impulsando el cuidado
      personal que también protege el medio ambiente.
      Trabajamos para crear conciencia sobre el impacto de nuestras decisiones diarias
      y fomentar prácticas que contribuyan al bienestar de las personas y del planeta.</p></div>
    <img src="../img/natueeeeimg.png" alt="Orgánico y natural" class="img-contenido">
</section>

<section class="comentario">
  
  <div class="contenido-comentario">
    <p>Déjanos tus comentarios</p>
  </div>

  <div class="icono-comentario">
    <a href="comentario.php">
      <i class="fa-regular fa-comment-dots"></i>
    </a>
  </div>

</section>
<?php include("../includes/footer.php"); ?>
</body>
</html>