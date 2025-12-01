<?php
// Usar o sistema de autenticação que você já tem
include '../includes/auth_redirect.php';
requireAuth([2]); // Somente usuários cadastrados
include '../includes/headerCadastrado.php';
include '../includes/db.php';
include '../includes/agenda_functions.php';

// Buscar procedimentos para o select
$procedimentos = getProcedimentosParaAgendamento($conn);
?>

<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Agende seu horário</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="professional-card text-center">
                            <img src="../images/cabeleireira.png" alt="Juliana Wolff" class="professional-img">
                            <h3>Juliana Wolff</h3>
                            <h5 class="text-muted mb-4">Especialista em Cuidados Capilares</h5>
                            
                            <div class="availability mb-4">
                                <p><i class="far fa-clock contact-icon"></i> Terça a Sexta: 9h às 19h</p>
                                <p><i class="far fa-clock contact-icon"></i> Sábado: 9h às 17h</p>
                                <p><i class="fas fa-ban contact-icon text-danger"></i> Domingo: Fechado</p>
                            </div>
                            
                            <div class="contact-info mb-4">
                                <p><i class="fas fa-phone-alt contact-icon"></i> (51) 98765-4321</p>
                                <p><i class="fas fa-map-marker-alt contact-icon"></i> Rolante/RS</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                        <!-- Alertas de mensagem -->
                        <?php if (isset($_SESSION['msg_agendamento'])): ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <?php echo $_SESSION['msg_agendamento']; unset($_SESSION['msg_agendamento']); ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['erro_agendamento'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <?php echo $_SESSION['erro_agendamento']; unset($_SESSION['erro_agendamento']); ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>

                        <form id="appointmentForm" action="../includes/agendamento_process.php" method="POST">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="clientName">Nome completo</label>
                                    <input type="text" class="form-control" id="clientName" value="<?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>" readonly>
                                    <small class="text-muted">Dados do seu cadastro</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="clientPhone">Telefone/WhatsApp</label>
                                    <input type="tel" class="form-control" id="clientPhone" readonly>
                                    <small class="text-muted">Dados do seu cadastro</small>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="clientEmail">E-mail</label>
                                    <input type="email" class="form-control" id="clientEmail" readonly>
                                    <small class="text-muted">Dados do seu cadastro</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="appointmentDate">Data do agendamento *</label>
                                    <input type="date" class="form-control" id="appointmentDate" name="appointmentDate" min="<?php echo date('Y-m-d'); ?>" required>
                                    <small class="form-text text-muted">Selecione uma data para ver os horários disponíveis</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Horário disponível *</label>
                                <div id="timePickerContainer">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Selecione uma data para ver os horários disponíveis
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
    <label for="serviceType">Serviço desejado *</label>
    <select class="form-control" id="serviceType" name="serviceType" required>
        <option value="">Selecione o serviço</option>
        <?php foreach ($procedimentos as $proc): ?>
            <option value="<?= $proc['procedimento_id'] ?>" 
                    data-valor="<?= $proc['valor_procedimento'] ?>"
                    data-duracao="<?= $proc['tempo_procedimento'] ?>">
                <?= htmlspecialchars($proc['nome_procedimento']) ?> 
                - R$ <?= number_format($proc['valor_procedimento'], 2, ',', '.') ?>
                (<?= $proc['tempo_procedimento'] ?> min)
            </option>
        <?php endforeach; ?>
    </select>
</div>
                            
                            <div class="form-group">
                                <label for="paymentMethod">Forma de Pagamento *</label>
                                <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                                    <option value="">Selecione a forma de pagamento</option>
                                    <option value="Dinheiro">Dinheiro</option>
                                    <option value="PIX">PIX</option>
                                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                                    <option value="Cartão de Débito">Cartão de Débito</option>
                                    <option value="Transferência Bancária">Transferência Bancária</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="clientNotes">Observações</label>
                                <textarea class="form-control" id="clientNotes" name="clientNotes" rows="3" placeholder="Alguma observação importante? Ex: Corte com franja, coloração específica, etc."></textarea>
                            </div>
                            
                            <div class="total-price-container bg-light p-3 rounded mb-4">
                                <h5 class="text-center">Total: <span id="totalPrice">R$ 0,00</span></h5>
                            </div>
                            
                            <div class="text-center mt-2">
                                <button type="submit" class="btn btn-rosa btn-lg btn-confirmar-agendamento">
                                    <i class="fas fa-calendar-check"></i> Confirmar Agendamento
                                </button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preencher dados do usuário (para agendaCadastrado.php)
    if (typeof fetch !== 'undefined') {
        fetch('../includes/get_user_data.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (document.getElementById('clientPhone')) {
                        document.getElementById('clientPhone').value = data.telefone || '';
                    }
                    if (document.getElementById('clientEmail')) {
                        document.getElementById('clientEmail').value = data.email || '';
                    }
                }
            })
            .catch(error => {
                console.log('Erro ao carregar dados do usuário:', error);
            });
    }

    // Configurar data mínima (hoje)
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('appointmentDate').min = today;

    // Atualizar preço E DURAÇÃO quando serviço for selecionado
    document.getElementById('serviceType').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const valor = selectedOption.getAttribute('data-valor');
        const duracao = selectedOption.getAttribute('data-duracao');
        
        if (valor) {
            document.getElementById('totalPrice').textContent = 'R$ ' + parseFloat(valor).toLocaleString('pt-BR', {minimumFractionDigits: 2});
        } else {
            document.getElementById('totalPrice').textContent = 'R$ 0,00';
        }
        
        // Se há uma data selecionada, recarregar horários com a nova duração
        const dataSelecionada = document.getElementById('appointmentDate').value;
        if (dataSelecionada && duracao) {
            carregarHorariosDisponiveis(dataSelecionada, parseInt(duracao));
        }
    });

    // Carregar horários quando data for selecionada (agora com duração)
    document.getElementById('appointmentDate').addEventListener('change', function() {
        const servicoSelecionado = document.getElementById('serviceType');
        const duracao = servicoSelecionado.options[servicoSelecionado.selectedIndex].getAttribute('data-duracao') || 30;
        
        carregarHorariosDisponiveis(this.value, parseInt(duracao));
    });

    // Interceptar envio do formulário (para agenda.php)
    const appointmentForm = document.getElementById('appointmentForm');
    if (appointmentForm && !appointmentForm.action.includes('agendamento_process.php')) {
        appointmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!isUserLoggedIn()) {
                showLoginAlert();
                return false;
            }
        });
    }
});

