<?php
$host = "localhost";
$db   = "projeto";
$user = "root";
$pass = "";    

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>