<?php

// $host = 'mysql.triviasistemas.com.br';
// $user = 'cric';
// $password = 'cric2015';
// $db = 'cric_ufop';
// // Tenta se conectar ao servidor MySQL
// $conexao = mysql_connect($host, $user, $password) or trigger_error(mysql_error());
// // Tenta se conectar a um banco de dados MySQL
// mysql_select_db($db, $conexao) or trigger_error(mysql_error());

// $administrador = 1;
// $usuario = 10;



$host = 'localhost';
$user = 'root';
$password = '';
$db = 'cric_ufop';
// Tenta se conectar ao servidor MySQL
$conexao = mysqli_connect($host, $user, $password, $db) or trigger_error(mysql_error());
// Tenta se conectar a um banco de dados MySQL

$administrador = 1;
$usuario = 10;