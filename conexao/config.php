<?php
$base_url = realpath(__DIR__."/../");
require_once($base_url."/conexao/conexao.php");
function __autoload($nomeClasse){
    $base_url = realpath(__DIR__."/../");

	//Verifica se existe a classe no diret�rio classes
    if(file_exists($base_url."/libs/".$nomeClasse.".class.php")){
        //Se existe carrega
		include_once($base_url."/libs/".$nomeClasse.".class.php");
    }
	if(file_exists($base_url."/libs/ActiveRecord/".$nomeClasse.".class.php")){
        //Se existe carrega
        include_once($base_url."/libs/ActiveRecord/".$nomeClasse.".class.php");
    }
}