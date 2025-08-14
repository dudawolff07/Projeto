<?php
	session_start();

	echo("Nome: " . $_SESSION["nome"] . "<br>");

	if(isset($_SESSION["idade"]) ==true){
	echo("Idade: " . $_SESSION["idade"] . "<br>");
}else{
	echo("A variável de sessão 'idade' ainda não foi criada");
}

unset($_SESSION["idade"]);
?>