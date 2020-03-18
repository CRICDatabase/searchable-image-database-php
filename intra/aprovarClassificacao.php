<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 10:00 AM
 */

$nivelAcesso = 100;

require_once("../conexao/config.php");
require_once('../login/restrito.php');

$id	= $_POST['id'];
if($id){

    $sql = "UPDATE imagem SET aprovado_classificacao = 1 WHERE id = $id ";
	//echo $sql;
    $result = mysqli_query($conexao, $sql);
}
