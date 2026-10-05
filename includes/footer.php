<style>
footer {
  grid-area: pie;
  padding: 48px 7% 20px;
  background-color: #eeeeec;
  color: #3b3b38;
  font-family: Arial, sans-serif;
}

.contenedor-pie {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 32px;
  max-width: 1200px;
  margin: 0 auto;
}

.seccion-pie h4 {
  font-family: 'Playfair Display', serif;
  font-size: 18px;
  color: #242421;
  margin: 0 0 14px;
  font-weight: 600;
}

.seccion-pie p,
.seccion-pie a {
  color: #555550;
  font-size: 14px;
  line-height: 1.8;
}

.seccion-pie p { margin: 0 0 10px; }

.enlaces-pie {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 5px;
}

.enlaces-pie a { text-decoration: none; }
.enlaces-pie a:hover { color: #8a735e; }

.iconos-redes {
  display: flex;
  gap: 20px;
  margin-top: 14px;
}

.iconos-redes a {
  color: #454540;
  font-size: 24px;
  transition: transform 0.3s ease;
}

.iconos-redes a:hover {
  transform: scale(1.15);
}

.pie-inferior {
  max-width: 1200px;
  margin: 30px auto 0;
  padding-top: 15px;
  border-top: 1px solid #d5d5d1;
  text-align: center;
  color: #666660;
  font-size: 12px;
}

@media (max-width: 768px) {

  footer {
    padding: 36px 22px 18px;
  }

  .contenedor-pie {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 26px 18px;
  }

  .seccion-pie h4 {
    font-size: 17px;
  }

  .seccion-pie p,
  .seccion-pie a {
    font-size: 13px;
  }
}

@media (max-width: 420px) {
  .contenedor-pie { grid-template-columns: 1fr; }
}
</style>

<footer>
  <div class="contenedor-pie">

    <div class="seccion-pie">
      <h4>Natue</h4>
      <p>Cuida tu piel con productos pensados para realzar tu belleza natural.</p>
      <div class="iconos-redes" aria-label="Redes y contacto">
        <a href="https://www.instagram.com/natue_cpp/" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://wa.link/fm1yti" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
        <a href="https://maps.app.goo.gl/V1DZgcXSaLBdwZGBA?g_st=aw" target="_blank" rel="noopener noreferrer" aria-label="Ubicación"><i class="fa-solid fa-location-dot"></i></a>
      </div>
    </div>

    <div class="seccion-pie">
      <h4>Información</h4>
      <div class="enlaces-pie">
        <a href="index.php">Inicio</a>
        <a href="../pagina/03.productos.php">Nuestros productos</a>
        <a href="../pagina/005.contactanos.php">Contáctanos</a>
      </div>
    </div>



    <div class="seccion-pie">
      <h4>Contacto</h4>
      <p>¿Necesitas ayuda con tu compra? Escríbenos por WhatsApp o síguenos en Instagram.</p>

    </div>

  </div>
 
</footer>