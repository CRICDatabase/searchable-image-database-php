<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 10:00 AM
 */

$nivelAcesso = 100;

require_once("../conexao/config.php");
//require_once('../login/restrito.php');

$id	= $_POST['id_imagem'];
//$id_usuario = $_POST['id_usuario'];
if($id){

    $sql = "UPDATE imagem SET excluido = 1 WHERE id = $id ";
    echo $sql;
    $result = mysql_query($sql);
}

