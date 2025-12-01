<?php
include '../includes/auth_redirect.php';
requireAuth([1]); // Somente admin
include '../includes/headerAdmin.php';
include '../includes/db.php';

// Buscar agendamentos reais com mais informações
$sql = "SELECT a.agendamento_id, u.nome_usuario, u.telefone_usuario, u.email_usuario,
               p.nome_procedimento, p.valor_procedimento, p.tempo_procedimento,
               a.data_procedimento, a.horario_procedimento, a.status_procedimento,
               a.forma_pagamento, a.observacoes
        FROM agendamento a
        JOIN usuario u ON a.usuario_id = u.usuario_id
        JOIN agendamento_procedimento ap ON a.agendamento_id = ap.agendamento_id
        JOIN procedimento p ON ap.procedimento_id = p.procedimento_id
        WHERE a.data_procedimento >= CURDATE()
        ORDER BY a.data_procedimento, a.horario_procedimento";

$result = $conn->query($sql);
?>

<main class="container py-4" style="min-height: 80vh; margin-bottom: 60px;">
    <div class="row justify-content-center">
        <div class="col-12">
            
            <!-- Título Centralizado -->
            <div class="heading_container heading_center mb-4">
                <h2>Agenda de Atendimentos</h2>
            </div>

            <?php if (isset($_SESSION['msg_agenda'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo $_SESSION['msg_agenda']; unset($_SESSION['msg_agenda']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-soft mb-5">
                <!-- Cabeçalho ROSA -->
                <div class="card-header bg-light-pink text-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt mr-2"></i>Próximos Agendamentos</h5>
                        <span class="badge badge-light"><?= $result->num_rows ?> agendamentos</span>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 agenda-table">
                            <thead class="agenda-thead">
                                <tr>
                                    <th class="px-3">Cliente</th>
                                    <th class="px-3">Contato</th>
                                    <th class="px-3">Serviço</th>
                                    <th class="px-3">Data/Hora</th>
                                    <th class="px-3">Duração</th>
                                    <th class="px-3">Valor</th>
                                    <th class="px-3">Pagamento</th>
                                    <th class="px-3">Status</th>
                                    <th class="px-3" width="180">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while($ag = $result->fetch_assoc()): ?>
                                        <?php
                                        // Definir classe da linha baseada no status
                                        $row_class = '';
                                        $status_badge = '';
                                        $status_icon = '';
                                        $is_canceled = $ag['status_procedimento'] == 'cancelado';
                                        
                                        switch($ag['status_procedimento']) {
                                            case 'confirmado':
                                                $row_class = 'agenda-row-confirmed';
                                                $status_badge = 'confirmed';
                                                $status_icon = 'check';
                                                break;
                                            case 'pendente':
                                                $row_class = 'agenda-row-pending';
                                                $status_badge = 'pending';
                                                $status_icon = 'clock';
                                                break;
                                            case 'concluido':
                                                $row_class = 'agenda-row-completed';
                                                $status_badge = 'completed';
                                                $status_icon = 'flag-checkered';
                                                break;
                                            case 'cancelado':
                                                $row_class = 'agenda-row-canceled';
                                                $status_badge = 'canceled';
                                                $status_icon = 'times';
                                                break;
                                        }
                                        ?>
                                        <tr class="<?= $row_class ?>">
                                            <td class="px-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle avatar-<?= $status_badge ?> mr-3">
                                                        <?= strtoupper(substr($ag['nome_usuario'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <strong class="<?= $is_canceled ? 'text-muted' : '' ?>">
                                                            <?= htmlspecialchars($ag['nome_usuario']) ?>
                                                        </strong>
                                                        <?php if (!empty($ag['observacoes'])): ?>
                                                            <br>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-info mt-1" 
                                                                    onclick="mostrarObservacoes('<?= htmlspecialchars($ag['observacoes']) ?>')"
                                                                    data-toggle="tooltip" 
                                                                    title="Ver observações">
                                                                <i class="fas fa-eye mr-1"></i>Observações
                                                            </button>
                                                        <?php else: ?>
                                                            <br><small class="text-muted">Sem observações</small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3">
                                                <small class="<?= $is_canceled ? 'text-muted' : '' ?>">
                                                    <div><i class="fas fa-envelope text-muted mr-1"></i> <?= htmlspecialchars($ag['email_usuario']) ?></div>
                                                    <div><i class="fas fa-phone text-muted mr-1"></i> <?= htmlspecialchars($ag['telefone_usuario']) ?></div>
                                                </small>
                                            </td>
                                            <td class="px-3">
                                                <strong class="<?= $is_canceled ? 'text-muted' : '' ?>"><?= htmlspecialchars($ag['nome_procedimento']) ?></strong>
                                            </td>
                                            <td class="px-3">
                                                <div class="text-center <?= $is_canceled ? 'text-muted' : '' ?>">
                                                    <strong class="d-block"><?= date('d/m', strtotime($ag['data_procedimento'])) ?></strong>
                                                    <small class="text-muted"><?= date('H:i', strtotime($ag['horario_procedimento'])) ?></small>
                                                </div>
                                            </td>
                                            <td class="px-3">
                                                <span class="badge badge-secondary <?= $is_canceled ? 'badge-canceled' : '' ?>"><?= $ag['tempo_procedimento'] ?> min</span>
                                            </td>
                                            <td class="px-3">
                                                <strong class="<?= $is_canceled ? 'text-muted' : '' ?>">R$ <?= number_format($ag['valor_procedimento'], 2, ',', '.') ?></strong>
                                            </td>
                                            <td class="px-3">
                                                <span class="badge badge-light border <?= $is_canceled ? 'badge-canceled' : '' ?>"><?= $ag['forma_pagamento'] ?? 'Não informado' ?></span>
                                            </td>
                                            <td class="px-3">
                                                <span class="badge badge-<?= $status_badge ?>">
                                                    <i class="fas fa-<?= $status_icon ?> mr-1"></i>
                                                    <?= ucfirst($ag['status_procedimento']) ?>
                                                </span>
                                            </td>
                                            <td class="px-3">
                                                <div class="action-buttons">
                                                    <?php if ($ag['status_procedimento'] == 'pendente'): ?>
                                                        <button class="btn btn-success btn-sm btn-action" 
                                                                onclick="confirmarAgendamento(<?= $ag['agendamento_id'] ?>, '<?= htmlspecialchars($ag['nome_usuario']) ?>')" 
                                                                title="Confirmar Agendamento"
                                                                data-toggle="tooltip">
                                                            <i class="fas fa-check"></i> Confirmar
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($ag['status_procedimento'] != 'concluido' && $ag['status_procedimento'] != 'cancelado'): ?>
                                                        <button class="btn btn-primary btn-sm btn-action mt-1" 
                                                                onclick="concluirAgendamento(<?= $ag['agendamento_id'] ?>, '<?= htmlspecialchars($ag['nome_usuario']) ?>')" 
                                                                title="Marcar como Concluído"
                                                                data-toggle="tooltip">
                                                            <i class="fas fa-flag-checkered"></i> Concluir
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($ag['status_procedimento'] != 'cancelado'): ?>
                                                        <button class="btn btn-danger btn-sm btn-action mt-1" 
                                                                onclick="cancelarAgendamento(<?= $ag['agendamento_id'] ?>, '<?= htmlspecialchars($ag['nome_usuario']) ?>')" 
                                                                title="Cancelar Agendamento"
                                                                data-toggle="tooltip">
                                                            <i class="fas fa-times"></i> Cancelar
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="badge badge-canceled-full">Cancelado</span>
                                                    <?php endif; ?>
                                                    
                                                    <button class="btn btn-info btn-sm btn-action mt-1" 
                                                            onclick="reenviarNotificacao(<?= $ag['agendamento_id'] ?>, '<?= htmlspecialchars($ag['nome_usuario']) ?>')" 
                                                            title="Reenviar Notificação"
                                                            data-toggle="tooltip">
                                                        <i class="fas fa-bell"></i> Notificar
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5 px-3">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Nenhum agendamento futuro encontrado</h5>
                                            <p class="text-muted">Todos os agendamentos foram processados ou não há agendamentos futuros.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal para Observações -->
<div class="modal fade" id="modalObservacoes" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light-pink text-white">
                <h5 class="modal-title">
                    <i class="fas fa-comment-alt"></i> Observações do Cliente
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    Observações fornecidas pelo cliente durante o agendamento
                </div>
                <div class="p-3 bg-light rounded">
                    <p id="observacoesContent" class="mb-0" style="white-space: pre-wrap;"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-rosa" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos harmonizados para Agenda */
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
    color: white;
}

.avatar-confirmed {
    background: linear-gradient(135deg, #f783ac, #e64980);
}

.avatar-pending {
    background: linear-gradient(135deg, #ffc107, #ff8c00);
}

.avatar-completed {
    background: linear-gradient(135deg, #17a2b8, #138496);
}

.avatar-canceled {
    background: linear-gradient(135deg, #6c757d, #495057);
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.btn-action {
    width: 100%;
    font-size: 12px;
    padding: 5px 8px;
    border-radius: 20px;
    border: none;
    transition: all 0.3s ease;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.table td {
    vertical-align: middle;
    padding: 12px 8px;
}

.badge {
    font-size: 12px;
    font-weight: 600;
}

.card {
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.bg-light-pink {
    background: linear-gradient(135deg, #f783ac, #e64980) !important;
}

/* Cabeçalho da tabela */
.agenda-thead {
    background: linear-gradient(135deg, #fff0f6, #ffdeeb) !important;
}

.agenda-thead th {
    color: #e64980;
    font-weight: 700;
    border-bottom: 2px solid #f783ac;
    padding: 15px 1rem;
}

/* Linhas da tabela */
.agenda-table tbody tr {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.agenda-table tbody tr:hover {
    background-color: rgba(247, 131, 172, 0.05) !important;
    transform: translateX(2px);
}

.agenda-row-confirmed {
    border-left-color: #f783ac;
    background-color: rgba(247, 131, 172, 0.03);
}

.agenda-row-pending {
    border-left-color: #ffc107;
    background-color: rgba(255, 193, 7, 0.03);
}

.agenda-row-completed {
    border-left-color: #17a2b8;
    background-color: rgba(23, 162, 184, 0.03);
}

.agenda-row-canceled {
    border-left-color: #6c757d;
    background-color: rgba(108, 117, 125, 0.08);
    opacity: 0.7;
}

.agenda-row-canceled td {
    color: #6c757d !important;
}

/* Badges de status */
.badge-confirmed {
    background: linear-gradient(135deg, #f783ac, #e64980);
    color: white;
}

.badge-pending {
    background: linear-gradient(135deg, #ffc107, #ff8c00);
    color: #000;
}

.badge-completed {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
}

.badge-canceled {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
}

.badge-canceled-full {
    background: linear-gradient(135deg, #6c757d, #495057);
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-canceled {
    opacity: 0.6;
}

/* Botões com cores do tema */
.btn-success {
    background: linear-gradient(135deg, #f783ac, #e64980);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(135deg, #e64980, #f783ac);
}

.btn-primary {
    background: linear-gradient(135deg, #17a2b8, #138496);
    border: none;
}

.btn-danger {
    background: linear-gradient(135deg, #e64980, #c2185b);
    border: none;
}

.btn-info {
    background: linear-gradient(135deg, #6c757d, #495057);
    border: none;
}

/* Espaçamento nas laterais da tabela */
.table th.px-3,
.table td.px-3 {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
}

/* Melhorias de responsividade */
@media (max-width: 1200px) {
    .table-responsive {
        font-size: 0.9rem;
    }
}

@media (max-width: 992px) {
    .action-buttons {
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .btn-action {
        width: auto;
        flex: 1;
        min-width: 80px;
        margin: 2px;
    }
}

@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .avatar-circle {
        width: 35px;
        height: 35px;
        font-size: 14px;
    }
    
    .btn-action {
        font-size: 11px;
        padding: 4px 6px;
    }
    
    .card-header h5 {
        font-size: 1rem;
    }
    
    .table th.px-3,
    .table td.px-3 {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }
}

@media (max-width: 576px) {
    .table-responsive {
        font-size: 0.75rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-action {
        width: 100%;
        font-size: 10px;
    }
    
    .heading_container h2 {
        font-size: 1.8rem;
    }
    
    .table th.px-3,
    .table td.px-3 {
        padding-left: 0.25rem !important;
        padding-right: 0.25rem !important;
    }
}

/* Garantir espaço acima do footer */
main {
    margin-bottom: 80px !important;
    min-height: calc(100vh - 200px);
}

.container {
    padding-left: 15px;
    padding-right: 15px;
}
</style>

<script>
// ... (mantenha o mesmo JavaScript da versão anterior)
function confirmarAgendamento(id, nome) {
    if (confirm(`Confirmar agendamento de ${nome}? O cliente será notificado por email.`)) {
        showLoading('Confirmando agendamento...');
        window.location.href = '../includes/agenda_admin_process.php?acao=confirmar&id=' + id;
    }
}

function concluirAgendamento(id, nome) {
    if (confirm(`Marcar agendamento de ${nome} como concluído?`)) {
        showLoading('Marcando como concluído...');
        window.location.href = '../includes/agenda_admin_process.php?acao=concluir&id=' + id;
    }
}

function cancelarAgendamento(id, nome) {
    const motivo = prompt(`Cancelar agendamento de ${nome}? Informe o motivo do cancelamento:`);
    if (motivo !== null) {
        if (motivo.trim() === '') {
            alert('Por favor, informe o motivo do cancelamento.');
            return;
        }
        showLoading('Cancelando agendamento...');
        window.location.href = '../includes/agenda_admin_process.php?acao=cancelar&id=' + id + '&motivo=' + encodeURIComponent(motivo);
    }
}

function reenviarNotificacao(id, nome) {
    if (confirm(`Reenviar notificação para ${nome}?`)) {
        showLoading('Enviando notificação...');
        fetch('../includes/notificacao_process.php?acao=reenviar&id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Notificação enviada com sucesso!', 'success');
                } else {
                    showAlert('Erro ao enviar notificação: ' + data.message, 'danger');
                }
            })
            .catch(error => {
                showAlert('Erro ao enviar notificação.', 'danger');
            });
    }
}

function showLoading(message) {
    console.log(message);
}

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    `;
    document.querySelector('main').insertBefore(alertDiv, document.querySelector('main').firstChild);
}

function mostrarObservacoes(observacoes) {
    document.getElementById('observacoesContent').textContent = observacoes;
    $('#modalObservacoes').modal('show');
}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<?php include '../includes/footer.php'; ?>