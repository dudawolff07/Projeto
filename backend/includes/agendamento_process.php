<?php
include 'db.php';
session_start();

// Usar o sistema de autenticação que você já tem
include 'auth_redirect.php';
requireAuth([2]); // Somente usuários cadastrados (tipo 2)

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $data_procedimento = $_POST["appointmentDate"];
    $horario_procedimento = $_POST["appointmentTime"];
    $procedimento_id = $_POST["serviceType"];
    $forma_pagamento = $_POST["paymentMethod"];
    $observacoes = trim($_POST["clientNotes"] ?? '');
    
    // Validações
    if (empty($data_procedimento) || empty($horario_procedimento) || empty($procedimento_id)) {
        $_SESSION['erro_agendamento'] = "Preencha todos os campos obrigatórios.";
        header("Location: ../Cadastrado/agendaCadastrado.php");
        exit();
    }
    
    try {
        // Buscar duração do procedimento
        $stmt_duracao = $conn->prepare("SELECT tempo_procedimento FROM procedimento WHERE procedimento_id = ?");
        $stmt_duracao->bind_param("i", $procedimento_id);
        $stmt_duracao->execute();
        $result_duracao = $stmt_duracao->get_result();
        
        if ($result_duracao->num_rows === 0) {
            $_SESSION['erro_agendamento'] = "Procedimento não encontrado.";
            header("Location: ../Cadastrado/agendaCadastrado.php");
            exit();
        }
        
        $procedimento = $result_duracao->fetch_assoc();
        $duracao = $procedimento['tempo_procedimento'];

        // Verificar disponibilidade considerando a duração REAL
        include 'agenda_functions.php';
        if (!verificarHorarioDisponivel($conn, $data_procedimento, $horario_procedimento, $duracao)) {
            $_SESSION['erro_agendamento'] = "Horário indisponível para este serviço de {$duracao} minutos. Por favor, escolha outro horário.";
        } else {
            // Inserir agendamento com todos os campos
            $stmt = $conn->prepare("INSERT INTO agendamento (usuario_id, data_procedimento, horario_procedimento, status_procedimento, forma_pagamento, observacoes) VALUES (?, ?, ?, 'pendente', ?, ?)");
            $stmt->bind_param("issss", $usuario_id, $data_procedimento, $horario_procedimento, $forma_pagamento, $observacoes);
            
            if ($stmt->execute()) {
                $agendamento_id = $stmt->insert_id;
                
                // Inserir relação agendamento_procedimento
                $stmt2 = $conn->prepare("INSERT INTO agendamento_procedimento (agendamento_id, procedimento_id) VALUES (?, ?)");
                $stmt2->bind_param("ii", $agendamento_id, $procedimento_id);
                $stmt2->execute();
                
                $_SESSION['msg_agendamento'] = "✅ Agendamento realizado com sucesso! Entraremos em contato para confirmação.";
            } else {
                $_SESSION['erro_agendamento'] = "❌ Erro ao realizar agendamento. Tente novamente.";
            }
        }
        
    } catch (Exception $e) {
        $_SESSION['erro_agendamento'] = "❌ Erro no sistema. Tente novamente.";
    }
    
    header("Location: ../Cadastrado/agendaCadastrado.php");
    exit();
}
?>