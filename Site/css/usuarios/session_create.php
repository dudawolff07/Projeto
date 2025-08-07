<?php
	//função para iniciar a sessão
	session_start();
	//criando uma variavel de sessão chamada nome
	$_SESSION["nome"] = "Julia";

	$_SESSION["idade"] = 18;


	//exibindo uma variável de sessão
	echo("Nome: ". $_SESSION["nome"]);
?>