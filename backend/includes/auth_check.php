<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Armazenar a página que tentou acessar para redirecionar após login
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    
    // Mensagem 
    $_SESSION['erro_login'] = "Faça login para acessar esta página";
    
    header("Location: ../index.php");
    exit;
}

function getUserInfo($conn, $usuario_id) {
    // Mudei de PDO para MySQLi
    $stmt = $conn->prepare("SELECT nome_usuario, email_usuario FROM usuario WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return false;
}

function isAdmin() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 1;
}

function isUser() {
    return isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] == 2;
}

// Verificar se é o próprio usuário ou admin
function canEditUser($target_user_id) {
    if (isAdmin()) return true;
    return isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $target_user_id;
}
?>