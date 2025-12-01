<?php
include_once 'auth_redirect.php';
requireAuth([1]); // Somente admin
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Admin - Salão de Beleza</title>
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

  <!--owl slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- nice select  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
  <!-- font awesome style -->
  <link href="../css/font-awesome.min.css" rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="../css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="../css/responsive.css" rel="stylesheet" />
</head>
<body>

 <header class="header_section">
      <div class="container">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
          <a class="navbar-brand" href="indexAdmin.php">
            <span>Salão Admin</span>
          </a>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  mx-auto ">
              <li class="nav-item">
                <a class="nav-link" href="indexAdmin.php">Início</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="catalogoAdmin.php">Catálogo</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="agendaAdmin.php">Agenda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="sobreAdmin.php">Sobre</a>
              </li>
            </ul>
            <div class="user_option">
              <a href="#" class="user_link">
                <i class="fa fa-user"></i> <?php echo $_SESSION['usuario_nome']; ?>
              </a>
              <a href="../includes/logout.php" class="logout_link">Sair</a>
            </div>
          </div>
        </nav>
      </div>
    </header>