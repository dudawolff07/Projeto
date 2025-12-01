<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $telefone = trim($_POST["telefone"]);
    $senha = trim($_POST["senha"]);
    $confirmar_senha = trim($_POST["confirmar_senha"]);

    // Validações básicas
    if ($senha !== $confirmar_senha) {
        $_SESSION['erro_cadastro'] = "As senhas não coincidem!";
        header("Location: ../Anonimo/index.php");
        exit();
    }

    if (strlen($senha) < 6) {
        $_SESSION['erro_cadastro'] = "A senha deve ter pelo menos 6 caracteres!";
        header("Location: ../Anonimo/index.php");
        exit();
    }

    // Verificar se email já existe
    $stmt = $conn->prepare("SELECT usuario_id FROM usuario WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['erro_cadastro'] = "Este e-mail já está cadastrado!";
        header("Location: ../Anonimo/index.php");
        exit();
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
    // Inserir novo usuário (sem foto)
    $stmt = $conn->prepare("INSERT INTO usuario (nome_usuario, telefone_usuario, email_usuario, senha, tipo_id) VALUES (?, ?, ?, ?, 2)");
    $stmt->bind_param("ssss", $nome, $telefone, $email, $senha_hash);
    
    if ($stmt->execute()) {
        $_SESSION['msg'] = "Cadastro realizado com sucesso! Faça login para continuar.";
        header("Location: ../Anonimo/index.php");
        exit();
    } else {
        $_SESSION['erro_cadastro'] = "Erro ao cadastrar. Tente novamente.";
        header("Location: ../Anonimo/index.php");
        exit();
    }
}
?>