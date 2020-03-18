<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 11:45 AM
 */
ini_set('memory_limit', '64M');
$nivelAcesso = 100;

$id_usuario = $_POST['id_usuario'];

require_once("../conexao/config.php");
require_once('../login/restrito.php');
$sufixo = time();
$fp = fopen("arquivos/dados_nucleos_".$sufixo.".csv", "w");
$escreve = fwrite($fp, "id;nome;identificacao;id_nucleo;id_tipo;id_usuario;X;Y \n");
fclose($fp);

$sql = "SELECT
imagem.id,imagem.nome,imagem.identificacao
,imagem_nucleos.id AS id_nucleo,imagem_nucleos.id_imagem_tipo, imagem_nucleos.id_usuario
,imagem_nucleos.x AS segX, imagem_nucleos.y AS segY
 FROM imagem 
INNER JOIN imagem_nucleos ON imagem.`id` = imagem_nucleos.id_imagem 
 WHERE imagem.excluido=0 AND imagem_nucleos.excluido=0";
 
$result = mysqli_query$($conexao,$sql);
$cont = 0;
$cont2 = 0;
$total = mysqli_num_rows($result);

$razao = $total/100000;
for( $i=0; $i< $razao; $i++){
	$nova_sql = $sql . " LIMIT ".( 100000 *$i).", 100000";
	$result = mysqli_query$($conexao,$nova_sql);

	$buff = "";
	while($dados = mysql_fetch_assoc($result) ){
		$buff .= $dados['id'].";".$dados['nome'].";".$dados['identificacao'].";".$dados['id_nucleo'].";".$dados['id_imagem_tipo'].";".$dados['id_usuario'].";".$dados['segX'].";".$dados['segY']."\n";
    	$cont++;
    	$cont2++;
	}
	file_put_contents("arquivos/dados_nucleos_".$sufixo.".csv", $buff, FILE_APPEND);
	flush();	
}


$zip = new ZipArchive();
if( $zip->open( 'arquivos/arquivo'.$sufixo.'.zip' , ZipArchive::CREATE )  === true){
    $zip->addFile(  "arquivos/dados_nucleos_".$sufixo.".csv" , "dados".$sufixo.".csv" );
    $zip->close();
}else{
    echo "erro ao abrir zip";
}

echo 'arquivos/arquivo'.$sufixo.'.zip';

