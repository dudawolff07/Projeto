<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Adicionar novo procedimento
    if (isset($_POST['acao']) && $_POST['acao'] === 'adicionar') {
        $nome = $_POST['nome_procedimento'];
        $valor = $_POST['valor_procedimento'];
        $tempo = $_POST['tempo_procedimento'];
        $categoria = $_POST['categoria_procedimento'];
        $descricao = $_POST['descricao_procedimento'] ?? '';

        $foto = null;
        if (!empty($_FILES['foto_procedimento']['tmp_name'])) {
            $foto = file_get_contents($_FILES['foto_procedimento']['tmp_name']);
        }

        $stmt = $conn->prepare("INSERT INTO procedimento (nome_procedimento, valor_procedimento, tempo_procedimento, foto_procedimento, categoria_procedimento, descricao_procedimento) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdisss", $nome, $valor, $tempo, $foto, $categoria, $descricao);
        if ($foto) {
            $stmt->send_long_data(3, $foto);
        }
        $stmt->execute();
        $stmt->close();

        header("Location: ../Admin/catalogoAdmin.php?msg=adicionado");
        exit;
    }

    // Editar procedimento existente
    if (isset($_POST['acao']) && $_POST['acao'] === 'editar') {
        $id = $_POST['procedimento_id'];
        $nome = $_POST['nome_procedimento'];
        $valor = $_POST['valor_procedimento'];
        $tempo = $_POST['tempo_procedimento'];
        $categoria = $_POST['categoria_procedimento'];
        $descricao = $_POST['descricao_procedimento'] ?? '';

        if (!empty($_FILES['foto_procedimento']['tmp_name'])) {
            $foto = file_get_contents($_FILES['foto_procedimento']['tmp_name']);
            $stmt = $conn->prepare("UPDATE procedimento SET nome_procedimento=?, valor_procedimento=?, tempo_procedimento=?, foto_procedimento=?, categoria_procedimento=?, descricao_procedimento=? WHERE procedimento_id=?");
            $stmt->bind_param("sdisssi", $nome, $valor, $tempo, $foto, $categoria, $descricao, $id);
            $stmt->send_long_data(3, $foto);
        } else {
            $stmt = $conn->prepare("UPDATE procedimento SET nome_procedimento=?, valor_procedimento=?, tempo_procedimento=?, categoria_procedimento=?, descricao_procedimento=? WHERE procedimento_id=?");
            $stmt->bind_param("sdissi", $nome, $valor, $tempo, $categoria, $descricao, $id);
        }

        $stmt->execute();
        $stmt->close();
        header("Location: ../Admin/catalogoAdmin.php?msg=editado");
        exit;
    }

    // Remover procedimento
    if (isset($_POST['acao']) && $_POST['acao'] === 'remover') {
        $id = $_POST['procedimento_id'];
        $stmt = $conn->prepare("DELETE FROM procedimento WHERE procedimento_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: ../Admin/catalogoAdmin.php?msg=removido");
        exit;
    }
}
?>