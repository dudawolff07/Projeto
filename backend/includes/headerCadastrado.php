<?php
// Cabeçalho e menu
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
    
    /* Estilo para o novo ícone de perfil */
    .user-profile-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background-color: #f783ac;
      color: white;
      border-radius: 50%;
      transition: all 0.3s ease;
      font-size: 18px;
    }
    
    .user-profile-icon:hover {
      background-color: #e6729a;
      transform: scale(1.05);
    }
    
    /* Alternativa com imagem de avatar */
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #f783ac;
      transition: all 0.3s ease;
    }
    
    .user-avatar:hover {
      border-color: #e6729a;
      transform: scale(1.05);
    }
  </style>
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
              <li class="nav-item"><a class="nav-link" href="indexCadastrado.php">Início</a></li>
              <li class="nav-item"><a class="nav-link" href="catalogoCadastrado.php">Catálogo</a></li>
              <li class="nav-item"><a class="nav-link" href="agendaCadastrado.php">Agendar</a></li>
              <li class="nav-item"><a class="nav-link" href="sobreCadastrado.php">Sobre</a></li>
            </ul>
            <div class="user_option">
              <a href="#" id="abrirPerfilModal" class="user_link">
                <!-- Escolha uma das opções abaixo (remova o comentário da que preferir) -->
                
                <!-- Opção 1: Ícone moderno com Boxicons -->
                <div class="user-profile-icon">
                  <i class='bx bx-user'></i>
                </div>
                
                <!-- Opção 2: Ícone com círculo (descomente para usar) -->
                <!--
                <div class="user-profile-icon">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </div>
                -->
                
                <!-- Opção 3: Avatar com imagem (descomente para usar) -->
                <!--
                <img src="../images/cabeleireira.png" alt="Perfil" class="user-avatar">
                -->
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
            <img src="../images/cabeleireira.png" alt="Foto do perfil" class="perfil-img mb-3">
            <h4>Juliana Wolff</h4>
            <p class="text-muted mb-2">juliana@email.com</p>
            <button class="btn btn-outline-secondary btn-sm mb-3" data-toggle="modal" data-target="#editarPerfilModal" data-dismiss="modal">Editar Perfil</button>
            <hr>
            <a href="../index.html" class="btn btn-rosa">Sair da Conta</a>
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
            <form id="formEditarPerfil">
              <div class="form-group">
                <label for="editarNome">Nome</label>
                <input type="text" class="form-control" id="editarNome" value="Juliana Wolff" required>
              </div>

              <div class="form-group">
                <label for="editarEmail">Email</label>
                <input type="email" class="form-control" id="editarEmail" value="juliana@email.com" required>
              </div>

              <div class="form-group">
                <label for="editarTelefone">Telefone</label>
                <input type="text" class="form-control" id="editarTelefone" value="(51) 98765-4321">
              </div>
              <button type="submit" class="btn btn-rosa btn-block">Salvar Alterações</button>
            </form>
          </div>

        </div>
      </div>
    </div>
    
    <script>
    // Script para abrir o modal de perfil
    document.addEventListener('DOMContentLoaded', function() {
      // Alterar o ID do link para abrir o modal de perfil
      document.getElementById('abrirPerfilModal').addEventListener('click', function(e) {
        e.preventDefault();
        $('#perfilModal').modal('show');
      });
      
      // Script para o formulário de edição de perfil
      document.getElementById('formEditarPerfil').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Perfil atualizado com sucesso!');
        $('#editarPerfilModal').modal('hide');
      });
    });
    </script>