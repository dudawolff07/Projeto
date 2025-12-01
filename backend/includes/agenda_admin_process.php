<?php
include 'db.php';
session_start();

// Verificar se é admin
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] != 1) {
    header("Location: ../Anonimo/index.php");
    exit();
}

if (isset($_GET['acao']) && isset($_GET['id'])) {
    $agendamento_id = $_GET['id'];
    $acao = $_GET['acao'];
    $motivo = $_GET['motivo'] ?? '';
    
    try {
        // Buscar informações do agendamento para notificação
        $stmt_info = $conn->prepare("SELECT u.email_usuario, u.nome_usuario, a.data_procedimento, a.horario_procedimento, p.nome_procedimento 
                                   FROM agendamento a
                                   JOIN usuario u ON a.usuario_id = u.usuario_id
                                   JOIN agendamento_procedimento ap ON a.agendamento_id = ap.agendamento_id
                                   JOIN procedimento p ON ap.procedimento_id = p.procedimento_id
                                   WHERE a.agendamento_id = ?");
        $stmt_info->bind_param("i", $agendamento_id);
        $stmt_info->execute();
        $agendamento_info = $stmt_info->get_result()->fetch_assoc();
        
        switch ($acao) {
            case 'confirmar':
                $stmt = $conn->prepare("UPDATE agendamento SET status_procedimento = 'confirmado' WHERE agendamento_id = ?");
                $stmt->bind_param("i", $agendamento_id);
                $_SESSION['msg_agenda'] = "Agendamento confirmado com sucesso!";
                
                // Enviar email de confirmação
                enviarNotificacao($agendamento_info['email_usuario'], $agendamento_info['nome_usuario'], 'confirmacao', $agendamento_info);
                break;
                
            case 'concluir':
                $stmt = $conn->prepare("UPDATE agendamento SET status_procedimento = 'concluido' WHERE agendamento_id = ?");
                $stmt->bind_param("i", $agendamento_id);
                $_SESSION['msg_agenda'] = "Agendamento marcado como concluído!";
                break;
                
            case 'cancelar':
                $stmt = $conn->prepare("UPDATE agendamento SET status_procedimento = 'cancelado', cancelado_por = ?, motivo_cancelamento = ? WHERE agendamento_id = ?");
                $stmt->bind_param("isi", $_SESSION['usuario_id'], $motivo, $agendamento_id);
                $_SESSION['msg_agenda'] = "Agendamento cancelado com sucesso!";
                
                // Enviar email de cancelamento
                enviarNotificacao($agendamento_info['email_usuario'], $agendamento_info['nome_usuario'], 'cancelamento', $agendamento_info, $motivo);
                break;
        }
        
        if ($stmt->execute()) {
            // Registrar a ação no histórico
            registrarHistorico($conn, $agendamento_id, $acao, $_SESSION['usuario_id'], $motivo);
            header("Location: ../Admin/agendaAdmin.php");
        } else {
            $_SESSION['msg_agenda'] = "Erro ao processar agendamento.";
            header("Location: ../Admin/agendaAdmin.php");
        }
        
    } catch (Exception $e) {
        $_SESSION['msg_agenda'] = "Erro no sistema: " . $e->getMessage();
        header("Location: ../Admin/agendaAdmin.php");
    }
    exit();
}

/**
 * Função para enviar notificações por email
 */
function enviarNotificacao($email, $nome, $tipo, $dados_agendamento, $motivo = '') {
    $assunto = '';
    $mensagem = '';
    
    $data_br = date('d/m/Y', strtotime($dados_agendamento['data_procedimento']));
    $horario = date('H:i', strtotime($dados_agendamento['horario_procedimento']));
    
    switch ($tipo) {
        case 'confirmacao':
            $assunto = '✅ Agendamento Confirmado - Juliana Wolff Hair';
            $mensagem = "
                Olá {$nome}!
                
                Seu agendamento foi confirmado com sucesso!
                
                📅 Data: {$data_br}
                ⏰ Horário: {$horario}
                💇 Serviço: {$dados_agendamento['nome_procedimento']}
                
                Estamos ansiosos para te atender!
                
                Atenciosamente,
                Juliana Wolff Hair
            ";
            break;
            
        case 'cancelamento':
            $assunto = '❌ Agendamento Cancelado - Juliana Wolff Hair';
            $mensagem = "
                Olá {$nome}!
                
                Seu agendamento foi cancelado.
                
                📅 Data: {$data_br}
                ⏰ Horário: {$horario}
                💇 Serviço: {$dados_agendamento['nome_procedimento']}
                
                Motivo: {$motivo}
                
                Para reagendar, acesse nosso site ou entre em contato.
                
                Atenciosamente,
                Juliana Wolff Hair
            ";
            break;
    }
    
    // Enviar email (implementação básica - você pode usar PHPMailer ou similar)
    $headers = "From: nao-responder@julianawolffhair.com\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    
    @mail($email, $assunto, $mensagem, $headers);
    
    // Também registrar no banco para histórico
    return true;
}

/**
 * Registrar histórico de ações
 */
function registrarHistorico($conn, $agendamento_id, $acao, $usuario_id, $motivo = '') {
    $stmt = $conn->prepare("INSERT INTO historico_agendamentos (agendamento_id, acao, usuario_id, motivo, data_acao) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("isis", $agendamento_id, $acao, $usuario_id, $motivo);
    $stmt->execute();
}
?>