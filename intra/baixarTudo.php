<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 11:45 AM
 */
$nivelAcesso = 100;
$id_usuario = $_POST['id_usuario'];


require_once("../conexao/config.php");
require_once('../login/restrito.php');
$sufixo = time();
$fp = fopen("arquivos/dados".$sufixo.".csv", "w");
$escreve = fwrite($fp, "id;nome;identificacao;id_segmento;id_imagem_tipo;id_usuario;segX;segY \n");
if($id_usuario == 0){
$sql = "SELECT
imagem.id,imagem.nome,imagem.identificacao
,imagem_segmentos.id AS id_segmento,imagem_segmentos.id_imagem_tipo, imagem_segmentos.id_usuario
,coordenadas_segmento.x AS segX, coordenadas_segmento.y AS segY
,coordenadas_nucleo.x AS nucX, coordenadas_nucleo.y AS nucY
 FROM imagem
INNER JOIN imagem_segmentos ON imagem.`id` = imagem_segmentos.id_imagem
INNER JOIN coordenadas_segmento ON imagem_segmentos.id = coordenadas_segmento.id_segmento
LEFT JOIN coordenadas_nucleo ON imagem_segmentos.id = coordenadas_nucleo.id_segmento
 WHERE imagem.excluido=0 AND imagem_segmentos.excluido=0";
 }else{
	$sql = "SELECT
imagem.id,imagem.nome,imagem.identificacao
,imagem_segmentos.id AS id_segmento,imagem_segmentos.id_imagem_tipo, imagem_segmentos.id_usuario
,coordenadas_segmento.x AS segX, coordenadas_segmento.y AS segY
,coordenadas_nucleo.x AS nucX, coordenadas_nucleo.y AS nucY
 FROM imagem
INNER JOIN imagem_segmentos ON imagem.`id` = imagem_segmentos.id_imagem
INNER JOIN coordenadas_segmento ON imagem_segmentos.id = coordenadas_segmento.id_segmento
LEFT JOIN coordenadas_nucleo ON imagem_segmentos.id = coordenadas_nucleo.id_segmento
 WHERE imagem.excluido=0 AND imagem_segmentos.excluido=0 AND imagem_segmentos.id_usuario=$id_usuario;";
 }
$result = mysqli_query($conexao,$sql);
$cont = 0;
while($dados = mysql_fetch_assoc($result)){
    $escreve = fwrite($fp, $dados['id'].";".$dados['nome'].";".$dados['identificacao'].";".$dados['id_segmento'].";".$dados['id_imagem_tipo'].";".$dados['id_usuario'].";".$dados['segX'].";".$dados['segY']."\n");
}
fclose($fp);

$fp = fopen("arquivos/coord_nucleos_dados".$sufixo.".csv", "w");
$escreve = fwrite($fp, "id_segmento;x;y \n");

$sql = "SELECT id_segmento, x, y
 FROM coordenadas_nucleo";
$result = mysqli_query($conexao,$sql);
$cont = 0;
while($dados = mysql_fetch_assoc($result)){
    $escreve = fwrite($fp, $dados['id_segmento'].";".$dados['x'].";".$dados['y']."\n");
}
fclose($fp);

$fp = fopen("arquivos/tipos_dados".$sufixo.".csv", "w");
$escreve = fwrite($fp, "id;tipo \n");

$sql = "SELECT id, tipo
 FROM imagem_tipo

 WHERE excluido=0 ";
$result = mysqli_query($conexao,$sql);
$cont = 0;
while($dados = mysql_fetch_assoc($result)){
    $escreve = fwrite($fp, $dados['id'].";".$dados['tipo']."\n");
}
fclose($fp);

$zip = new ZipArchive();
if( $zip->open( 'arquivos/arquivo'.$sufixo.'.zip' , ZipArchive::CREATE )  === true){
    $zip->addFile(  "arquivos/dados".$sufixo.".csv" , "dados".$sufixo.".csv" );
    $zip->addFile(  "arquivos/tipos_dados".$sufixo.".csv" , "tipos_dados".$sufixo.".csv" );
    $zip->addFile(  "arquivos/coord_nucleos_dados".$sufixo.".csv" , "coord_nucleos_dados".$sufixo.".csv" );
    $sql = "SELECT imagem.nome FROM imagem WHERE imagem.excluido=0 ";
    $result = mysqli_query($conexao,$sql);
    while($dados = mysql_fetch_assoc($result)){
        $nomeArquivo = str_replace("jpg","tif",$dados['nome']);
        $zip->addFile(  '../imagens/'.$nomeArquivo , 'images/'.$nomeArquivo );
    }
    $zip->close();
}else{
    echo "erro ao abrir zip";
}

echo 'arquivos/arquivo'.$sufixo.'.zip';

