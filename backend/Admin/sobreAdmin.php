<?php include '../includes/headerAdmin.php'; ?>
<main class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        
        <!-- Card de Informações da Profissional -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-pink text-white">
            <h2 class="heading_container heading_center mb-0">
              <i class="fa fa-user-circle mr-2"></i>Cadastro e Perfil Profissional
            </h2>
          </div>
          <div class="card-body">
            <form>
              <div class="form-group mb-4">
                <label class="font-weight-bold text-secondary">Nome:</label>
                <input type="text" class="form-control border-0 bg-light" placeholder="Seu nome completo">
              </div>
              <div class="form-group mb-4">
                <label class="font-weight-bold text-secondary">Cargo/Título:</label>
                <input type="text" class="form-control border-0 bg-light" placeholder="Ex: Cabeleireira Master">
              </div>
              <div class="form-group mb-4">
                <label class="font-weight-bold text-secondary">Descrição:</label>
                <textarea class="form-control border-0 bg-light" rows="4" placeholder="Fale sobre sua experiência e especialidades"></textarea>
              </div>
              <div class="form-group mb-4">
                <label class="font-weight-bold text-secondary">Imagem de Perfil:</label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Escolher arquivo...</label>
                </div>
                <small class="form-text text-muted">Recomendado: imagem quadrada com fundo neutro</small>
              </div>
            </form>
          </div>
        </div>

        <!-- Card de Formação Profissional -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-pink text-white">
            <h2 class="mb-0">
              <i class="fa fa-graduation-cap mr-2"></i>Formação Profissional
            </h2>
          </div>
          <div class="card-body">
            <form id="form-formacao">
              <div id="formacoes-container">
                <div class="input-group mb-3">
                  <input type="text" class="form-control border-0 bg-light" placeholder="Ex: Curso de Cabeleireira Avançada - Escola X">
                  <div class="input-group-append">
                    <button class="btn btn-outline-danger rounded-right" type="button" onclick="removeFormacao(this)">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-outline-pink mt-2" onclick="addFormacao()">
                <i class="fa fa-plus mr-2"></i>Adicionar Formação
              </button>
            </form>
          </div>
        </div>

        <!-- Card de Especialidades -->
        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-pink text-white">
            <h2 class="mb-0">
              <i class="fa fa-star mr-2"></i>Especialidades
            </h2>
          </div>
          <div class="card-body">
            <form id="form-especialidades">
              <div id="especialidades-container">
                <div class="input-group mb-3">
                  <input type="text" class="form-control border-0 bg-light" placeholder="Ex: Corte Feminino, Coloração, Luzes">
                  <div class="input-group-append">
                    <button class="btn btn-outline-danger rounded-right" type="button" onclick="removeEspecialidade(this)">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
              </div>
              <button type="button" class="btn btn-outline-pink mt-2" onclick="addEspecialidade()">
                <i class="fa fa-plus mr-2"></i>Adicionar Especialidade
              </button>
            </form>
          </div>
        </div>
 <!-- Botão de Salvar -->
        <div class="text-center mt-4">
          <button type="button" class="btn btn-rosa btn-lg px-5 py-3" onclick="salvarSobre()">
            <i class="fa fa-save mr-2"></i>Salvar Alterações
          </button>
        </div>

      </div>
    </div>
  </main>

    <?php include '../includes/footer.php'; ?>