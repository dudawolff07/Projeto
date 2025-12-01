<?php 
include '../includes/headerAdmin.php'; 
include '../includes/db.php';
include '../includes/profissional_functions.php';

// Processar formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['adicionar_formacao'])) {
        $titulo = $_POST['titulo_formacao'];
        adicionarInformacaoProfissional($conn, 'formacao', $titulo);
        $_SESSION['msg_sucesso'] = "Formação adicionada com sucesso!";
    }
    
    if (isset($_POST['adicionar_especialidade'])) {
        $titulo = $_POST['titulo_especialidade'];
        adicionarInformacaoProfissional($conn, 'especialidade', $titulo);
        $_SESSION['msg_sucesso'] = "Especialidade adicionada com sucesso!";
    }
    
    if (isset($_POST['adicionar_certificacao'])) {
        $titulo = $_POST['titulo_certificacao'];
        adicionarInformacaoProfissional($conn, 'certificacao', $titulo);
        $_SESSION['msg_sucesso'] = "Certificação adicionada com sucesso!";
    }
    
    if (isset($_POST['atualizar_sobre'])) {
        $descricao = $_POST['descricao_sobre'];
        // Primeiro desativa os antigos
        $conn->query("UPDATE profissional_info SET ativo = FALSE WHERE tipo = 'sobre'");
        // Adiciona o novo
        adicionarInformacaoProfissional($conn, 'sobre', 'Descrição Profissional', $descricao);
        $_SESSION['msg_sucesso'] = "Descrição atualizada com sucesso!";
    }
    
    if (isset($_POST['excluir_item'])) {
        $id = $_POST['item_id'];
        excluirInformacaoProfissional($conn, $id);
        $_SESSION['msg_sucesso'] = "Item excluído com sucesso!";
    }
    
    header("Location: sobreAdmin.php");
    exit();
}

// Buscar dados atuais
$formacoes = getInformacoesProfissional($conn, 'formacao');
$especialidades = getInformacoesProfissional($conn, 'especialidade');
$certificacoes = getInformacoesProfissional($conn, 'certificacao');
$sobre = getInformacoesProfissional($conn, 'sobre');
$descricao_atual = !empty($sobre) ? $sobre[0]['descricao'] : '';
?>

<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <!-- Mensagens -->
            <?php if (isset($_SESSION['msg_sucesso'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo $_SESSION['msg_sucesso']; unset($_SESSION['msg_sucesso']); ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            <?php endif; ?>

            <!-- Cabeçalho -->
          <div class="heading_container heading_center mb-5">
    <h2>Editar Perfil Profissional</h2>
</div>

            <!-- Descrição do Perfil -->
            <div class="card mb-4 border-0 shadow-soft">
                <div class="card-header bg-light-pink text-white border-0 py-3">
                    <h5 class="mb-0">
                        <i class="fa fa-user-circle mr-2"></i>Descrição Profissional
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="form-group">
                            <label>Descrição sobre você:</label>
                            <textarea name="descricao_sobre" class="form-control" rows="4" placeholder="Descreva sua experiência e abordagem profissional..."><?php echo htmlspecialchars($descricao_atual); ?></textarea>
                        </div>
                        <button type="submit" name="atualizar_sobre" class="btn btn-rosa">
                            <i class="fa fa-save mr-2"></i>Atualizar Descrição
                        </button>
                    </form>
                </div>
            </div>

            <!-- Cards de Edição -->
            <div class="row">
                <!-- Formação Acadêmica -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-soft">
                        <div class="card-header bg-light-pink text-white border-0 py-3">
                            <h6 class="mb-0">
                                <i class="fa fa-graduation-cap mr-2"></i>Formação Acadêmica
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <!-- Lista de Formações -->
                            <div class="mb-3">
                                <?php foreach ($formacoes as $formacao): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                        <span><?php echo htmlspecialchars($formacao['titulo']); ?></span>
                                        <form method="POST" class="m-0">
                                            <input type="hidden" name="item_id" value="<?php echo $formacao['id']; ?>">
                                            <button type="submit" name="excluir_item" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Formulário para adicionar -->
                            <form method="POST">
                                <div class="input-group">
                                    <input type="text" name="titulo_formacao" class="form-control" placeholder="Ex: Graduação em Estética" required>
                                    <div class="input-group-append">
                                        <button type="submit" name="adicionar_formacao" class="btn btn-rosa">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Especialidades -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-soft">
                        <div class="card-header bg-light-pink text-white border-0 py-3">
                            <h6 class="mb-0">
                                <i class="fa fa-star mr-2"></i>Especialidades
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <!-- Lista de Especialidades -->
                            <div class="mb-3">
                                <?php foreach ($especialidades as $especialidade): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                        <span><?php echo htmlspecialchars($especialidade['titulo']); ?></span>
                                        <form method="POST" class="m-0">
                                            <input type="hidden" name="item_id" value="<?php echo $especialidade['id']; ?>">
                                            <button type="submit" name="excluir_item" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Formulário para adicionar -->
                            <form method="POST">
                                <div class="input-group">
                                    <input type="text" name="titulo_especialidade" class="form-control" placeholder="Ex: Coloração Vegana" required>
                                    <div class="input-group-append">
                                        <button type="submit" name="adicionar_especialidade" class="btn btn-rosa">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Certificações -->
                <div class="col-12 mb-4">
                    <div class="card border-0 shadow-soft">
                        <div class="card-header bg-light-pink text-white border-0 py-3">
                            <h6 class="mb-0">
                                <i class="fa fa-award mr-2"></i>Certificações
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <!-- Lista de Certificações -->
                            <div class="mb-3">
                                <?php foreach ($certificacoes as $certificacao): ?>
                                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                                        <span><?php echo htmlspecialchars($certificacao['titulo']); ?></span>
                                        <form method="POST" class="m-0">
                                            <input type="hidden" name="item_id" value="<?php echo $certificacao['id']; ?>">
                                            <button type="submit" name="excluir_item" class="btn btn-sm btn-outline-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Formulário para adicionar -->
                            <form method="POST">
                                <div class="input-group">
                                    <input type="text" name="titulo_certificacao" class="form-control" placeholder="Ex: Certificação Internacional" required>
                                    <div class="input-group-append">
                                        <button type="submit" name="adicionar_certificacao" class="btn btn-rosa">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
.shadow-soft {
  box-shadow: 0 2px 12px rgba(0,0,0,0.08) !important;
}

.bg-light-pink {
  background: linear-gradient(135deg, #f783ac, #f8a5c2) !important;
}
</style>

<?php include '../includes/footer.php'; ?>