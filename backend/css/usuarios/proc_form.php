<?php
	// proc_form.php

	if (!isset($_POST["enviar"]) )
		header("location: create.php");

	// criando variaveis para armazenar o valor de cada input

	$usuario = $_POST["usuario"];
	$email = $_POST["email"];
	$nascimento = $_POST["nasc"];	
	$cpf = $_POST["cpf"];
	$telefone = $_POST["fone"];
	$id_cidade	= $_POST["cidade"];	// corresponde ao input select name="cidade" 
	$senha = $_POST["senha1"];
	$conf_senha =  $_POST["senha2"];

	$erros = [];	// array para armazenar os erros encontrados na hora do cadastro

	// testa se o campo nome foi preenchido
	if (empty($usuario) )
		$erros[] = "Preencha o <b>nome</b> corretamente";	// caso o nome esteja vazio, armazena essa mensagem dentro do array

	if (empty($email) )
		$erros[] = "Preencha o <b>e-email</b> corretamente";

	if (empty($nascimento) )
		$erros[] = "Preencha a <b>data de nascimento</b>";

	if (empty($cpf) )
		$erros[] = "Preencha o <b>cpf</b>";

	if (empty($telefone))
		$erros[] = "Preencha o <b>telefone</b>";

	// validação da senha

	if (empty($senha)){
		$erros[] = "Preencha a <b>senha</b>";
	} else {
		// se a senha foi preenchida, testa se são iguais
		if ($senha != $conf_senha)
			$erros[] = "As senhas não são iguais";
	}

	// testa para saber se houve erros ou não no preenchimento do formulário
	if (count($erros) == 0 ){
		// se não tem erros, os dados podem ser salvos no banco de dados
		// abrindo a conexão
		// ip do servidor mysql, usuario do banco de dados, senha do banco de dados, porta do mysql (esse parametro é opcional)
		$con = mysqli_connect("localhost", "root", "", "programacaoparainternet", 3306);

		$id = $_POST["id_usuario"];	// recuperando o campo oculto do formulário - necessário para saber se a operação é de edição

		// testa se variavel $id está preenchida
		if (isset($id) && !empty($id) ) {
			// se o $id está preenchido, a consulta é UPDATE
			$sql = "UPDATE usuarios SET nome = '$usuario', email = '$email', telefone = '$telefone', cpf = '$cpf', nascimento = '$nascimento', senha = '$senha' WHERE id = $id";
		} else {
			// consulta sql que insere no banco
			$sql = "INSERT INTO usuarios (nome, email, telefone, cpf, nascimento, senha, id_cidade) VALUES ('$usuario', '$email', '$telefone', '$cpf', '$nascimento', '$senha', $id_cidade) ";
		}

		if (mysqli_query($con, $sql) ){
			// retornou true - consulta executada com sucesso

			// validação para saber se a consulta foi de edição ou inserção e apresentar a mensagem apropriada ao usuário
			if (isset($id) && !empty($id) ) {
				echo ("<script>alert('Usuário atualizado com sucesso'); </script>");// por enquanto mostrando a mensagem usando um alert
			} else { 
				echo ("<script>alert('Usuário inserido com sucesso'); </script>");// por enquanto mostrando a mensagem usando um alert
			}

			//header("location: mostrar.php");
		} else {
			echo ("Houve um erro ao inserir no banco de dados");
		}
	} else {
		// se cair aqui, é porque tem erros
		foreach($erros as $erro){
			echo ("$erro <br>");
		}
	}


?>