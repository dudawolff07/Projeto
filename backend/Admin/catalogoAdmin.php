<?php
include '../includes/auth_redirect.php';
requireAuth([1]); // Somente admin
include '../includes/headerAdmin.php';
include '../includes/db.php';

// Buscar todos os procedimentos
$result = $conn->query("SELECT * FROM procedimento ORDER BY procedimento_id DESC");
?>

<div class="container mt-4">
    <div class="heading_container heading_center mb-4">
        <h2>Catálogo de Procedimentos</h2>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php
            if ($_GET['msg'] === 'adicionado') echo "Procedimento adicionado com sucesso!";
            if ($_GET['msg'] === 'editado') echo "Procedimento editado com sucesso!";
            if ($_GET['msg'] === 'removido') echo "Procedimento removido com sucesso!";
            ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Cabeçalho de Ações -->
    <div class="card border-0 shadow-soft mb-4">
        <div class="card-header bg-light-pink text-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-concierge-bell mr-2"></i>Gerenciar Procedimentos</h5>
                <div>
                    <span class="badge badge-light mr-2"><?= $result->num_rows ?> procedimentos</span>
                    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#modalAdd">
                        <i class="fa fa-plus"></i> Adicionar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Procedimentos (SIMPLIFICADA - SEM MODAIS REPETIDOS) -->
    <div class="card border-0 shadow-soft mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 catalog-table">
                    <thead class="catalog-thead">
                        <tr>
                            <th class="px-3">ID</th>
                            <th class="px-3">Nome</th>
                            <th class="px-3">Valor</th>
                            <th class="px-3">Tempo</th>
                            <th class="px-3">Categoria</th>
                            <th class="px-3">Foto</th>
                            <th class="px-3">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="px-3"><?= $row['procedimento_id'] ?></td>
                            <td class="px-3">
                                <strong><?= htmlspecialchars($row['nome_procedimento']) ?></strong>
                                <?php if (!empty($row['descricao_procedimento'])): ?>
                                    <br><small class="text-muted"><?= htmlspecialchars(substr($row['descricao_procedimento'], 0, 50)) ?>...</small>
                                <?php endif; ?>
                            </td>
                            <td class="px-3 text-price">R$ <?= number_format($row['valor_procedimento'], 2, ',', '.') ?></td>
                            <td class="px-3">
                                <span class="badge badge-time"><?= $row['tempo_procedimento'] ?> min</span>
                            </td>
                            <td class="px-3">
                                <span class="badge badge-category"><?= htmlspecialchars($row['categoria_procedimento']) ?></span>
                            </td>
                            <td class="px-3">
                                <?php if (!empty($row['foto_procedimento'])): ?>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($row['foto_procedimento']) ?>" 
                                         width="60" height="60" 
                                         style="object-fit: cover; border-radius: 8px; border: 2px solid #ffdeeb;" 
                                         alt="Foto"
                                         class="img-thumbnail">
                                <?php else: ?>
                                    <img src="../images/sem-foto.png" 
                                         width="60" height="60" 
                                         style="object-fit: cover; border-radius: 8px; border: 2px solid #ffdeeb;" 
                                         alt="Sem imagem"
                                         class="img-thumbnail">
                                <?php endif; ?>
                            </td>
                            <td class="px-3">
                                <div class="action-buttons">
                                    <!-- BOTÃO EDITAR -->
                                    <button class="btn btn-primary btn-sm btn-action edit-btn" 
                                            data-id="<?= $row['procedimento_id'] ?>"
                                            data-nome="<?= htmlspecialchars($row['nome_procedimento']) ?>"
                                            data-valor="<?= $row['valor_procedimento'] ?>"
                                            data-tempo="<?= $row['tempo_procedimento'] ?>"
                                            data-categoria="<?= $row['categoria_procedimento'] ?>"
                                            data-descricao="<?= htmlspecialchars($row['descricao_procedimento'] ?? '') ?>"
                                            data-foto="<?= !empty($row['foto_procedimento']) ? '1' : '0' ?>">
                                        <i class="fa fa-edit"></i> Editar
                                    </button>
                                    <!-- BOTÃO EXCLUIR -->
                                    <button class="btn btn-danger btn-sm btn-action mt-1 delete-btn" 
                                            data-id="<?= $row['procedimento_id'] ?>"
                                            data-nome="<?= htmlspecialchars($row['nome_procedimento']) ?>">
                                        <i class="fa fa-trash"></i> Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 px-3">
                                <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Nenhum procedimento cadastrado ainda.</h5>
                                <button class="btn btn-rosa mt-3" data-toggle="modal" data-target="#modalAdd">
                                    <i class="fa fa-plus"></i> Adicionar Primeiro Procedimento
                                </button>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Adicionar Novo Procedimento (MANTIDO ORIGINAL) -->
