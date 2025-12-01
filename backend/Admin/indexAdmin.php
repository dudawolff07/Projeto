<?php
include '../includes/auth_redirect.php';
requireAuth([1]); // Somente admin
include '../includes/headerAdmin.php';

include '../includes/db.php';

// Buscar dados reais
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM usuario WHERE tipo_id = 2");
$stmt->execute();
$result = $stmt->get_result();
$usuarios_cadastrados = $result->fetch_assoc()['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM procedimento");
$stmt->execute();
$result = $stmt->get_result();
$servicos_ativos = $result->fetch_assoc()['total'];

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM agendamento WHERE data_procedimento = CURDATE() AND status_procedimento != 'cancelado'");
$stmt->execute();
$result = $stmt->get_result();
$agendamentos_hoje = $result->fetch_assoc()['total'];
?>

<section class="food_section layout_padding">
    <div class="heading_container heading_center">
    <h2>Painel Administrativo</h2>
    <p class="text-muted">Bem-vindo, <?php echo $_SESSION['usuario_nome']; ?>!</p>
</div>

      <div class="dashboard-container">
        <div class="dashboard-card">
          <h5>Clientes Cadastrados</h5>
          <p><?php echo $usuarios_cadastrados; ?> clientes</p>
          <a href="relatorios.php" class="btn-rosa">Ver Relatório</a>
        </div>
        
        <div class="dashboard-card">
          <h5>Serviços</h5>
          <p><?php echo $servicos_ativos; ?> ativos</p>
          <a href="catalogoAdmin.php" class="btn-rosa">Ver Catálogo</a>
        </div>
        
        <div class="dashboard-card">
          <h5>Agendamentos Hoje</h5>
          <p><?php echo $agendamentos_hoje; ?> agendamentos</p>
          <a href="agendaAdmin.php" class="btn-rosa">Ver Agenda</a>
        </div>
      </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>

<style>
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