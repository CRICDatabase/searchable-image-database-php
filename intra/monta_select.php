<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/10/15
 * Time: 9:21 AM
 */
$nivelAcesso = 100;

require_once("../conexao/config.php");
require_once('../login/restrito.php');
$imagem_tipo = new ImagemTipo($conexao);

$imagem_tipo->montaSelectImagemTipo($_POST["select1"]);
