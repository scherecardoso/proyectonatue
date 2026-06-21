<style>
footer {
  grid-area: pie;
  padding: 60px;
}

.contenedor-pie {
  display: flex;
  justify-content: center;
  text-align: center;
}

.seccion-pie h4 {
  font-family: 'Playfair Display', serif;
  font-size: 20px;
  color: #000;
  margin-bottom: 15px;
  font-weight: 600;
}

.iconos-redes {
  display: flex;
  justify-content: center;
  gap: 30px;
  margin-top: 10px;
}

.iconos-redes a {
  color: #2b2b2b;
  font-size: 35px;
  transition: transform 0.3s ease;
}

.iconos-redes a:hover {
  transform: scale(1.15);
}

@media (max-width: 768px) {

  footer {
    padding: 30px 20px;
  }

  .seccion-pie h4 {
    font-size: 22px;
  }

  .iconos-redes a {
    font-size: 32px;
  }
}
</style>

<footer>
  <div class="contenedor-pie">

    <div class="seccion-pie">
      <h4>Contactanos</h4>

      <div class="iconos-redes">
        <a href="https://www.instagram.com/natue_cpp/" target="_blank">
          <i class="fab fa-instagram"></i>
        </a>

        <a href="https://wa.link/fm1yti" target="_blank">
          <i class="fa-brands fa-whatsapp"></i>
        </a>

        <a href="https://maps.app.goo.gl/2hDiP1BoJQG7hdNK6" target="_blank">
          <i class="fa-solid fa-location-dot"></i>
        </a>
      </div>

    </div>

  </div>
</footer>