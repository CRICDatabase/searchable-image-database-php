<?php

class ImagemTipo {

    private $id;
    private $tipo;
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
        $this->tipo = $_POST['tipo'];
    }

    public function cadastrarImagemTipo() {
        $this->setCampos();
        $imagemTipoAR = new ImagemTipoAR($this->conexao);
        return $imagemTipoAR->cadastrarImagemTipo($this->tipo);

    }

    public function atualizarImagemTipo() {
        $this->setCampos();
        $imagemTipoAR = new ImagemTipoAR($this->conexao);
        return $imagemTipoAR->editarImagemTipo($this->id, $this->tipo);

    }

    public function getImagemTipos() {
        $imagemTipoAR = new ImagemTipoAR($this->conexao);
        $dados = $imagemTipoAR->getImagemTipos();
        return $dados;
    }

    public function montaSelectImagemTipo($selecionado){
        $imagemTipoAR = new ImagemTipoAR($this->conexao);
        $dados = $imagemTipoAR->getImagemTipos();
        echo '<option value="" >Select</option>';
        for($i=0; $i < $dados['total'];$i++){
            if($dados['dados'][$i]['id']==$selecionado){
                $selecionado1 = ' selected="selected"';
            }else{
                $selecionado1 = '';
            }
            if($selecionado==0 && $dados['dados'][$i]['id']<10){
                echo '<option value="'.$dados['dados'][$i]['id'].'" '.$selecionado1.' >'.utf8_encode($dados['dados'][$i]['tipo']).'</option>';
            }elseif($selecionado<10){
                if($dados['dados'][$i]['id']>=($selecionado*10) && $dados['dados'][$i]['id']<(($selecionado+1)*10)){
                    echo '<option value="'.$dados['dados'][$i]['id'].'" '.$selecionado1.' >'.utf8_encode($dados['dados'][$i]['tipo']).'</option>';
                }
                if($selecionado==2 && $dados['dados'][$i]['id']==201){
                    echo '<option value="'.$dados['dados'][$i]['id'].'" '.$selecionado1.' >'.utf8_encode($dados['dados'][$i]['tipo']).'</option>';
                }
            }elseif($selecionado>=10 && $selecionado<20){
                if($dados['dados'][$i]['id']>=($selecionado*10) && $dados['dados'][$i]['id']<(($selecionado+1)*10)){
                    echo '<option value="'.$dados['dados'][$i]['id'].'" '.$selecionado1.' >'.utf8_encode($dados['dados'][$i]['tipo']).'</option>';
                }
            }elseif($selecionado>=100 && $selecionado<200){
                if($dados['dados'][$i]['id']>=($selecionado*10) && $dados['dados'][$i]['id']<(($selecionado+1)*10)){
                    echo '<option value="'.$dados['dados'][$i]['id'].'" '.$selecionado1.' >'.utf8_encode($dados['dados'][$i]['tipo']).'</option>';
                }
            }elseif($selecionado>=1000 && $selecionado<2000){
                if($dados['dados'][$i]['id']>=($selecionado*10) && $dados['dados'][$i]['id']<(($selecionado+1)*10)){
                    echo '<option value="'.$dados['dados'][$i]['id'].'" '.$selecionado1.' >'.utf8_encode($dados['dados'][$i]['tipo']).'</option>';
                }
            }elseif($selecionado>=10000 && $selecionado<20000){
                if($dados['dados'][$i]['id']>=($selecionado*10) && $dados['dados'][$i]['id']<(($selecionado+1)*10)){
                    echo '<option value="'.$dados['dados'][$i]['id'].'" '.$selecionado1.' >'.utf8_encode($dados['dados'][$i]['tipo']).'</option>';
                }
            }

        }
    }
}