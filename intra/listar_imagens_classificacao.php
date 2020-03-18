<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 8/31/15
 * Time: 11:31 AM
 */
$imagem = new Imagem($conexao);
$imagem_tipo = new ImagemTipo($conexao);

 

$sql = "SELECT COUNT(imagem_nucleos.id) as total,`id_imagem_tipo` FROM `imagem_nucleos` INNER JOIN imagem ON imagem_nucleos.id_imagem = imagem.id WHERE imagem.excluido=0 AND id_usuario =15 And imagem_nucleos.excluido = 0 GROUP BY `id_imagem_tipo`;";
$result = mysqli_query($conexao,$sql);
$dados['total'] = mysqli_num_rows($result);
while ($dados2 = mysqli_fetch_assoc($result)) {
  $dados['dados'][] = $dados2;
}

$sql2 = "SELECT id as total FROM `imagem` WHERE excluido=0;";
$result2 = mysqli_query($conexao,$sql2);
$dados2['total'] = mysqli_num_rows($result2);


?>
<link href="../includes/jquery/css/style.css" rel="stylesheet">
<link href="../includes/jquery/css/jquery.fileupload.css" rel="stylesheet">
<div class="container">
    <ul class="breadcrumb">
        <li><a href="principal.php">Home</a> <span class="divider">/</span></li>
        <li class="active">Images</li>
    </ul>
    <div id="atualizadoSucesso" class="alert alert-success hide">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Updated Success.
    </div>
    <h3>Images(Total: <?php echo $dados2['total']; ?>)</h3>
    <div class="row">
        <div class="span8">Click image to zoom and have access to specialist segmentation. Select images and segmentation specialist from list for download (available soon)</div>

        <div class="span2">
    <?php echo 'Normal - '.$dados['dados'][0]['total']; ?><br>
    <?php echo 'ASC-US - '.$dados['dados'][1]['total']; ?><br> 
    <?php echo 'LSIL - '.$dados['dados'][2]['total']; ?><br>
    </div>
    <div class="span2">
    <?php echo 'ASC-H - '.$dados['dados'][3]['total']; ?><br>
    <?php echo 'HSIL - '.$dados['dados'][4]['total']; ?><br>
    <?php echo 'Carcinoma - '.$dados['dados'][5]['total']; ?><br>
        </div>
    </div>
	<?php if(!$guest){ ?>
    <input name="identificacao" id="identificacao" style="margin-bottom: 0;" type="text" placeholder="Label">

    <span class="btn btn-success fileinput-button">
        <i class="icon-plus"></i>
        <span>Add images...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="foto" data-url="trata_adicionar_foto.php" multiple>

    </span>

	
    <script src="../includes/jquery/vendor/jquery.ui.widget.js"></script>
    <script src="../includes/jquery/jquery.iframe-transport.js"></script>
    <script src="../includes/jquery/jquery.fileupload.js"></script>
    <script>
	
        $(function () {
            $('#fileupload').bind('fileuploadsubmit', function (e, data) {
                // The example input, doesn't have to be part of the upload form:
                var input = $('#identificacao');
                data.formData = {identificacao: input.val()};
                if (!data.formData.identificacao) {
                    data.context.find('button').prop('disabled', false);
                    input.focus();
                    return false;
                }
            });

            $('#fileupload').fileupload({

                /* ... */
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .bar').css(
                        'width',
                        progress + '%'
                    );
                    if(progress==100){
                        location.reload();
                    }
                }
            });
        });



    </script>
    <div id="progress" class="progress progress-striped active" style="margin-top: 10px;">
        <div class="bar" style="width: 0%;"></div>
    </div>