function carregarHorariosDisponiveis(data, duracao = 30) {
    if (!data) return;
    
    const container = document.getElementById('timePickerContainer');
    container.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Carregando horários disponíveis...</div>';
    
    // Usar o arquivo existente, mas agora com parâmetro de duração
    fetch(`../includes/get_horarios_disponiveis.php?data=${data}&duracao=${duracao}`)
        .then(response => response.json())
        .then(resultado => {
            if (resultado.success) {
                exibirHorariosDisponiveis(resultado.horarios, resultado.duracao);
            } else {
                container.innerHTML = `<div class="alert alert-danger">${resultado.message}</div>`;
            }
        })
        .catch(error => {
            container.innerHTML = '<div class="alert alert-danger">Erro ao carregar horários</div>';
            console.error('Erro:', error);
        });
}

function exibirHorariosDisponiveis(horarios, duracao) {
    const container = document.getElementById('timePickerContainer');
    
    if (horarios.length === 0) {
        container.innerHTML = `
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                Não há horários disponíveis para esta data com duração de ${duracao} minutos.
                Por favor, selecione outra data ou serviço com duração diferente.
            </div>
        `;
        return;
    }
    
    let html = `
        <div class="time-picker">
            <div class="alert alert-info mb-3">
                <i class="fas fa-info-circle"></i> 
                Duração do serviço: <strong>${duracao} minutos</strong>
            </div>
    `;
    
    // Separar horários por período
    const manha = horarios.filter(h => parseInt(h.split(':')[0]) < 12);
    const tarde = horarios.filter(h => parseInt(h.split(':')[0]) >= 12);
    
    if (manha.length > 0) {
        html += `
            <div class="time-period">
                <h6><i class="fas fa-sun"></i> Manhã</h6>
                <div class="time-options">
                    ${manha.map(horario => `
                        <label class="time-option">
                            <input type="radio" name="appointmentTime" value="${horario}" required>
                            <span>${horario}</span>
                            <small class="text-muted">(${duracao}min)</small>
                        </label>
                    `).join('')}
                </div>
            </div>
        `;
    }
    
    if (tarde.length > 0) {
        html += `
            <div class="time-period">
                <h6><i class="fas fa-cloud-sun"></i> Tarde</h6>
                <div class="time-options">
                    ${tarde.map(horario => `
                        <label class="time-option">
                            <input type="radio" name="appointmentTime" value="${horario}" required>
                            <span>${horario}</span>
                            <small class="text-muted">(${duracao}min)</small>
                        </label>
                    `).join('')}
                </div>
            </div>
        `;
    }
    
    html += '</div>';
    container.innerHTML = html;
}

// Funções auxiliares para agenda.php
function isUserLoggedIn() {
    // Verificação simples baseada na session PHP
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['usuario_tipo'] == 2): ?>
        return true;
    <?php else: ?>
        return false;
    <?php endif; ?>
}

function showLoginAlert() {
    const alert = document.getElementById('loginAlert');
    if (alert) {
        alert.style.display = 'block';
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        alert.classList.add('alert-highlight');
        setTimeout(() => {
            alert.classList.remove('alert-highlight');
        }, 2000);
    }
}
</script>

<?php include '../includes/footer.php'; ?>