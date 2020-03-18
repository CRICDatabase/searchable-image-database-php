<?php 
$nivelAcesso = 100;

require_once("../conexao/config.php");
require_once('../login/restrito.php');

$imagem_tipo = $_POST['identificacao'];
$foto = $_FILES['foto'];

// Se a foto estiver sido selecionada 
if (!empty($foto["name"])) {   
	// Largura m�xima em pixels 
	$largura = 1500000000000;
	
	// Altura m�xima em pixels 
	$altura = 1800000000000;
	
	// Tamanho m�ximo do arquivo em bytes 
	$tamanho = 100000000000000;
	
	// Verifica se o arquivo � uma imagem 
	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp|tif|tiff)$/", $foto["type"])){
		$error[1] = "Isso não é uma imagem.";
	}


	// Pega as dimens�es da imagem 
	$dimensoes = getimagesize($foto["tmp_name"]);   
	
	// Verifica se a largura da imagem � maior que a largura permitida 
	if($dimensoes[0] > $largura) { 
		$error[2] = "A largura da imagem não deve ultrapassar ".$largura." pixels";
	}   
	
	// Verifica se a altura da imagem � maior que a altura permitida 
	if($dimensoes[1] > $altura) { 
		$error[3] = "Altura da imagem não deve ultrapassar ".$altura." pixels";
	}   
	
	// Verifica se o tamanho da imagem � maior que o tamanho permitido 
	if($foto["size"] > $tamanho) { 
		$error[4] = "A imagem deve ter no máximo ".$tamanho." bytes";
	}   
	
	// Se n�o houver nenhum erro 
	if (count($error) == 0) {   
		// Pega extens�o da imagem 
		preg_match("/\.(gif|bmp|png|jpg|jpeg|tif|tiff){1}$/i", $foto["name"], $ext);
		
		// Gera um nome �nico para a imagem 
		$nome_imagem = md5(uniqid(time())) . "." . $ext[1];   
		
		// Caminho de onde ficar� a imagem 
		$caminho_imagem = "../imagens/" . $nome_imagem;


		
		// Faz o upload da imagem para seu respectivo caminho 
		if(!move_uploaded_file($foto["tmp_name"], $caminho_imagem)){
			echo "erro ao mover imagem";
		}else{
            //echo $foto["type"];
            if($foto["type"]=="image/tiff" | $foto["type"]=="image/tif"){
                //echo $caminho_imagem.$nome_imagem;
                $im = new imagick( $caminho_imagem );
                $im->setCompression(Imagick::COMPRESSION_JPEG);
                $im->setCompressionQuality(80);
                $im->setImageFormat('jpeg');
                $caminho_imagem =  str_replace('.tif', '.jpg', $caminho_imagem);
                $nome_imagem =  str_replace('.tif', '.jpg', $nome_imagem);
                $im->writeImage($caminho_imagem);
                $im->clear();
                $im->destroy();

            }
			// Insere os dados no banco 
			$sql = mysql_query("INSERT INTO imagem  SET nome = '".$nome_imagem."',identificacao = '".$imagem_tipo."'");
			
			// Se os dados forem inseridos com sucesso 
			if ($sql){ 
				//header('Location: principal.php?pagina=album_fotos&&id='.$id_album);
                echo "adicionado com sucesso";
			} 
		}
	}   
	// Se houver mensagens de erro, exibe-as 
	if (count($error) != 0) { 
		foreach ($error as $erro) { 
			echo $erro . ""; 
		} 
	} 
}