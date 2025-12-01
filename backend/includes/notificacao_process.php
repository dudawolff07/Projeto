<?php
include 'db.php';
session_start();

header('Content-Type: application/json');

// Verificar se é admin
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != 1) {
    echo json_encode(['success' => false, 'message' => 'Acesso não autorizado']);
    exit();
}

if (isset($_GET['acao']) && isset($_GET['id'])) {
    $agendamento_id = $_GET['id'];
    $acao = $_GET['acao'];
    
    try {
        // Buscar informações do agendamento
        $stmt_info = $conn->prepare("SELECT u.email_usuario, u.nome_usuario, a.data_procedimento, a.horario_procedimento, p.nome_procedimento, a.status_procedimento 
                                   FROM agendamento a
                                   JOIN usuario u ON a.usuario_id = u.usuario_id
                                   JOIN agendamento_procedimento ap ON a.agendamento_id = ap.agendamento_id
                                   JOIN procedimento p ON ap.procedimento_id = p.procedimento_id
                                   WHERE a.agendamento_id = ?");
        $stmt_info->bind_param("i", $agendamento_id);
        $stmt_info->execute();
        $agendamento_info = $stmt_info->get_result()->fetch_assoc();
        
        if (!$agendamento_info) {
            echo json_encode(['success' => false, 'message' => 'Agendamento não encontrado']);
            exit();
        }
        
        // Enviar notificação baseada no status atual
        $tipo_notificacao = '';
        switch($agendamento_info['status_procedimento']) {
            case 'confirmado':
                $tipo_notificacao = 'lembrete';
                break;
            case 'pendente':
                $tipo_notificacao = 'pendente';
                break;
            default:
                $tipo_notificacao = 'status_atual';
        }
        
        // Função de envio de email (similar à do arquivo anterior)
        if (enviarNotificacao($agendamento_info['email_usuario'], $agendamento_info['nome_usuario'], $tipo_notificacao, $agendamento_info)) {
            echo json_encode(['success' => true, 'message' => 'Notificação enviada com sucesso!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao enviar notificação']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erro: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Parâmetros inválidos']);
}

function enviarNotificacao($email, $nome, $tipo, $dados_agendamento) {
    $data_br = date('d/m/Y', strtotime($dados_agendamento['data_procedimento']));
    $horario = date('H:i', strtotime($dados_agendamento['horario_procedimento']));
    
    switch ($tipo) {
        case 'lembrete':
            $assunto = '🔔 Lembrete de Agendamento - Juliana Wolff Hair';
            $mensagem = "
                Olá {$nome}!
                
                Este é um lembrete do seu agendamento:
                
                📅 Data: {$data_br}
                ⏰ Horário: {$horario}
                💇 Serviço: {$dados_agendamento['nome_procedimento']}
                
                Esperamos por você!
                
                Atenciosamente,
                Juliana Wolff Hair
            ";
            break;
            
        default:
            $assunto = '📋 Status do Agendamento - Juliana Wolff Hair';
            $mensagem = "
                Olá {$nome}!
                
                Status atual do seu agendamento:
                
                📅 Data: {$data_br}
                ⏰ Horário: {$horario}
                💇 Serviço: {$dados_agendamento['nome_procedimento']}
                📊 Status: " . ucfirst($dados_agendamento['status_procedimento']) . "
                
                Atenciosamente,
                Juliana Wolff Hair
            ";
    }
    
    $headers = "From: nao-responder@julianawolffhair.com\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    
    return @mail($email, $assunto, $mensagem, $headers);
}
?>