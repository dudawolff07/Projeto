<?php
	
	// delete.php

	$id_usuario = $_GET["id"];	// recupera o parametro vindo pela url

	// é uma boa prática sempre testar se a conexão foi feita com sucesso - igual nos outros arquivos
	$con = mysqli_connect("127.0.0.1", "root", "", "programacaoparainternet");

	// consulta para excluir os registros
	$sql = "DELETE FROM usuarios WHERE id = $id_usuario";

	// função retorna true se a consulta foi executada com sucesso
	// o código deve ser melhorado, pois de fato não sabemos se um registro foi excluido. Presumimos que ele foi excluído, caso a consulta seja executada com sucesso, mas ao passar um id inexistente,  consulta será executada com sucesso.
	if (mysqli_query($con, $sql) ){
		echo ("<script>alert('Usuário excluído com sucesso');</script>");
	} else {
		echo ("<script>alert('Houve um erro ao excluir');</script>");
	}


?>