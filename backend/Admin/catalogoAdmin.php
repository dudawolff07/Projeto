<?php 
session_start();

// Inicializar array de produtos na sessão se não existir
if (!isset($_SESSION['produtos'])) {
    $_SESSION['produtos'] = [
        [
            'id' => 1,
            'nome' => 'Corte + Hidratação',
            'descricao' => 'Transformação completa para seu cabelo com corte personalizado e hidratação profunda para devolver a saúde aos fios.',
            'preco' => 120,
            'categoria' => 'combos',
            'imagem' => '../images/corteEhidratacao.jpg'
        ],
        [
            'id' => 2,
            'nome' => 'Penteado Simples',
            'descricao' => 'Ideal para quem busca realçar a beleza do cabelo de forma natural e elegante para o dia a dia ou ocasiões especiais.',
            'preco' => 80,
            'categoria' => 'penteados',
            'imagem' => '../images/penteadoSimples.png'
        ],
        [
            'id' => 3,
            'nome' => 'Corte + Penteado Simples',
            'descricao' => 'Ideal para quem busca realçar a beleza do cabelo de forma natural e elegante para o dia a dia ou ocasiões especiais.',
            'preco' => 80,
            'categoria' => 'combos',
            'imagem' => '../images/cortePenteado.jpg'
        ],
        [
            'id' => 4,
            'nome' => 'Hidratação Profunda',
            'descricao' => 'Tratamento intensivo que nutre e recupera os fios danificados, devolvendo brilho, maciez e vitalidade ao cabelo.',
            'preco' => 90,
            'categoria' => 'tratamentos',
            'imagem' => '../images/tratamento.png'
        ],
        [
            'id' => 5,
            'nome' => 'Progressiva sem Formol',
            'descricao' => 'Alisamento moderno que reduz o volume e o frizz sem agredir os fios, com fórmula livre de formol e proteção térmica.',
            'preco' => 180,
            'categoria' => 'progressiva',
            'imagem' => '../images/alisamentosemformol.png'
        ],
        [
            'id' => 6,
            'nome' => 'Corte Feminino',
            'descricao' => 'Corte personalizado de acordo com o formato do seu rosto e estilo pessoal, realizado por profissionais especializados.',
            'preco' => 70,
            'categoria' => 'corte',
            'imagem' => '../images/cortefeminino.png'
        ],
        [
            'id' => 7,
            'nome' => 'Coloração',
            'descricao' => 'Transforme seu visual com nossa coloração profissional, utilizando produtos de alta qualidade para um resultado vibrante e duradouro.',
            'preco' => 70,
            'categoria' => 'coloracao',
            'imagem' => '../images/coloracao.png'
        ]
    ];
}

// Processar ações de CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'criar':
                $novoId = count($_SESSION['produtos']) > 0 ? max(array_column($_SESSION['produtos'], 'id')) + 1 : 1;
                
                $novoProduto = [
                    'id' => $novoId,
                    'nome' => $_POST['nome'],
                    'descricao' => $_POST['descricao'],
                    'preco' => floatval($_POST['preco']),
                    'categoria' => $_POST['categoria'],
                    'imagem' => $_POST['imagem'] ?: '../images/default.jpg'
                ];
                
                array_push($_SESSION['produtos'], $novoProduto);
                $_SESSION['sucesso'] = 'Produto criado com sucesso!';
                break;
                
            case 'editar':
                $id = $_POST['produto_id'];
                $encontrado = false;
                foreach ($_SESSION['produtos'] as &$produto) {
                    if ($produto['id'] == $id) {
                        $produto['nome'] = $_POST['nome'];
                        $produto['descricao'] = $_POST['descricao'];
                        $produto['preco'] = floatval($_POST['preco']);
                        $produto['categoria'] = $_POST['categoria'];
                        if (!empty($_POST['imagem'])) {
                            $produto['imagem'] = $_POST['imagem'];
                        }
                        $encontrado = true;
                        $_SESSION['sucesso'] = 'Produto atualizado com sucesso!';
                        break;
                    }
                }
                if (!$encontrado) {
                    $_SESSION['erro'] = 'Produto não encontrado!';
                }
                break;
                
            case 'excluir':
                $id = $_POST['produto_id'];
                $countAntes = count($_SESSION['produtos']);
                $_SESSION['produtos'] = array_filter($_SESSION['produtos'], function($produto) use ($id) {
                    return $produto['id'] != $id;
                });
                
                if (count($_SESSION['produtos']) < $countAntes) {
                    $_SESSION['sucesso'] = 'Produto excluído com sucesso!';
                } else {
                    $_SESSION['erro'] = 'Produto não encontrado para exclusão!';
                }
                break;
        }
    }
    
    // Redirecionar para evitar reenvio do formulário
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

