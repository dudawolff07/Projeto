<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

$response = ['success' => false];

if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    
    $stmt = $conn->prepare("SELECT nome_usuario, telefone_usuario, email_usuario FROM usuario WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $response = [
            'success' => true,
            'nome' => $user['nome_usuario'],
            'telefone' => $user['telefone_usuario'],
            'email' => $user['email_usuario']
        ];
    }
}

echo json_encode($response);
?>