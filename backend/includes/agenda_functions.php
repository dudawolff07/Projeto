<?php
include 'db.php';

/**
 * Verifica se um horário está disponível considerando a duração do procedimento
 */
function verificarHorarioDisponivel($conn, $data, $horario, $duracao_minutos = 30) {
    // Converter data para formato do banco
    $data_mysql = date('Y-m-d', strtotime($data));
    
    // Calcular horário final do procedimento
    $horario_final = calcularHorarioFinal($horario, $duracao_minutos);
    
    $stmt = $conn->prepare("SELECT a.agendamento_id 
                           FROM agendamento a
                           JOIN agendamento_procedimento ap ON a.agendamento_id = ap.agendamento_id
                           JOIN procedimento p ON ap.procedimento_id = p.procedimento_id
                           WHERE a.data_procedimento = ? 
                           AND a.status_procedimento != 'cancelado'
                           AND (
                               (a.horario_procedimento < ? AND 
                                DATE_ADD(a.horario_procedimento, INTERVAL p.tempo_procedimento MINUTE) > ?) OR
                               (a.horario_procedimento >= ? AND a.horario_procedimento < ?)
                           )");
    
    $stmt->bind_param("sssss", $data_mysql, $horario_final, $horario, $horario, $horario_final);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->num_rows === 0;
}

/**
 * Calcula o horário final baseado no horário inicial e duração
 */
function calcularHorarioFinal($horario_inicial, $duracao_minutos) {
    $timestamp = strtotime($horario_inicial);
    $timestamp += $duracao_minutos * 60;
    return date('H:i', $timestamp);
}

/**
 * Retorna horários disponíveis para uma data considerando a duração do procedimento
 */
function getHorariosDisponiveis($conn, $data, $duracao_necessaria = 30) {
    // Verificar se é fim de semana
    $dia_semana = date('w', strtotime($data));
    $is_sabado = ($dia_semana == 6);
    $is_domingo = ($dia_semana == 0);
    
    if ($is_domingo) {
        return []; // Domingo fechado
    }
    
    // Definir horários base
    $horarios_base = [];
    
    if ($is_sabado) {
        // Sábado: 9h às 17h
        for ($hora = 9; $hora <= 16; $hora++) {
            $horarios_base[] = sprintf("%02d:00", $hora);
            $horarios_base[] = sprintf("%02d:30", $hora);
        }
        $horarios_base[] = "17:00";
    } else {
        // Terça a Sexta: 9h às 19h
        for ($hora = 9; $hora <= 18; $hora++) {
            $horarios_base[] = sprintf("%02d:00", $hora);
            $horarios_base[] = sprintf("%02d:30", $hora);
        }
        $horarios_base[] = "19:00";
    }
    
    // Filtrar horários que cabem a duração necessária
    $horarios_disponiveis = [];
    foreach ($horarios_base as $horario) {
        if (horarioCabeNaJanela($horario, $duracao_necessaria, $is_sabado) && 
            verificarHorarioDisponivel($conn, $data, $horario, $duracao_necessaria)) {
            $horarios_disponiveis[] = $horario;
        }
    }
    
    return $horarios_disponiveis;
}

/**
 * Verifica se um horário cabe na janela de trabalho considerando a duração
 */
function horarioCabeNaJanela($horario, $duracao_minutos, $is_sabado) {
    $horario_final = calcularHorarioFinal($horario, $duracao_minutos);
    
    if ($is_sabado) {
        return $horario_final <= '17:30';
    } else {
        return $horario_final <= '19:30';
    }
}

/**
 * Retorna os procedimentos do catálogo para o select
 */
function getProcedimentosParaAgendamento($conn) {
    $result = $conn->query("SELECT procedimento_id, nome_procedimento, valor_procedimento, tempo_procedimento 
                           FROM procedimento 
                           ORDER BY nome_procedimento");
    $procedimentos = [];
    
    while ($row = $result->fetch_assoc()) {
        $procedimentos[] = $row;
    }
    
    return $procedimentos;
}

/**
 * Formata horários por período (Manhã/Tarde)
 */
function formatarHorariosPorPeriodo($horarios) {
    $periodos = [
        'manha' => [],
        'tarde' => []
    ];
    
    foreach ($horarios as $horario) {
        $hora = (int) substr($horario, 0, 2);
        if ($hora < 12) {
            $periodos['manha'][] = $horario;
        } else {
            $periodos['tarde'][] = $horario;
        }
    }
    
    return $periodos;
}
?>