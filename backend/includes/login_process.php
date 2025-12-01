<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    $stmt = $conn->prepare("SELECT usuario_id, nome_usuario, senha, tipo_id FROM usuario WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($senha, $user['senha'])) {
            // Login bem-sucedido
            $_SESSION['logged_in'] = true;
            $_SESSION['usuario_id'] = $user['usuario_id'];
            $_SESSION['usuario_nome'] = $user['nome_usuario'];
            $_SESSION['usuario_tipo'] = $user['tipo_id'];
            $_SESSION['usuario_email'] = $email;
            
            // CORREÇÃO: Caminhos relativos corretos a partir da pasta includes
            if ($user['tipo_id'] == 1) { // Admin
                header("Location: ../Admin/indexAdmin.php");
            } else { // Usuário comum
                header("Location: ../Cadastrado/indexCadastrado.php");
            }
            exit();
        }
    }
    
    $_SESSION['erro_login'] = "E-mail ou senha incorretos!";
    header("Location: ../Anonimo/index.php");  // CAMINHO CORRETO
    exit();
}
?>