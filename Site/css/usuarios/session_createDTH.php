<?php

//session_createDTH

session_start();
//faça uma página que armazena a data e o horário que o usuário acessou a página e em seguida, mostre essa informação em outra página
date_default_timezone_set('America/Sao_Paulo');

$_SESSION['acesso'] = date('d/m/Y H:i');



?>