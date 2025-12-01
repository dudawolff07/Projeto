<?php
session_start();

// Verificar se as funções já foram declaradas
if (!function_exists('redirectBasedOnUserType')) {
    function redirectBasedOnUserType() {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            switch ($_SESSION['usuario_tipo']) {
                case 1: // Admin
                    header("Location: ../Admin/indexAdmin.php");
                    break;
                case 2: // Cadastrado
                    header("Location: ../Cadastrado/indexCadastrado.php");
                    break;
                case 3: // Anônimo
                default:
                    header("Location: ../Anonimo/index.php");
                    break;
            }
            exit();
        }
    }
}

if (!function_exists('requireAuth')) {
    function requireAuth($allowed_types = []) {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
            $_SESSION['erro_login'] = "Faça login para acessar esta página";
            header("Location: ../Anonimo/index.php");
            exit();
        }
        
        if (!empty($allowed_types) && !in_array($_SESSION['usuario_tipo'], $allowed_types)) {
            header("Location: ../Anonimo/unauthorized.php");
            exit();
        }
    }
}
?>