<div class="modal fade" id="modalAdd" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../includes/catalogo_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="acao" value="adicionar">
                <div class="modal-header bg-light-pink text-white">
                    <h5 class="modal-title">Adicionar Novo Procedimento</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome do Procedimento:</label>
                        <input type="text" class="form-control" name="nome_procedimento" placeholder="Ex: Corte Feminino, Hidratação Profunda..." required>
                    </div>
                    <div class="form-group">
                        <label>Valor (R$):</label>
                        <input type="number" class="form-control" name="valor_procedimento" step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label>Tempo de Duração (minutos):</label>
                        <input type="number" class="form-control" name="tempo_procedimento" min="15" max="480" placeholder="Ex: 60 para 1 hora" required>
                        <small class="form-text text-muted">Tempo estimado em minutos (15min à 8 horas)</small>
                    </div>
                    <div class="form-group">
                        <label>Categoria:</label>
                        <select class="form-control" name="categoria_procedimento" required>
                            <option value="">Selecione uma categoria</option>
                            <option value="penteados">Penteados</option>
                            <option value="corte">Cortes</option>
                            <option value="combos">Combos</option>
                            <option value="tratamentos">Tratamentos</option>
                            <option value="progressiva">Progressiva</option>
                            <option value="coloracao">Coloração</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Descrição do Serviço:</label>
                        <textarea class="form-control" name="descricao_procedimento" rows="3" placeholder="Descreva detalhes do procedimento, benefícios, etc..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto do Procedimento:</label>
                        <input type="file" class="form-control-file" name="foto_procedimento" accept="image/*">
                        <small class="form-text text-muted">Formatos: JPG, PNG, GIF. Tamanho máximo: 2MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rosa">
                        <i class="fa fa-plus"></i> Adicionar Procedimento
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Dinâmico (ÚNICO - REUTILIZÁVEL) -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../includes/catalogo_process.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="procedimento_id" id="edit_id">
                
                <div class="modal-header bg-light-pink text-white">
                    <h5 class="modal-title">Editar Procedimento</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nome do Procedimento:</label>
                        <input type="text" class="form-control" name="nome_procedimento" id="edit_nome" required>
                    </div>
                    <div class="form-group">
                        <label>Valor (R$):</label>
                        <input type="number" class="form-control" name="valor_procedimento" id="edit_valor" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Tempo de Duração (minutos):</label>
                        <input type="number" class="form-control" name="tempo_procedimento" id="edit_tempo" min="15" max="480" required>
                        <small class="form-text text-muted">Tempo estimado em minutos (ex: 60 = 1 hora, 90 = 1h30)</small>
                    </div>
                    <div class="form-group">
                        <label>Categoria:</label>
                        <select class="form-control" name="categoria_procedimento" id="edit_categoria" required>
                            <option value="penteados">Penteados</option>
                            <option value="corte">Cortes</option>
                            <option value="combos">Combos</option>
                            <option value="tratamentos">Tratamentos</option>
                            <option value="progressiva">Progressiva</option>
                            <option value="coloracao">Coloração</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Descrição do Serviço:</label>
                        <textarea class="form-control" name="descricao_procedimento" id="edit_descricao" rows="3" placeholder="Descreva o procedimento..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Foto do Procedimento:</label>
                        <input type="file" class="form-control-file" name="foto_procedimento" accept="image/*">
                        <small class="form-text text-muted" id="foto_status">Nenhuma foto cadastrada</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-rosa">
                        <i class="fa fa-save"></i> Salvar Alterações
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Excluir Dinâmico (ÚNICO - REUTILIZÁVEL) -->
<div class="modal fade" id="modalDelete" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="../includes/catalogo_process.php" method="POST">
                <input type="hidden" name="acao" value="remover">
                <input type="hidden" name="procedimento_id" id="delete_id">
                <div class="modal-header bg-light-pink text-white">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o procedimento:</p>
                    <h6 class="text-danger" id="delete_nome"></h6>
                    <p class="text-muted">Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Excluir
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JAVASCRIPT PARA CONTROLAR OS MODAIS DINÂMICOS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal de Edição
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Pegar os dados do botão clicado
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');
            const valor = this.getAttribute('data-valor');
            const tempo = this.getAttribute('data-tempo');
            const categoria = this.getAttribute('data-categoria');
            const descricao = this.getAttribute('data-descricao');
            const temFoto = this.getAttribute('data-foto');
            
            // Preencher o formulário de edição
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nome').value = nome;
            document.getElementById('edit_valor').value = valor;
            document.getElementById('edit_tempo').value = tempo;
            document.getElementById('edit_categoria').value = categoria;
            document.getElementById('edit_descricao').value = descricao;
            
            // Atualizar status da foto
            const fotoStatus = document.getElementById('foto_status');
            if (temFoto === '1') {
                fotoStatus.textContent = '✓ Foto atual disponível (o upload de nova foto substituirá a atual)';
                fotoStatus.className = 'form-text text-success';
            } else {
                fotoStatus.textContent = 'Nenhuma foto cadastrada';
                fotoStatus.className = 'form-text text-muted';
            }
            
            // Abrir modal
            $('#modalEdit').modal('show');
        });
    });
    
    // Modal de Exclusão
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');
            
            document.getElementById('delete_id').value = id;
            document.getElementById('delete_nome').textContent = `"${nome}"`;
            
            $('#modalDelete').modal('show');
        });
    });
});
</script>

