<style>
    footer {
  grid-area: pie;
  padding:60px;
  }

.contenedor-pie {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 40px;
  margin-bottom: 40px;
  }

.seccion-pie {
  min-width: 250px;
  }

.seccion-pie h4 {
  font-family: 'Playfair Display', serif;
  font-size: 18px;
  color: #000000;
  margin-bottom: 10px;
  font-weight: 600;
  }

.seccion-pie p {
  color: #000000;
  font-weight: 400;
  font-size: 14px;
  }

.iconos-redes {
  display: flex;
  gap: 20px;
  margin-top: 10px;
  }

.iconos-redes a {
  color: #2b2b2b;
  font-size: 18px;
  transition: color 0.3s ease;
  }

  @media {
    footer {
    padding: 30px 20px;
    height: auto;
  }


  .contenedor-pie {
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 25px;
  }


  .seccion-pie {
    width: 100%;
  }


  .seccion-pie h4 {
    font-size: 16px;
  }


  .seccion-pie p {
    font-size: 13px;
  }


  .iconos-redes {
    justify-content: center;
  }
  }
</style>

<footer>
  <div class="contenedor-pie">
 <div class="seccion-pie"></div> 

  <div class="seccion-pie">
   <h4>Síguenos</h4>
  <div class="iconos-redes">
    <a ><i class="fab fa-instagram"></i></a>
    <a ><i class="fab fa-tiktok"></i></a>
    <a ><i class="fab fa-facebook-f"></i></a>
  </div>
  </div>

</footer>