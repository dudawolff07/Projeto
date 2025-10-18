<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $senha_atual = trim($_POST["senha_atual"]);
    $nova_senha = trim($_POST["nova_senha"]);
    
    try {
        // Buscar senha atual do usuário
        $stmt = $conn->prepare("SELECT senha FROM usuario WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verificar senha atual
            if (password_verify($senha_atual, $user['senha'])) {
                // Senha atual correta, atualizar para nova senha
                $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                
                $stmt = $conn->prepare("UPDATE usuario SET senha = ? WHERE usuario_id = ?");
                $stmt->bind_param("si", $nova_senha_hash, $usuario_id);
                
                if ($stmt->execute()) {
                    $_SESSION['msg_perfil'] = "Senha alterada com sucesso!";
                } else {
                    $_SESSION['erro_perfil'] = "Erro ao alterar senha. Tente novamente.";
                }
            } else {
                $_SESSION['erro_perfil'] = "Senha atual incorreta!";
            }
        }
        
    } catch (Exception $e) {
        $_SESSION['erro_perfil'] = "Erro no sistema. Tente novamente.";
    }
    
    header("Location: ../Cadastrado/indexCadastrado.php");
    exit();
}
?>