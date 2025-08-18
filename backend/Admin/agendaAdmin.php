<?php include 'includes/headerAdmin.php'; ?>
<section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Painel de agendamentos
        </h2>
      </div>


    <!-- Filtros -->
    <div class="row filtro-admin mb-4">
      <div class="col-md-6 col-lg-4">
        <input type="date" id="filtroData" class="form-control" placeholder="Filtrar por data">
      </div>
      
    </div>

    <!-- Tabela de agendamentos -->
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Cliente</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Serviço</th>
            <th>Pagamento</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="agendamentosTabela">
          <!-- Preenchido dinamicamente -->
        </tbody>
      </table>
    </div>
  </main>

  <?php include 'includes/footer.php'; ?>