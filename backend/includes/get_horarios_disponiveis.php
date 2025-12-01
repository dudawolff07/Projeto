<?php
include 'db.php';
include 'agenda_functions.php';

header('Content-Type: application/json');

if (isset($_GET['data'])) {
    $data = $_GET['data'];
    $duracao = isset($_GET['duracao']) ? intval($_GET['duracao']) : 30;
    
    // Validar data
    if (empty($data)) {
        echo json_encode(['success' => false, 'message' => 'Data não fornecida']);
        exit;
    }
    
    // Verificar se a data é no passado
    if (strtotime($data) < strtotime(date('Y-m-d'))) {
        echo json_encode(['success' => false, 'message' => 'Não é possível agendar para datas passadas']);
        exit;
    }
    
    // Validar duração
    if ($duracao < 15 || $duracao > 480) {
        echo json_encode(['success' => false, 'message' => 'Duração inválida']);
        exit;
    }
    
    $horarios_disponiveis = getHorariosDisponiveis($conn, $data, $duracao);
    
    echo json_encode([
        'success' => true,
        'data' => $data,
        'duracao' => $duracao,
        'horarios' => $horarios_disponiveis,
        'total' => count($horarios_disponiveis)
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetro data não fornecido']);
}
?>