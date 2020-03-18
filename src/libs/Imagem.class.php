<?php

class Imagem {

    private $id;
    private $nome;
    private $identificacao;
    public $conexao;

    public function __construct($l){
        $this->conexao = $l;
    }
    public function validaCamposCadastroContato() {
        if (empty($_POST)) {
            return false;
        }
        return true;
    }

    private function setCampos() {
        $this->id = $_POST['id'];
        $this->nome = ($_POST['nome']);
        $this->identificacao = $_POST['identificacao'];
    }

    public function cadastrarImagem() {
        $this->setCampos();
        $imagemAR = new ImagemAR($this->conexao);
        return $imagemAR->cadastrarImagem($this->nome, $this->identificacao);

    }

    public function atualizarImagem() {
        $this->setCampos();
        $imagemAR = new ImagemAR($this->conexao);
        return $imagemAR->editarImagem($this->id, $this->identificacao);

    }

    public function getId() {
        return $this->id;
    }

    public function getImagems($pesquisa) {
        $imagemAR = new ImagemAR($this->conexao);
        $dados = $imagemAR->getImagems($pesquisa);
        return $dados;
    }


    public function getImagemById($id) {
        $imagemAR = new ImagemAR($this->conexao);
        $dados = $imagemAR->getImagemsById($id);
        return $dados;
    }

    public function getImagemsTable($pesquisa){
        $dados = $this->getImagems($pesquisa);
        $cont = 0;
        while($dados['total']>$cont){
            //$editar = '<a href="#editarImagem'.$dados['dados'][$cont]['id'].'" role="button" class="btn btn-primary" data-toggle="modal">Editar</a>';
            $vois = '<a href="principal.php?pagina=voiImagem&id='.$dados['dados'][$cont]['id'].'" role="button" class="btn btn-success" >Segments('.$dados['dados'][$cont]['total'].')</a>';
			$excluir = '<a href="excluirImagem.php?id='.$dados['dados'][$cont]['id'].'" role="button" class="btn btn-danger" >Delete</a>';
            if($dados['dados'][$cont]['ativo']==1){
                $ativa = '<img src="../img/ok.png" id="img'.$dados['dados'][$cont]['id'].'">';
                $desativar = '';
                $ativar = 'hide';
            }else{
                $ativa = '<img src="../img/ok.png" id="img'.$dados['dados'][$cont]['id'].'" class="hide">';
                $ativar = '';
                $desativar = 'hide';
            }
			if($dados['dados'][$cont]['total']>0){
			$excluir = '';
			}
            
            echo '<div class="pull-left" style="padding:5px; margin:10px; border:solid 1px #888888;" >
                    <div class="center-block">
                        <a href="principal.php?pagina=voiImagem&id='.$dados['dados'][$cont]['id'].'" ><img src="../imagens/' . $dados['dados'][$cont]['nome'] . '" class="img-polaroid" alt="'.($cont+1).' - '.$dados['dados'][$cont]['identificacao'].'" style="max-width:100; max-height:100px;"></a>
                    </div>
                    <div class="center-block" style="margin:10px;text-align: center;" >
                        '.($cont+1).' - '.$dados['dados'][$cont]['identificacao'].'<br>
                        '.$vois.' '.$excluir.'
                    </div class="center-block">
                    <div id ="carregando"'.$dados['dados'][$cont]['id'].' class="hide"><img src="../img/ajax-loader.gif" /></div>
                </div>

            ';
            $cont++;
        }
    }

    public function getImagemsTableClassificacao($pesquisa){
        $imagemAR = new ImagemAR($this->conexao);
        $dados = $imagemAR->getImagemsClassificacao($pesquisa);
        $cont = 0;
        while($dados['total']>$cont){
            //$editar = '<a href="#editarImagem'.$dados['dados'][$cont]['id'].'" role="button" class="btn btn-primary" data-toggle="modal">Editar</a>';
            $vois = '<a href="principal.php?pagina=nucleosImagem&id='.$dados['dados'][$cont]['id'].'" role="button" class="btn btn-success" >Nucleus('.$dados['dados'][$cont]['total'].')</a>';
            $excluir = '<a href="excluirImagem.php?id='.$dados['dados'][$cont]['id'].'" role="button" class="btn btn-danger" >Delete</a>';
            if($dados['dados'][$cont]['ativo']==1){
                $ativa = '<img src="../img/ok.png" id="img'.$dados['dados'][$cont]['id'].'">';
                $desativar = '';
                $ativar = 'hide';
            }else{
                $ativa = '<img src="../img/ok.png" id="img'.$dados['dados'][$cont]['id'].'" class="hide">';
                $ativar = '';
                $desativar = 'hide';
            }
            $aprovado = '';
            if($dados['dados'][$cont]['aprovado_classificacao']==1){
                $aprovado = '<span class="label label-primary">OK</span>';
            }

            if($dados['dados'][$cont]['total']>0){
            $excluir = '';
            }
            $excluir = '';//alterar depois
            echo '<div class="pull-left" style="padding:5px; margin:10px; border:solid 1px #888888;" >
                    <div class="center-block">
                        <a href="principal.php?pagina=nucleosImagem&id='.$dados['dados'][$cont]['id'].'" ><img src="../imagens/' . $dados['dados'][$cont]['nome'] . '" class="img-polaroid" alt="'.($cont+1).' - '.$dados['dados'][$cont]['identificacao'].'" style="max-width:100; max-height:100px;"></a>
                    </div>
                    <div class="center-block" style="margin:10px;text-align: center;" >
                        '.($dados['dados'][$cont]['id']).' - '.$dados['dados'][$cont]['identificacao'].'<br>'.($dados['dados'][$cont]['lamina']).' - '.$dados['dados'][$cont]['ano'].'<br>
                        '.$vois.' '.$excluir.' '.$aprovado.'
                    </div class="center-block">
                    <div id ="carregando"'.$dados['dados'][$cont]['id'].' class="hide"><img src="../img/ajax-loader.gif" /></div>
                </div>

            ';
            $cont++;
        }
    }
    
}