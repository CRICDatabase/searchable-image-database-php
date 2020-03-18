<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 9/18/15
 * Time: 11:34 AM
 */

?>

<link href="../includes/jquery/css/style.css" rel="stylesheet">
<link href="../includes/jquery/css/jquery.fileupload.css" rel="stylesheet">
<div class="container">
    <ul class="breadcrumb">
        <li><a href="principal.php">Início</a> <span class="divider">/</span></li>
        <li class="active">Exportar</li>
    </ul>
    <div id="atualizadoSucesso" class="alert alert-success hide">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Conteúdo atualizado com sucesso.
    </div>
    <h3>Exportar</h3>
    <!-- Modal -->
    <a href="#" onclick="baixaTudo();" >Gerar dados e Imagens</a>
    <br><br>
    <a href="#" onclick="baixaDados();" >Gerar apenas dados</a>
    <img id="loader" class="hide" src="../img/ajax-loader.gif">
    <script>
        function baixaTudo(){
            $("#loader").show();
            $.post("baixarTudo.php",
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    $("#loader").hide();
                    window.location.href = valor;
                }
            );
        }
        function baixaDados(){
            $("#loader").show();
            $.post("baixarDados.php",
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    $("#loader").hide();
                    //window.location.href = valor;
                }
            );
        }

    </script>
</div> <!-- /container -->
<hr>

