<?php
// includes/photo_functions.php - VERSÃO CORRIGIDA

function getUsuarioFoto($conn, $usuario_id) {
    // DEBUG
    error_log("🔍 Buscando foto para usuário: $usuario_id");
    
    $stmt = $conn->prepare("SELECT foto_perfil FROM usuario WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $foto_banco = $user['foto_perfil'];
        
        error_log("📸 Foto no banco: " . ($foto_banco ? $foto_banco : 'NULL'));
        
        if ($foto_banco) {
            $caminho_foto = '../uploads/fotos_perfil/' . $foto_banco;
            
            // DEBUG: Verificar se o arquivo existe
            if (file_exists($caminho_foto)) {
                error_log("✅ Arquivo encontrado: $caminho_foto");
                return $caminho_foto;
            } else {
                error_log("❌ Arquivo NÃO encontrado: $caminho_foto");
                // Listar o que existe na pasta para debug
                $pasta = '../uploads/fotos_perfil/';
                if (is_dir($pasta)) {
                    $arquivos = scandir($pasta);
                    error_log("📁 Conteúdo da pasta: " . implode(', ', $arquivos));
                }
            }
        }
    } else {
        error_log("❌ Usuário não encontrado no banco: $usuario_id");
    }
    
    // Se chegou aqui, retorna foto padrão
    $foto_padrao = '../images/avatar-default.png';
    error_log("🔄 Usando foto padrão: $foto_padrao");
    return $foto_padrao;
}

// Função alternativa mais simples
function getUsuarioFotoSimples($conn, $usuario_id) {
    $stmt = $conn->prepare("SELECT foto_perfil FROM usuario WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($user['foto_perfil']) {
            $caminho = '../uploads/fotos_perfil/' . $user['foto_perfil'];
            // Verificação SIMPLES se o arquivo existe
            if (@file_exists($caminho)) {
                return $caminho;
            }
        }
    }
    
    return '../images/avatar-default.png';
}
?>