include '../includes/headerAdmin.php'; 
?>

<!-- O resto do código permanece igual ao fornecido anteriormente -->
<section class="food_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Nossos Serviços Capilares
        </h2>
        <button class="btn-rosa" onclick="abrirModalCriar()" style="margin-top: 20px;">
          + Adicionar Novo Produto
        </button>
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">Todos</li>
        <li data-filter=".penteados">Penteados</li>
        <li data-filter=".corte">Cortes</li>
        <li data-filter=".combos">Combos</li>
        <li data-filter=".tratamentos">Tratamentos</li>
        <li data-filter=".progressiva">Progressiva</li>
        <li data-filter=".coloracao">Coloração</li>
      </ul>

      <div class="filters-content">
        <div class="row grid">
          <?php foreach ($_SESSION['produtos'] as $produto): ?>
          <div class="col-sm-6 col-lg-4 all <?= $produto['categoria'] ?>">
            <div class="box">
              <div>
                <div class="img-box">
                  <img src="<?= $produto['imagem'] ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                </div>
                <div class="detail-box">
                  <h5>
                    <?= htmlspecialchars($produto['nome']) ?>
                  </h5>
                  <p>
                    <?= htmlspecialchars($produto['descricao']) ?>
                  </p>
                  <div class="options">
                    <h6>
                      R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                    </h6>
                    <div class="adm-actions">
                      <button onclick="editarProduto(<?= $produto['id'] ?>)" title="Editar" class="btn-editar">✏️</button>
                      <button onclick="apagarProduto(<?= $produto['id'] ?>)" title="Excluir" class="btn-apagar">🗑️</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
</section>

<!-- Modal para Criar/Editar Produto -->
<div id="modalProduto" class="login-modal" style="display: none;">
  <div class="modal-content adm-modal-content">
    <span class="close-modal" onclick="fecharModal()">&times;</span>
    <h3 id="modalTitulo" class="modal-title">Novo Produto</h3>
    <form id="formProduto" class="form-produto" method="POST">
      <input type="hidden" id="produtoId" name="produto_id" value="">
      <input type="hidden" name="acao" id="acao" value="criar">
      
      <div class="form-group">
        <input type="text" id="nomeProduto" name="nome" placeholder="Nome do Produto" required>
      </div>
      <div class="form-group">
        <textarea id="descricaoProduto" name="descricao" placeholder="Descrição" required></textarea>
      </div>
      <div class="form-group">
        <input type="number" id="precoProduto" name="preco" step="0.01" min="0" placeholder="Preço (R$)" required>
      </div>
      <div class="form-group">
        <select id="categoriaProduto" name="categoria" required>
          <option value="">Selecione a Categoria</option>
          <option value="penteados">Penteados</option>
          <option value="corte">Cortes</option>
          <option value="combos">Combos</option>
          <option value="tratamentos">Tratamentos</option>
          <option value="progressiva">Progressiva</option>
          <option value="coloracao">Coloração</option>
        </select>
      </div>
      <div class="form-group">
