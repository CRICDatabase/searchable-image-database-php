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

$id_segmento	= $_POST['id_contorno'];
if($id_segmento){

    $sql = "UPDATE imagem_nucleos SET excluido = 1 WHERE id = $id_segmento ";
    $result = mysql_query($sql);
    echo json_encode(1);
}