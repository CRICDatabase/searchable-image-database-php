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

$id_imagem	= $_POST['id_imagem'];
$id_usuario = $_POST['id_usuario'];

    $sql = "UPDATE imagem_nucleos SET excluido = 1 WHERE id_imagem = $id_imagem AND id_usuario = $id_usuario ";
    $result = mysql_query($sql);
    echo json_encode(1);
