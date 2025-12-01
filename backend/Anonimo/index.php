<?php 
include '../includes/header.php'; 
include '../includes/db.php';
include '../includes/profissional_functions.php';
?>

<!-- Slider Section -->
<section class="slider_section">
<div id="customCarousel1" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-inner">
      <!-- Slide 1 -->
      <div class="carousel-item active">
        <div class="full-bg" style="background-image: url('../images/fundoprincipal.png');">
          <div class="container h-100 d-flex align-items-center">
            <div class="detail-box text-white">
              <h1>Transforme seu visual</h1>
              <p>Especialistas em cortes, coloração e tratamentos capilares para realçar sua beleza natural.</p>
              <div class="btn-box">
                <a href="catalogo.php" class="btn1">Ver Catálogo</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Slide 2 -->
      <div class="carousel-item">
        <div class="full-bg" style="background-image: url('../images/capa3.png');">
          <div class="container h-100 d-flex align-items-center">
            <div class="detail-box text-white">
              <h1>Estilo que inspira</h1>
              <p>Desde o liso impecável aos cachos definidos.</p>
              <div class="btn-box">
                <a href="agenda.php" class="btn1">Agende Agora</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Indicadores -->
    <ol class="carousel-indicators">
      <li data-bs-target="#customCarousel1" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#customCarousel1" data-bs-slide-to="1"></li>
    </ol>
  </div>
</section>

<!-- Conteúdo principal -->
<div class="container">
  <div class="professional-card">
    <div class="row align-items-center">
      <div class="col-md-4 text-center">
        <img src="../images/cabeleireira.png" alt="Juliana Wolff" class="professional-img">
      </div>
      <div class="col-md-8">
        <h3>Juliana Wolff</h3>
        <p class="text-muted">Especialista Capilar | Proprietária</p>
        <div class="mb-3">
          <p><?php echo exibirSobre($conn); ?></p>
        </div>
        <div class="mb-3">
          <h5>Formação Profissional</h5>
          <ul>
            <?php 
            $formacoes = getInformacoesProfissional($conn, 'formacao');
            if (empty($formacoes)) {
                // Conteúdo padrão harmonioso
                echo '<li>Graduação em Estética e Cosmética</li>';
                echo '<li>Pós-graduação em Tricologia Capilar</li>';
                echo '<li>Certificação Internacional em Colorimetria</li>';
            } else {
                // Conteúdo dinâmico mantendo o mesmo estilo
                foreach (array_slice($formacoes, 0, 3) as $formacao) {
                    echo '<li>' . htmlspecialchars($formacao['titulo']) . '</li>';
                }
            }
            ?>
          </ul>
        </div>
        <div>
          <h5>Especialidades</h5>
          <div class="mt-2">
            <?php 
            $especialidades = getInformacoesProfissional($conn, 'especialidade');
            if (empty($especialidades)) {
                // Conteúdo padrão harmonioso
                echo '<span class="specialty-badge">Cabelos Danificados</span>';
                echo '<span class="specialty-badge">Coloração Vegana</span>';
                echo '<span class="specialty-badge">Cortes Personalizados</span>';
            } else {
                // Conteúdo dinâmico mantendo o mesmo estilo
                foreach (array_slice($especialidades, 0, 3) as $especialidade) {
                    echo '<span class="specialty-badge">' . htmlspecialchars($especialidade['titulo']) . '</span>';
                }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Ícones (mantém estático - parte do design) -->
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