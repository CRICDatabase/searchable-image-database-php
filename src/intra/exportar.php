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
        <li><a href="principal.php">Home</a> <span class="divider">/</span></li>
        <li class="active">Export</li>
    </ul>
    <div id="atualizadoSucesso" class="alert alert-success hide">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Conteúdo atualizado com sucesso.
    </div>
    <h3>Export</h3>
	Select:
	<select id="usuarios" onchange="carregaContornos(this.value);">
        <option value="0">All</option>
        <?php
        $sql = "SELECT usuarios.id, usuarios.nome, usuarios.sobrenome FROM usuarios
        INNER JOIN imagem_segmentos ON usuarios.id = imagem_segmentos.id_usuario
        WHERE imagem_segmentos.excluido = 0 GROUP BY usuarios.id ORDER BY nome ASC, sobrenome ASC";
        $query = mysql_query($sql);
        while($resultado = mysql_fetch_assoc($query)){
            echo '<option value="'.$resultado['id'].'">'.$resultado['nome']." ".$resultado['sobrenome'].'</option>';
        }
        ?>
    </select>
	<br>
    <!-- Modal -->
    <a href="#" onclick="baixaTudo();" >Data and Images</a>
    <br><br>
    <a href="#" onclick="baixaDados();" >Data</a>
    <br><br>
    <a href="#" onclick="baixaDadosNucleos();" >Classified Nucleus</a>
    <img id="loader" class="hide" src="../img/ajax-loader.gif">
    <br><br><br><br>
    <a href="../cric_v1.rar">CRIC_v1 ( 400 images with classified nucleus ) <i>832 MB</i></a>
    <script>
        function baixaTudo(){
            $("#loader").show();
            $.post("baixarTudo.php",
			{
                id_usuario:$('#usuarios').val()
            },
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
			{
                id_usuario:$('#usuarios').val()
            },
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    $("#loader").hide();
                    window.location.href = valor;
                }
            );
        }

        function baixaDadosNucleos(){
            $("#loader").show();
            $.post("baixarDadosNucleos.php",
            {
                id_usuario:$('#usuarios').val()
            },
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    $("#loader").hide();
                    window.location.href = valor;
                }
            );
        }

    </script>
</div> <!-- /container -->
<hr>

