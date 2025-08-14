<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Mostrando os usuários cadastrados</title>
	<link rel="stylesheet" href="../css/table.css">
</head>
<body>
	<h1>Usuários cadastrados</h1>
	
	<?php
		// se conecta com o banco de dados
		$con = mysqli_connect("localhost", "root", "", "programacaoparainternet");

		// testa se a conexão com o banco de dados ocorreu com sucesso
		if (!$con){
			die("Não foi possível conectar com o banco de dados");
		}

		// consulta para buscar os usuários com o nome em ordem alfabética
		$sql = "SELECT id, nome, email, telefone, cpf, DATE_FORMAT(nascimento, '%d/%m/%Y') AS nascimento FROM usuarios";

		// variavel para armazenar o que a função mysqli_query retornou
		// consultas do tipo select retornam um result set (conjunto de registros)		
		$resultado = mysqli_query($con, $sql);

		// testa se tem registros para serem exibidos
		if (mysqli_num_rows($resultado) > 0){
			// gerando a tabela para mostrar os registros
			echo ('<table>
				<thread>
					<tr>
						<th>Nome</th>
						<th>E-mail</th>
						<th>Data de nascimento</th>
						<th>CPF</th>
						<th>Telefone</th>
						<th>Ações</th>
					</tr>
				</thread>
				<tbody>'
			);

			// percorre o resultset
			while ($linha = mysqli_fetch_assoc($resultado) ) {
				echo ("<tr>");	// abre um nova linha
				// adiciona os dados a cada linha
				// o que está entre colchetes é o nome do campo no banco de dados
				echo ("<td>" . $linha["nome"] . "</td>");
				echo ("<td>" . $linha["email"] . "</td>");
				echo ("<td>" . $linha["nascimento"] . "</td>");
				echo ("<td>" . $linha["cpf"] . "</td>");
				echo ("<td>" . $linha["telefone"] . "</td>");
				// exibindo os botões de ações
				echo ("<td>
						<a href='edit.php?id=" . $linha['id'] ." ' class='btn btn-edit'>Editar</a>
						<a href='delete.php?id=" . $linha['id'] . " ' class='btn btn-delete'>Excluir</a>
					</td>
				");
				echo ("</tr>");	// fecha a linha
			}
			// depois que saiu do while
			echo ("</tbody></table>");
		}
	?>
</body>
</html>