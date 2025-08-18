<?php include '../includes/headerCadastrado.php'; ?>
  
  <!-- slider section -->
    <section class="slider_section">
      <div id="customCarousel1" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-inner">

          <div class="carousel-item active">
            <div class="full-bg" style="background-image: url('../images/fundoprincipal.png');">
              <div class="container h-100 d-flex align-items-center">
                <div class="detail-box text-white">
                  <h1>Bem-vinda de volta, Juliana!</h1>
                  <p>Agende seu próximo cuidado capilar conosco.</p>
                  <div class="btn-box">
                    <a href="catalogoCadastrado.php" class="btn1">Ver Catálogo</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="full-bg" style="background-image: url('../images/capa3.png');">
              <div class="container h-100 d-flex align-items-center">
                <div class="detail-box text-white">
                  <h1>Estilo que inspira</h1>
                  <p>Desde o liso impecável aos cachos definidos.</p>
                  <div class="btn-box">
                    <a href="agendaCadastrado.php" class="btn1">Agende Agora</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          
        </div>
        <ol class="carousel-indicators">
          <li data-bs-target="#customCarousel1" data-bs-slide-to="0" class="active"></li>
          <li data-bs-target="#customCarousel1" data-bs-slide-to="1"></li>
          <li data-bs-target="#customCarousel1" data-bs-slide-to="2"></li>
        </ol>
      </div>
    </section>

    <!-- profissional -->
    <div class="container">
      <div class="professional-card">
        <div class="row align-items-center">
          <div class="col-md-4 text-center">
            <img src="../images/cabeleireira.png" alt="Profissional" class="professional-img">
          </div>
          <div class="col-md-8">
            <h3>Juliana Wolff</h3>
            <p class="text-muted">Especialista Capilar | Proprietária</p>
            <p>Com mais de 12 anos de experiência no mercado de beleza, transformo cabelos e autoestimas com técnicas avançadas e atendimento personalizado.</p>
            <h5>Formação Profissional</h5>
            <ul>
              <li>Graduação em Estética e Cosmética</li>
              <li>Pós-graduação em Tricologia Capilar</li>
              <li>Certificação Internacional em Colorimetria</li>
            </ul>
            <h5>Especialidades</h5>
            <span class="specialty-badge">Cabelos Danificados</span>
            <span class="specialty-badge">Coloração Vegana</span>
            <span class="specialty-badge">Cortes Personalizados</span>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-4 mb-4">
          <div class="text-center p-3">
            <i class="fa fa-scissors fa-3x mb-3" style="color: #f783ac;"></i>
            <h4>Técnica</h4>
            <p>Domínio das mais modernas técnicas internacionais de corte e coloração.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="text-center p-3">
            <i class="fa fa-leaf fa-3x mb-3" style="color: #f783ac;"></i>
            <h4>Produtos</h4>
            <p>Utilizamos apenas produtos naturais e cruelty-free em todos os tratamentos.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="text-center p-3">
            <i class="fa fa-heart fa-3x mb-3" style="color: #f783ac;"></i>
            <h4>Atendimento</h4>
            <p>Cada cliente recebe um diagnóstico completo e tratamento individualizado.</p>
          </div>
        </div>
      </div>
    </div>
<?php include '../includes/footer.php'; ?>
