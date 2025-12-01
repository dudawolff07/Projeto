<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $telefone = trim($_POST["telefone"]);
    
    try {
        // Verificar se email já existe (excluindo o próprio usuário)
        $stmt = $conn->prepare("SELECT usuario_id FROM usuario WHERE email_usuario = ? AND usuario_id != ?");
        $stmt->bind_param("si", $email, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $_SESSION['erro_perfil'] = "Este e-mail já está em uso por outro usuário!";
            header("Location: ../Cadastrado/indexCadastrado.php");
            exit();
        }
        
        // Atualizar dados do usuário (sem foto)
        $stmt = $conn->prepare("UPDATE usuario SET nome_usuario = ?, email_usuario = ?, telefone_usuario = ? WHERE usuario_id = ?");
        $stmt->bind_param("sssi", $nome, $email, $telefone, $usuario_id);
        
        if ($stmt->execute()) {
            // Atualizar dados na sessão
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_email'] = $email;
            $_SESSION['msg_perfil'] = "Perfil atualizado com sucesso!";
        } else {
            $_SESSION['erro_perfil'] = "Erro ao atualizar perfil. Tente novamente.";
        }
        
    } catch (Exception $e) {
        $_SESSION['erro_perfil'] = "Erro no sistema. Tente novamente.";
    }
    
    header("Location: ../Cadastrado/indexCadastrado.php");
    exit();
}
?>