<style>
/* ESTILOS HARMONIZADOS CATALOGOADMIN */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    border: 1px solid #ffdeeb;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(247, 131, 172, 0.15);
}

.bg-light-pink {
    background: linear-gradient(135deg, #f783ac, #e64980) !important;
}

.card-header.bg-light-pink {
    border-bottom: 1px solid rgba(255,255,255,0.2);
}

.card-header.bg-light-pink h5 {
    color: white;
    font-weight: 600;
}

.btn-rosa {
    background: linear-gradient(135deg, #f783ac, #e64980);
    border: none;
    color: white;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-rosa:hover {
    background: linear-gradient(135deg, #e64980, #f783ac);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(232, 62, 140, 0.3);
    color: white;
}

.btn-light {
    background: rgba(255,255,255,0.9);
    border: none;
    color: #e64980;
    border-radius: 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-light:hover {
    background: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(255,255,255,0.3);
}

.btn-primary {
    background: linear-gradient(135deg, #17a2b8, #138496) !important;
    border: none !important;
    color: white !important;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #138496, #17a2b8) !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(23, 162, 184, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #e64980, #c2185b) !important;
    border: none !important;
    font-weight: 600;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #c2185b, #e64980) !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(230, 73, 128, 0.3);
}

.catalog-table {
    border: none;
}

.catalog-thead {
    background: linear-gradient(135deg, #fff0f6, #ffdeeb) !important;
}

.catalog-thead th {
    color: #e64980 !important;
    font-weight: 700;
    border-bottom: 2px solid #f783ac;
    padding: 15px 1rem;
    background: transparent !important;
}

.table td {
    vertical-align: middle;
    padding: 12px 1rem;
    border-color: #f8f9fa;
}

.catalog-table tbody tr {
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.catalog-table tbody tr:hover {
    background-color: rgba(247, 131, 172, 0.05) !important;
    transform: translateX(2px);
    border-left-color: #f783ac;
}

.badge-category {
    background: linear-gradient(135deg, #f783ac, #e64980);
    color: white;
    font-size: 0.75rem;
    padding: 0.4em 0.8em;
    font-weight: 600;
}

.badge-time {
    background: linear-gradient(135deg, #17a2b8, #138496);
    color: white;
    font-size: 0.75rem;
    padding: 0.4em 0.8em;
    font-weight: 600;
}

.badge-light {
    background: rgba(255,255,255,0.9) !important;
    color: #e64980 !important;
    font-weight: 600;
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
    font-weight: 600;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.modal-header.bg-light-pink {
    border-radius: 15px 15px 0 0;
}

.modal-header.bg-light-pink .modal-title {
    color: white;
    font-weight: 700;
}

.modal-header.bg-light-pink .close {
    color: white;
    opacity: 0.8;
}

.modal-header.bg-light-pink .close:hover {
    opacity: 1;
}

.form-control {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #f783ac;
    box-shadow: 0 0 0 0.2rem rgba(247, 131, 172, 0.25);
}

.text-price {
    font-weight: 700;
    color: #e64980;
    font-size: 1.05em;
}

.img-thumbnail {
    transition: transform 0.3s ease;
}

.img-thumbnail:hover {
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .btn-action {
        width: auto;
        flex: 1;
        min-width: 70px;
        margin: 2px;
        font-size: 11px;
    }
    
    .table td, .table th {
        padding: 10px 0.5rem;
    }
    
    .catalog-thead th {
        font-size: 0.8rem;
        padding: 12px 0.5rem;
    }
    
    .card-header.bg-light-pink .d-flex {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
}

@media (max-width: 576px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-action {
        width: 100%;
        font-size: 10px;
    }
    
    .card-header.bg-light-pink h5 {
        font-size: 1rem;
    }
}
</style>

<?php include '../includes/footer.php'; ?>