<?php } ?>
<button class="btn btn-secondary" onclick="$('#myModal').modal('show');$('#myModal').removeClass( 'hidden' );" >Search </button>
<div class="modal fade hidden" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Segment data</h4>
                </div>
                <div class="modal-body">
                    <div id="nucleo" class="hide">Confirm nucleus segmentation</div>
                    <select id="select1" onchange="carregaSelect2(this.value);">
                        <?php
                        $imagem_tipo->montaSelectImagemTipo(0);
                        ?>
                    </select>
                    <br>
                    <select id="select2" onchange="carregaSelect3(this.value);" class="hide" ></select><br>
                    <select id="select3" onchange="carregaSelect4(this.value);" class="hide" ></select><br>
                    <select id="select4" onchange="carregaSelect5(this.value);" class="hide" ></select><br>
                    <select id="select5" onchange="carregaSelect6(this.value);" class="hide" ></select><br>
                    <select id="select6"  class="hide" ></select><br>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="apagaFigura();" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="pesquisar();" class="btn btn-primary" data-dismiss="modal">Search</button>
                </div>
            </div>
        </div>
    </div>
    <?php //$usuario->gerarModaisEditar(); ?>
    <hr />
    
		<?php
		$pesquisar = 0;
		if(isset($_GET['pesquisar'])){
			$pesquisar = $_GET['pesquisar'];
		}
         $imagem->getImagemsTableClassificacao($pesquisar); ?>
    <hr />




</div> <!-- /container -->
<script>
function carregaSelect2(selecionado){
            $("#select3").hide();
            $("#select4").hide();
            $("#select2").show();
            $("#select5").hide();
            $("#select6").hide();
            $("#select2").html('<option value="">Loading...</option>');
            $.post("monta_select.php",
                {select1:selecionado},
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    $("#select2").html(valor);
                }
            );


        }
        function carregaSelect3(selecionado){
            $("#select3").hide();
            $("#select4").hide();
            $("#select5").hide();
            $("#select6").hide();
            if(selecionado>=10 && selecionado < 20){
                $("#select3").show();
                $("#select3").html('<option value="">Carregando...</option>');
                $.post("monta_select.php",
                    {select1:selecionado},
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        $("#select3").html(valor);
                    }
                );
            }
        }
        function carregaSelect4(selecionado){
            $("#select5").hide();
            $("#select6").hide();
            if(selecionado>=100 && selecionado < 200){
                $("#select4").show();
                $("#select4").html('<option value="">Carregando...</option>');
                $.post("monta_select.php",
                    {select1:selecionado},
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        $("#select4").html(valor);
                    }
                );
            }
        }
        function carregaSelect5(selecionado){
            if($("#select4 option:selected").text()=="Normal"){
                $("#select5").hide();
            }
            $("#select6").hide();
            if($("#select4 option:selected").text()!="Normal"){
                if(selecionado>=1000 && selecionado < 2000){

                    $("#select5").show();
                    $("#select5").html('<option value="">Carregando...</option>');
                    $.post("monta_select.php",
                        {select1:selecionado},
                        // Carregamos o resultado acima para o campo marca
                        function(valor){
                            $("#select5").html(valor);
                        }
                    );
                }
            }
        }
        function carregaSelect6(selecionado){
            if($("#select5 option:selected").text()=="Normal"){
                $("#select6").hide();
            }
            if($("#select2 option:selected").text()!="Metaplásico" && $("#select5 option:selected").text()!="Normal"){
                if(selecionado>=10000 && selecionado < 20000){
                    $("#select6").show();
                    $("#select6").html('<option value="">Carregando...</option>');
                    $.post("monta_select.php",
                        {select1:selecionado},
                        // Carregamos o resultado acima para o campo marca
                        function(valor){
                            $("#select6").html(valor);
                        }
                    );
                }
            }
        }
		function pesquisar(){
			if($('#select6').is(":visible")){
				if($('#select6').val()==""){
					selecionado = $('#select5').val();
				}else{
					selecionado = $('#select6').val();
				}                
            }else if($('#select5').is(":visible")){
               if($('#select5').val()==""){
					selecionado = $('#select4').val();
				}else{
					selecionado = $('#select5').val();
				}
            }else if($('#select4').is(":visible")){
                if($('#select4').val()==""){
					selecionado = $('#select3').val();
				}else{
					selecionado = $('#select4').val();
				}
            }else if($('#select3').is(":visible")){
                if($('#select3').val()==""){
					selecionado = $('#select2').val();
				}else{
					selecionado = $('#select3').val();
				}
            }else if($('#select2').is(":visible")){
                if($('#select2').val()==""){
					selecionado = $('#select1').val();
				}else{
					selecionado = $('#select2').val();
				}
            }
			window.location.href = "http://"+window.location.hostname + window.location.pathname + '?pagina=listarImagens&&pesquisar='+selecionado;
		}
		
		
</script>
