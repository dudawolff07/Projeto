<?php
include 'db.php';

/**
 * Busca todos os procedimentos do banco de dados
 */
function getProcedimentosPorCategoria($conn) {
    $result = $conn->query("SELECT * FROM procedimento ORDER BY procedimento_id DESC");
    $procedimentos = [];
    
    while ($row = $result->fetch_assoc()) {
        $procedimentos[] = $row;
    }
    
    return $procedimentos;
}

/**
 * Exibe um card de procedimento no catálogo
 */
function exibirProcedimento($procedimento, $linkAgenda) {
    $categoria_class = htmlspecialchars($procedimento['categoria_procedimento']);
    $nome = htmlspecialchars($procedimento['nome_procedimento']);
    $valor = number_format($procedimento['valor_procedimento'], 2, ',', '.');
    $tempo = $procedimento['tempo_procedimento'];
    $descricao = htmlspecialchars($procedimento['descricao_procedimento'] ?? 'Serviço profissional realizado por nossa equipe especializada.');
    
    // Processar imagem
    $imagem = '';
    if (!empty($procedimento['foto_procedimento'])) {
        $imagem = "data:image/jpeg;base64," . base64_encode($procedimento['foto_procedimento']);
    } else {
        $imagem = getImagemPadrao($procedimento['categoria_procedimento']);
    }
    
    // Formatar tempo para exibição
    $tempo_formatado = formatarTempo($tempo);
    
    // Gerar o HTML do card
    echo "
    <div class='col-sm-6 col-lg-4 all {$categoria_class}'>
        <div class='box'>
            <div>
                <div class='img-box'>
                    <img src='{$imagem}' alt='{$nome}'>
                    <div class='tempo-badge'>{$tempo_formatado}</div>
                </div>
                <div class='detail-box'>
                    <h5>{$nome}</h5>
                    <p>{$descricao}</p>
                    <div class='options'>
                        <div class='price-time'>
                            <h6>R$ {$valor}</h6>
                            <span class='time-info'><i class='fa fa-clock-o'></i> {$tempo_formatado}</span>
                        </div>
                        <a href='{$linkAgenda}' class='agendar-btn' title='Agendar este serviço'>📅</a>
                    </div>
                </div>
            </div>
        </div>
    </div>";
}

/**
 * Retorna imagem padrão baseada na categoria
 */
function getImagemPadrao($categoria) {
    $imagens = [
        'penteados' => '../images/penteadoSimples.png',
        'corte' => '../images/cortefeminino.png',
        'combos' => '../images/corteEhidratacao.jpg',
        'tratamentos' => '../images/tratamento.png',
        'progressiva' => '../images/alisamentosemformol.png',
        'coloracao' => '../images/coloracao.png'
    ];
    
    return $imagens[$categoria] ?? '../images/sem-foto.png';
}

/**
 * Formata o tempo em minutos para exibição amigável
 */
function formatarTempo($minutos) {
    if ($minutos < 60) {
        return "{$minutos} min";
    } else {
        $horas = floor($minutos / 60);
        $minutos_restantes = $minutos % 60;
        
        if ($minutos_restantes == 0) {
            return "{$horas}h";
        } else {
            return "{$horas}h{$minutos_restantes}min";
        }
    }
}
?>