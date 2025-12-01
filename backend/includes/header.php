<?php
// Verificar se a sessão já foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="shortcut icon" href="images/favicon.png" type="">
  <title>Salão de Beleza</title>

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!-- owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" />
  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- custom styles -->
  <link href="../css/style.css" rel="stylesheet" />
  <link href="../css/responsive.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

</head>

<body>
  <div class="hero_area">
    <!-- header section -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="index.php">
            <span>Salão de Beleza</span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" 
                  data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                  aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
              <li class="nav-item"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
              <li class="nav-item"><a class="nav-link" href="agenda.php">Agendar</a></li>
              <li class="nav-item"><a class="nav-link" href="sobre.php">Sobre</a></li>
            </ul>
            <div class="user_option">
              <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                <a href="perfil.php" class="user_link">
                  <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>
                </a>
                <a href="../includes/logout.php" class="logout_link">Sair</a>
              <?php else: ?>
                <a href="#" id="abrirLoginModal" class="user_link">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->

    <!-- Modal de Login -->
    <div id="loginModal" class="login-modal">
      <div class="login-content">
        <span class="close-modal" onclick="fecharLoginModal()">&times;</span>
        
        <!-- Mensagens de feedback -->
        <?php if (isset($_SESSION['erro_login'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['erro_login']; unset($_SESSION['erro_login']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['erro_cadastro'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['erro_cadastro']; unset($_SESSION['erro_cadastro']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['msg'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>

        <div class="login-tabs">
          <div class="login-tab active" onclick="mostrarFormulario('login')">Login</div>
          <div class="login-tab" onclick="mostrarFormulario('cadastro')">Cadastro</div>
        </div>

        <form id="formLogin" class="login-form active" action="../includes/login_process.php" method="POST">
          <input type="email" name="email" placeholder="E-mail" required>
          <input type="password" name="senha" placeholder="Senha" required>
          <button type="submit">Entrar</button>
        </form>

        <form id="formCadastro" class="login-form" action="../includes/register_process.php" method="POST" enctype="multipart/form-data">
          <input type="text" name="nome" placeholder="Nome completo" required>
          <input type="email" name="email" placeholder="E-mail" required>
          <input type="tel" name="telefone" placeholder="Telefone (WhatsApp)" required>
          
          <!-- Campo de foto de perfil (opcional) -->
          
          <input type="password" name="senha" placeholder="Senha" required>
          <input type="password" name="confirmar_senha" placeholder="Confirmar senha" required>
          <button type="submit">Cadastrar</button>
        </form>
      </div>
    </div>

    <style>
      .form-group-foto {
        margin-bottom: 15px;
        text-align: center;
      }

      .foto-label {
        display: inline-block;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        color: #6c757d;
        width: 100%;
      }

      .foto-label:hover {
        background-color: #e9ecef;
        border-color: #f783ac;
      }

      .foto-label i {
        margin-right: 5px;
      }

      #preview-container {
        text-align: center;
        margin-top: 10px;
      }
    </style>

    <!-- Scripts do Modal -->
    <script>
      // Funções para controlar o modal
      function abrirLoginModal() {
        document.getElementById('loginModal').style.display = 'block';
        // Limpar mensagens ao abrir o modal
        setTimeout(() => {
          const alerts = document.querySelectorAll('.alert');
          alerts.forEach(alert => {
            alert.style.display = 'none';
          });
        }, 5000);
      }

      function fecharLoginModal() {
        document.getElementById('loginModal').style.display = 'none';
      }

      function mostrarFormulario(tipo) {
        const loginForm = document.getElementById('formLogin');
        const cadastroForm = document.getElementById('formCadastro');
        const tabs = document.querySelectorAll('.login-tab');
        
        if (tipo === 'login') {
          loginForm.classList.add('active');
          cadastroForm.classList.remove('active');
          tabs[0].classList.add('active');
          tabs[1].classList.remove('active');
        } else {
          loginForm.classList.remove('active');
          cadastroForm.classList.add('active');
          tabs[0].classList.remove('active');
          tabs[1].classList.add('active');
        }
      }

      // Função para fazer preview da foto selecionada
      function previewFoto(input) {
        const previewContainer = document.getElementById('preview-container');
        const preview = document.getElementById('preview-foto');
        
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          
          reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
          }
          
          reader.readAsDataURL(input.files[0]);
        }
      }

      // Função para remover a foto selecionada
      function removerFoto() {
        const input = document.getElementById('foto_perfil');
        const previewContainer = document.getElementById('preview-container');
        
        input.value = '';
        previewContainer.style.display = 'none';
      }

      // Event listener para o link de login
      document.getElementById('abrirLoginModal')?.addEventListener('click', function(e) {
        e.preventDefault();
        abrirLoginModal();
      });

      // Event listener para o label da foto
      document.querySelector('.foto-label')?.addEventListener('click', function() {
        document.getElementById('foto_perfil').click();
      });

      // Fechar modal ao clicar fora
      window.addEventListener('click', function(event) {
        const modal = document.getElementById('loginModal');
        if (event.target === modal) {
          fecharLoginModal();
        }
      });

      // Fechar modal com ESC
      document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
          fecharLoginModal();
        }
      });

      // Validação de confirmação de senha
      document.querySelector('#formCadastro')?.addEventListener('submit', function(e) {
        const senha = this.querySelector('input[name="senha"]').value;
        const confirmarSenha = this.querySelector('input[name="confirmar_senha"]').value;
        
        if (senha !== confirmarSenha) {
          e.preventDefault();
          alert('As senhas não coincidem!');
        }
        
        // Validar tamanho do arquivo se existir
        const fotoInput = document.getElementById('foto_perfil');
        if (fotoInput.files[0] && fotoInput.files[0].size > 2 * 1024 * 1024) {
          e.preventDefault();
          alert('A imagem deve ter no máximo 2MB.');
        }
      });
    </script>