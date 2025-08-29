<?php
// SIMULAÇÃO DE DADOS
$agendamentos = [
    ["cliente" => "Maria Silva", "servico" => "Hidratação Profunda", "data" => "28/08/2025", "hora" => "14:00"],
    ["cliente" => "João Souza", "servico" => "Corte Masculino", "data" => "28/08/2025", "hora" => "16:30"],
    ["cliente" => "Ana Paula", "servico" => "Progressiva sem Formol", "data" => "29/08/2025", "hora" => "10:00"]
];
?>

<?php include '../includes/headerAdmin.php'; ?>

<div class="container mt-4">
  <h2 class="mb-4">Agenda de Atendimentos</h2>

  <div class="table-responsive">
            <table class="table table-hover">

      <thead class="table-light">
        <tr>
          <th>Cliente</th>
          <th>Serviço</th>
          <th>Data</th>
          <th>Hora</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($agendamentos as $i => $ag): ?>
          <tr>
            <td><?= $ag["cliente"] ?></td>
            <td><?= $ag["servico"] ?></td>
            <td><?= $ag["data"] ?></td>
            <td><?= $ag["hora"] ?></td>
            <td>
              <button class="btn btn-sm btn-danger" 
                      onclick="alert('Função de cancelamento será implementada em breve!')">
                Cancelar
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
