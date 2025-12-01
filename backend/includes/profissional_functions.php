<?php
// Funções para gerenciar informações do profissional

function getInformacoesProfissional($conn, $tipo = null) {
    $sql = "SELECT * FROM profissional_info WHERE ativo = TRUE";
    
    if ($tipo) {
        $sql .= " AND tipo = ?";
    }
    
    $sql .= " ORDER BY ordem ASC, created_at ASC";
    
    $stmt = $conn->prepare($sql);
    
    if ($tipo) {
        $stmt->bind_param("s", $tipo);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $informacoes = [];
    while ($row = $result->fetch_assoc()) {
        $informacoes[] = $row;
    }
    
    return $informacoes;
}

function adicionarInformacaoProfissional($conn, $tipo, $titulo, $descricao = null, $ordem = 0) {
    $sql = "INSERT INTO profissional_info (tipo, titulo, descricao, ordem) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $tipo, $titulo, $descricao, $ordem);
    return $stmt->execute();
}

function atualizarInformacaoProfissional($conn, $id, $titulo, $descricao = null, $ordem = 0) {
    $sql = "UPDATE profissional_info SET titulo = ?, descricao = ?, ordem = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $titulo, $descricao, $ordem, $id);
    return $stmt->execute();
}

function excluirInformacaoProfissional($conn, $id) {
    $sql = "UPDATE profissional_info SET ativo = FALSE WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function exibirFormacoes($conn) {
    $formacoes = getInformacoesProfissional($conn, 'formacao');
    
    if (empty($formacoes)) {
        echo '<li>Graduação em Estética e Cosmética</li>';
        echo '<li>Pós-graduação em Tricologia Capilar</li>';
        echo '<li>Certificação Internacional em Colorimetria</li>';
        return;
    }
    
    foreach ($formacoes as $formacao) {
        echo '<li><i class="fa fa-check text-pink mr-2"></i>' . htmlspecialchars($formacao['titulo']) . '</li>';
    }
}

function exibirEspecialidades($conn) {
    $especialidades = getInformacoesProfissional($conn, 'especialidade');
    
    if (empty($especialidades)) {
        echo '<span class="specialty-badge">Cabelos Danificados</span>';
        echo '<span class="specialty-badge">Coloração Vegana</span>';
        echo '<span class="specialty-badge">Cortes Personalizados</span>';
        return;
    }
    
    foreach ($especialidades as $especialidade) {
        echo '<span class="specialty-badge">' . htmlspecialchars($especialidade['titulo']) . '</span>';
    }
}

function exibirSobre($conn) {
    $sobre = getInformacoesProfissional($conn, 'sobre');
    
    if (empty($sobre)) {
        return 'Com mais de 12 anos de experiência no mercado de beleza, transformo cabelos e autoestimas com técnicas avançadas e atendimento personalizado.';
    }
    
    return $sobre[0]['descricao'];
}
?>