<input type="file" class="form-control" name="imagem" accept="image/*">
      </div>
      <div class="form-buttons">
        <button type="submit" class="btn-rosa">Salvar Produto</button>
        <button type="button" class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="modalConfirmacao" class="login-modal" style="display: none;">
  <div class="modal-content adm-modal-content">
    <h3>Confirmar Exclusão</h3>
    <p>Tem certeza que deseja excluir este produto?</p>
    <form id="formExcluir" method="POST">
      <input type="hidden" name="acao" value="excluir">
      <input type="hidden" id="excluirProdutoId" name="produto_id" value="">
      <div class="form-buttons">
        <button type="submit" class="btn-apagar">Sim, Excluir</button>
        <button type="button" class="btn-cancelar" onclick="fecharModalConfirmacao()">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<?php 
// Adicionar notificações
if (isset($_SESSION['sucesso'])): ?>
<div class="alert alert-sucesso">
    <?= $_SESSION['sucesso']; unset($_SESSION['sucesso']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['erro'])): ?>
<div class="alert alert-erro">
    <?= $_SESSION['erro']; unset($_SESSION['erro']); ?>
</div>
<?php endif; ?>

<style>
.alert {
    padding: 15px;
    margin: 10px 0;
    border-radius: 5px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1100;
    max-width: 300px;
}

.alert-sucesso {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-erro {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.adm-actions {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}


.login-modal {
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.adm-modal-content {
  background-color: #fefefe;
  padding: 25px;
  border-radius: 10px;
  width: 90%;
  max-width: 500px;
  position: relative;
}

.close-modal {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 24px;
  cursor: pointer;
}

.form-produto {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group input,
.form-group textarea,
.form-group select {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
}

.form-group textarea {
  min-height: 100px;
  resize: vertical;
}

.form-buttons {
  display: flex;
  gap: 10px;
  justify-content: flex-end;
  margin-top: 15px;
}

.btn-rosa {
  background-color: #ff4b8b;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.btn-rosa:hover {
  background-color: #e63d7a;
}

.btn-cancelar {
  background-color: #6c757d;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.btn-cancelar:hover {
  background-color: #5a6268;
}

.btn-salvar {
  background-color: #4CAF50;
}

.btn-salvar:hover {
  background-color: #45a049;
}

.btn-apagar {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.btn-apagar:hover {
  background-color: #d32f2f;
}
</style>

<script>
// Variáveis globais
let produtos = <?= json_encode($_SESSION['produtos']) ?>;

// Funções para abrir modais
function abrirModalCriar() {
  document.getElementById('modalTitulo').textContent = 'Novo Produto';
  document.getElementById('acao').value = 'criar';
  document.getElementById('produtoId').value = '';
  document.getElementById('formProduto').reset();
  document.getElementById('modalProduto').style.display = 'block';
}

function editarProduto(id) {
  const produto = produtos.find(p => p.id == id);
  
  if (produto) {
    document.getElementById('modalTitulo').textContent = 'Editar Produto';
    document.getElementById('acao').value = 'editar';
    document.getElementById('produtoId').value = produto.id;
    document.getElementById('nomeProduto').value = produto.nome;
    document.getElementById('descricaoProduto').value = produto.descricao;
    document.getElementById('precoProduto').value = produto.preco;
    document.getElementById('categoriaProduto').value = produto.categoria;
    document.getElementById('imagemProduto').value = produto.imagem;
    
    document.getElementById('modalProduto').style.display = 'block';
  }
}

function apagarProduto(id) {
  document.getElementById('excluirProdutoId').value = id;
  document.getElementById('modalConfirmacao').style.display = 'block';
}

// Funções para fechar modais
function fecharModal() {
  document.getElementById('modalProduto').style.display = 'none';
}

function fecharModalConfirmacao() {
  document.getElementById('modalConfirmacao').style.display = 'none';
}

// Esconder alertas automaticamente após 5 segundos
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.display = 'none';
    });
}, 5000);
</script>

<?php include '../includes/footer.php'; ?>