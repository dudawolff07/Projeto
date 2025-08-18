<?php
session_start(); // Inicia a sessão para verificar login
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
                <a href="auth/logout.php" class="logout_link">Sair</a>
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
        <div class="login-tabs">
          <div class="login-tab active" onclick="mostrarFormulario('login')">Login</div>
          <div class="login-tab" onclick="mostrarFormulario('cadastro')">Cadastro</div>
        </div>

        <form id="formLogin" class="login-form active" action="auth/login.php" method="POST">
          <input type="email" name="email" placeholder="E-mail" required>
          <input type="password" name="senha" placeholder="Senha" required>
          <button type="submit">Entrar</button>
          <div class="forgot-password">
            <a href="#" id="forgotPasswordLink">Esqueceu a senha?</a>
          </div>
        </form>

        <form id="formCadastro" class="login-form" action="auth/register.php" method="POST">
          <input type="text" name="nome_completo" placeholder="Nome completo" required>
          <input type="email" name="email" placeholder="E-mail" required>
          <input type="tel" name="telefone" placeholder="Telefone (WhatsApp)" required>
          <input type="password" name="senha" placeholder="Senha" required>
          <input type="password" name="confirmar_senha" placeholder="Confirmar senha" required>
          <button type="submit">Cadastrar</button>
        </form>
      </div>
    </div>

    <!-- Scripts do Modal -->
    <script>
      // Funções para controlar o modal
      function abrirLoginModal() {
        document.getElementById('loginModal').style.display = 'block';
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

      // Event listener para o link de login
      document.getElementById('abrirLoginModal')?.addEventListener('click', function(e) {
        e.preventDefault();
        abrirLoginModal();
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
    </script>