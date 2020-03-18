<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 10:00 AM
 */

$nivelAcesso = 200;

require_once("../conexao/config.php");
require_once('../login/restrito.php');

$id_imagem	= $_POST['id_imagem'];
$id_usuario = $_POST['usuario'];
if($id_usuario){

$sql = "SELECT * FROM  imagem_nucleos WHERE id_imagem = $id_imagem AND id_usuario = $id_usuario AND excluido =0";
$result = mysqli_query($conexao,$sql);
$cont = 0;
while($dados = mysqli_fetch_assoc($result)){
    $id = $dados['id'];
    $retorno[$cont]['id'] = $cont;
    $retorno[$cont]['id_nucleo'] = $dados['id'];
    $retorno[$cont]['id_imagem_tipo'] = $dados['id_imagem_tipo'];
    $retorno[$cont]['coordenadas_nucleo']['x'][] = $dados['x'];
    $retorno[$cont]['coordenadas_nucleo']['y'][] = $dados['y'];
    
    $cont++;
}
echo json_encode($retorno);
}