<?php

$host = "localhost";
$db = "devramper";
$usuario = "dev";
$senha = "KeK6gud7dte8cqoF";
$conexao =  mysqli_connect($host, $usuario, $senha, $db);
if (!$conexao){
    die('Sem conexao com o Servidor MySQL: '.mysqli_error($conexao));
	exit;
	}
	
mysqli_set_charset($conexao, 'UTF8');

?>