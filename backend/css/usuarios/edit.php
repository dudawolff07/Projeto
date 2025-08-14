<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Cadastrando novo usuário</title>
	<link rel="stylesheet" href="../css/form.css">
</head>
<body>
	<?php
		// recuperando o id que vem pela url
		$id_usuario = $_GET["id"];

		$con = mysqli_connect("127.0.0.1", "root", "", "programacaoparainternet");

		// testa se a conexão com o banco de dados ocorreu com sucesso

		if ($con) {

			// busca o usuário com o id informado
			$sql = "SELECT * FROM usuarios WHERE id = $id_usuario";

			// executa a consulta
			$resultado = mysqli_query($con, $sql);

			// testa se a consulta retornou algum registro - se houver registros, só irá retornar 1, pois a consulta é pela chave primária do registro
			if (mysqli_num_rows($resultado) == 1) {

				$usuario = mysqli_fetch_array($resultado);

				// criando variaveis contendo o valor de cada coluna do banco de dados (retornada na consulta) 
				$nome = $usuario["nome"];
				$email = $usuario["email"];
				$fone = $usuario["telefone"];
				$cpf = $usuario["cpf"];
				$nasc = $usuario["nascimento"];
			} else {
				// não retornou nenhum registro
				// redireciona para o arquivo mostrar.php
				header("location: mostrar.php");
			}

		} else {
			die("Erro ao conectar com o banco de dados");
		}
	?>
	<div class="container">
	<form method="POST" action="proc_form.php">
		<fieldset>
			<legend>Novo usuário</legend>
			<!-- para preencher os valores de cada input, é necessário inserir os valores dentro da tag value -->
			Nome: <input type="text" name="usuario" value="<?php echo ($nome); ?>"> <br>
			Email: <input type="email" name="email" value="<?= $email ?>"> <!-- forma abreviada para mostrar uma varaivel --><br>
			Nascimento: <input type="date" name="nasc" value="<?= $nasc ?>"> <br>
			CPF: <input type="text" name="cpf" value="<?= $cpf ?>"> <br>
			Telefone: <input type="text" name="fone" value="<?= $fone ?>"> <br>
			Senha: <input type="password" name="senha1"> <br>
			Confirme a senha: <input type="password" name="senha2"> <br>
			<input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">
			<input type="submit" name="enviar" value="Salvar">
		</fieldset>
	</form>
</div>
</body>
</html>