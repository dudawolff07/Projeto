<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html>

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
  
  <!-- Boxicons CSS -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- custom styles -->
  <link href="../css/style.css" rel="stylesheet" />
  <link href="../css/responsive.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
  
  <style>
    /* Estilos para os modais de perfil */
    .perfil-modal-content {
      border-radius: 15px;
      box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    }
    
    .perfil-close-btn {
      font-size: 1.5rem;
      color: #999;
    }
    
    .perfil-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #f783ac;
    }
    
    .btn-rosa {
      background-color: #f783ac;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      transition: all 0.3s;
    }
    
    .btn-rosa:hover {
      background-color: #e6729a;
      color: white;
    }

    .btn-outline-rosa {
      border: 1px solid #f783ac;
      color: #f783ac;
      background: white;
      padding: 8px 15px;
      border-radius: 6px;
      transition: all 0.3s;
    }

    .btn-outline-rosa:hover {
      background-color: #f783ac;
      color: white;
    }
    
    /* Estilo para o avatar do usuário */
    .user-avatar {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #f783ac;
      transition: all 0.3s ease;
    }
    
    .user-avatar:hover {
      border-color: #e6729a;
      transform: scale(1.05);
    }

    /* Estilos para o formulário de edição */
    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      font-weight: 500;
      color: #333;
      margin-bottom: 0.5rem;
      display: block;
    }

    .form-control {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 10px 15px;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: #f783ac;
      box-shadow: 0 0 0 0.2rem rgba(247, 131, 172, 0.25);
    }

    /* Alertas personalizados */
    .alert-perfil {
      border-radius: 8px;
      border: none;
      padding: 12px 15px;
      margin-bottom: 15px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section -->
    <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="indexCadastrado.php">
            <span>Salão de Beleza</span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" 
                  data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                  aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item"><a class="nav-link" href="indexCadastrado.php">Início</a></li>
              <li class="nav-item"><a class="nav-link" href="catalogoCadastrado.php">Catálogo</a></li>
              <li class="nav-item"><a class="nav-link" href="agendaCadastrado.php">Agendar</a></li>
              <li class="nav-item"><a class="nav-link" href="sobreCadastrado.php">Sobre</a></li>
            </ul>
            <div class="user_option">
              <a href="#" id="abrirPerfilModal" class="user_link">
                <!-- Avatar SEMPRE com foto padrão -->
                <img src="../images/avatar-default.png" alt="Perfil" class="user-avatar">
              </a>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
    
    <!-- Modal de Perfil -->
    <div class="modal fade" id="perfilModal" tabindex="-1" role="dialog" aria-labelledby="perfilModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content perfil-modal-content">

          <div class="modal-header border-0">
            <h5 class="modal-title" id="perfilModalLabel">Meu Perfil</h5>
            <button type="button" class="close perfil-close-btn" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body text-center">
            <!-- Mensagens de feedback -->
            <?php if (isset($_SESSION['msg_perfil'])): ?>
              <div class="alert alert-success alert-perfil alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['msg_perfil']; unset($_SESSION['msg_perfil']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['erro_perfil'])): ?>
              <div class="alert alert-danger alert-perfil alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['erro_perfil']; unset($_SESSION['erro_perfil']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif; ?>

            <!-- Foto SEMPRE padrão -->
            <img src="../images/avatar-default.png" alt="Foto do perfil" class="perfil-img mb-3">
            
            <?php
            // Buscar dados do usuário logado
            $nome_usuario = 'Usuário';
            $email_usuario = 'email@exemplo.com';
            $telefone_usuario = '';

            if (isset($_SESSION['usuario_id'])) {
                $stmt = $conn->prepare("SELECT nome_usuario, email_usuario, telefone_usuario FROM usuario WHERE usuario_id = ?");
                $stmt->bind_param("i", $_SESSION['usuario_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows === 1) {
                    $user = $result->fetch_assoc();
                    $nome_usuario = $user['nome_usuario'];
                    $email_usuario = $user['email_usuario'];
                    $telefone_usuario = $user['telefone_usuario'];
                }
            }
            ?>
            
            <h4><?php echo htmlspecialchars($nome_usuario); ?></h4>
            <p class="text-muted mb-2"><?php echo htmlspecialchars($email_usuario); ?></p>
            <?php if (!empty($telefone_usuario)): ?>
              <p class="text-muted mb-3"><?php echo htmlspecialchars($telefone_usuario); ?></p>
            <?php endif; ?>
            
            <div class="d-flex justify-content-center gap-2 mb-3">
              <button class="btn btn-outline-rosa" data-toggle="modal" data-target="#editarPerfilModal" data-dismiss="modal">
                <i class="fa fa-edit"></i> Editar Perfil
              </button>
              <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#alterarSenhaModal" data-dismiss="modal">
                <i class="fa fa-lock"></i> Alterar Senha
              </button>
            </div>
            
            <hr>
            <a href="../includes/logout.php" class="btn btn-rosa">
              <i class="fa fa-sign-out"></i> Sair da Conta
            </a>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal de Edição de Perfil -->
    <div class="modal fade" id="editarPerfilModal" tabindex="-1" role="dialog" aria-labelledby="editarPerfilModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content perfil-modal-content">

          <div class="modal-header border-0">
            <h5 class="modal-title" id="editarPerfilModalLabel">Editar Perfil</h5>
            <button type="button" class="close perfil-close-btn" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form id="formEditarPerfil" action="../includes/update_profile.php" method="POST">
              <div class="form-group text-center">
                <img src="../images/avatar-default.png" alt="Foto do perfil" class="perfil-img mb-3">
                <small class="form-text text-muted d-block">Foto padrão do sistema</small>
              </div>

              <div class="form-group">
                <label for="editarNome">Nome Completo</label>
                <input type="text" class="form-control" id="editarNome" name="nome" value="<?php echo htmlspecialchars($nome_usuario); ?>" required>
              </div>

              <div class="form-group">
                <label for="editarEmail">E-mail</label>
                <input type="email" class="form-control" id="editarEmail" name="email" value="<?php echo htmlspecialchars($email_usuario); ?>" required>
              </div>

              <div class="form-group">
                <label for="editarTelefone">Telefone/WhatsApp</label>
                <input type="text" class="form-control" id="editarTelefone" name="telefone" value="<?php echo htmlspecialchars($telefone_usuario); ?>" placeholder="(11) 99999-9999">
              </div>
              
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary flex-fill" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-rosa flex-fill">Salvar Alterações</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>

    <!-- Modal de Alteração de Senha -->
    <div class="modal fade" id="alterarSenhaModal" tabindex="-1" role="dialog" aria-labelledby="alterarSenhaModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content perfil-modal-content">

          <div class="modal-header border-0">
            <h5 class="modal-title" id="alterarSenhaModalLabel">Alterar Senha</h5>
            <button type="button" class="close perfil-close-btn" data-dismiss="modal" aria-label="Fechar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form id="formAlterarSenha" action="../includes/update_password.php" method="POST">
              <div class="form-group">
                <label for="senha_atual">Senha Atual</label>
                <input type="password" class="form-control" id="senha_atual" name="senha_atual" required>
              </div>

              <div class="form-group">
                <label for="nova_senha">Nova Senha</label>
                <input type="password" class="form-control" id="nova_senha" name="nova_senha" required minlength="6">
                <small class="form-text text-muted">Mínimo 6 caracteres</small>
              </div>

              <div class="form-group">
                <label for="confirmar_senha">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
              </div>
              
              <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-secondary flex-fill" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-rosa flex-fill">Alterar Senha</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
    
    <script>
    // Script para abrir o modal de perfil
    document.addEventListener('DOMContentLoaded', function() {
      // Abrir modal de perfil
      document.getElementById('abrirPerfilModal').addEventListener('click', function(e) {
        e.preventDefault();
        $('#perfilModal').modal('show');
      });

      // Validação de confirmação de senha
      document.getElementById('formAlterarSenha')?.addEventListener('submit', function(e) {
        const novaSenha = document.getElementById('nova_senha').value;
        const confirmarSenha = document.getElementById('confirmar_senha').value;
        
        if (novaSenha !== confirmarSenha) {
          e.preventDefault();
          alert('As senhas não coincidem!');
        }
      });

      // Fechar modais com ESC
      document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
          $('.modal').modal('hide');
        }
      });
    });
    </script>
</body>
</html>