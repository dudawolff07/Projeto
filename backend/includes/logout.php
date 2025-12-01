<?php
// includes/logout.php
session_start();

// Debug: Verificar se a sessão existe
error_log("Logout iniciado para usuário: " . ($_SESSION['usuario_nome'] ?? 'N/A'));

// Limpar TODAS as variáveis de sessão
$_SESSION = [];

// Destruir o cookie de sessão
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir a sessão
if (session_destroy()) {
    error_log("Sessão destruída com sucesso");
} else {
    error_log("Erro ao destruir sessão");
}

// Redirecionar IMEDIATAMENTE para a página inicial
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header("Location: ../Anonimo/index.php");
exit();
?>