<?php include '../includes/headerAdmin.php'; ?>
<section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Painel administrativo
        </h2>
      </div>

  <div class="dashboard-container">
    <div class="dashboard-card">
      <h5>Profissionais</h5>
      <p>1 cadastrado</p>
      <a href="sobreAdmin.php" class="btn-rosa">Gerenciar</a>
    </div>
    
    <div class="dashboard-card">
      <h5>Serviços</h5>
      <p>12 ativos</p>
      <a href="catalogoAdmin.php" class="btn-rosa">Ver Catálogo</a>
    </div>
    
    <div class="dashboard-card">
      <h5>Próximos Agendamentos</h5>
      <p>3 hoje</p>
      <a href="agendaAdmin.php" class="btn-rosa">Ver Agenda</a>
    </div>
  </div>
</div>
</section>

<?php include '../includes/footer.php'; ?>

<style>
/* Garantir que o footer fique na parte inferior */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main {
    flex: 1 0 auto;
}

.footer_section {
    flex-shrink: 0;
    margin-top: auto;
}

/* Estilos para o dashboard */
.dashboard-container {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
  padding: 40px 0;
}

.dashboard-card {
  background: #fff;
  border: 1px solid #ffdeeb;
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  transition: transform 0.3s, box-shadow 0.3s;
  width: 100%;
  max-width: 280px;
  text-align: center;
  margin: 10px;
}

.dashboard-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.dashboard-card h5 {
  color: #e64980;
  font-weight: bold;
  margin-bottom: 15px;
}

.dashboard-card p {
  color: #666;
  margin-bottom: 20px;
  font-size: 1.1rem;
}

.btn-rosa {
  background-color: #e64980;
  color: white;
  border: none;
  border-radius: 20px;
  padding: 8px 20px;
  transition: background-color 0.3s;
  text-decoration: none;
  display: inline-block;
}

.btn-rosa:hover {
  background-color: #d42d7b;
  color: white;
}
</style>