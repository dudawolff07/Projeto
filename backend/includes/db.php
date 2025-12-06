<?php
// db.php - VERSÃO SIMPLIFICADA (apenas conexão)
$host = "localhost";
$db   = "projeto";
$user = "root";
$pass = "";    

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Configurações da conexão
$conn->set_charset("utf8mb4");
?>