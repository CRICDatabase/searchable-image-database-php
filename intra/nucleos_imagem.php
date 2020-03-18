<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 8/31/15
 * Time: 11:31 AM
 */
$imagem = new Imagem($conexao);
$dados = $imagem->getImagemById($_GET['id']);
$id = $_GET['id'];
$sql = "SELECT 
(SELECT max(id) FROM imagem WHERE id < $id AND excluido = 0 LIMIT 1   ) as menor, 
(SELECT id FROM imagem WHERE id > $id  AND excluido = 0 LIMIT 1 ) as maior";
$result = mysqli_query($conexao,$sql);
while($dados2 = mysqli_fetch_assoc($result) ){
    $menor = $dados2['menor'];
    $maior = $dados2['maior'];
}



$imagem_tipo = new ImagemTipo($conexao);
?>
<style>
    body{
        padding:0;
        border: 0;
        margin: 0;
    }
    canvas {
        margin: 0;
        border: 0px ;
        padding:0;
        /*background-image: url(../imagens/<?php //echo $dados['dados'][0]['nome']; ?>);*/
    }
</style>
<link href="../includes/jquery/css/style.css" rel="stylesheet">
<link href="../includes/jquery/css/jquery.fileupload.css" rel="stylesheet">


<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete all</h4>
      </div>
      <div class="modal-body">
        <p>Do you really want to delete all?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="excluirTodosContornos();">Delete all</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete image</h4>
            </div>
            <div class="modal-body">
                <p>Do you really want to delete image?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Dismiss</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="excluirImagem();">Delete image</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="container">
    <ul class="breadcrumb">
        <li><a href="principal.php">Home</a> <span class="divider">/</span></li>
        <li class="active">Images</li>
    </ul>
    <div id="atualizadoSucesso" class="alert alert-success hide">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Rename success.
    </div>

    <?php //print_r($dados);?>
    <h3>Nucleus: <?php echo $dados['dados'][0]['id']; ?>
        <input type="text" id="identificacao" name="identificacao" value="<?php echo $dados['dados'][0]['identificacao']; ?>">
        <input type="text" id="lamina" name="lamina" placeholder="lamina" value="<?php echo $dados['dados'][0]['lamina']; ?>">
        <input type="text" id="ano" name="ano" placeholder="ano" value="<?php echo $dados['dados'][0]['ano']; ?>">
        <button style="margin-top: -10px;" class="btn" id="renomear" data-loading-text="Loading..." type="button" onclick="renomear()">Rename</button>
        <button style="margin-top: -10px;" type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#myModal2">Delete Image</button>
    </h3>

    <!-- Modal -->
    <?php if($menor){ ?>
    <a href="principal.php?pagina=nucleosImagem&id=<?php echo $menor; ?>" class="btn" style="margin-top: -10px;">< back</a>
    <?php } ?>
    Load nucleus
    <select id="usuarios" onchange="carregaNucleos(this.value);">
        <option value="">Select</option>
        <?php
        $sql = "SELECT usuarios.id, usuarios.nome, usuarios.sobrenome FROM usuarios
        INNER JOIN imagem_nucleos ON usuarios.id = imagem_nucleos.id_usuario
        WHERE imagem_nucleos.excluido = 0 GROUP BY usuarios.id ORDER BY nome ASC, sobrenome ASC";
        $query = mysqli_query($conexao,$sql);
        while($resultado = mysqli_fetch_assoc($query)){
            echo '<option value="'.$resultado['id'].'">'.$resultado['nome']." ".$resultado['sobrenome'].'</option>';
        }
        ?>
    </select>
    Mark nucleus as
    <select id="nucleoTipo" onchange="mudaTipo(this.value);">
        <option value="0">Normal</option>
        <option value="1">ASC-US</option>
        <option value="2">LSIL</option>
        <option value="3">ASC-H</option>
        <option value="4">HSIL</option>
        <option value="5">Carcinoma</option>
    </select>
	<button class="btn" id="undo" onclick="desfazer();" disabled="disabled" style="margin-top: -10px;">undo</button>
    <?php
    $id_usuario = $_SESSION['UsuarioID'];
    if($id_usuario==15){
     ?>
    
    <button class="btn btn-primary" id="aprove" onclick="aprovar();" style="margin-top: -10px;">aprove</button>
    <?php } ?>
    <div class="pull-right">
        <select name="contornos" id="select_contornos" onchange="selecionaContorno(this.value);">
            <option value="0">Select nucleus</option>
        </select>
		<?php if(!$guest){ ?>
        <button style="margin-top: -10px;" class="btn" id="excluir_segmento" type="button" onclick="excluirContorno()">Delete</button>
		<?php } ?>
        <?php if($maior){ ?>
        <a href="principal.php?pagina=nucleosImagem&id=<?php echo $maior; ?>" class="btn" style="margin-top: -10px;">next ></a>
        <?php } ?>
	</div>
	
    
    <canvas id="c" width="1280" height="1024"></canvas>
    <script>
        ultimo_inserido = 0;
        id_segmento = 0;
        tipoNucleo = 0;
        coordenadasX = [];
        coordenadasY = [];
        var el = document.getElementById('c');
        var ctx = el.getContext('2d');
        var cPushArray = new Array();
        var cStep = -1;
        function desenhaSegmento(coordX,coordY, cor, id_contorno){
            if(cor==0){
                ctx.strokeStyle = "green";
            }else if(cor==1){
                ctx.strokeStyle = "yellow";
             
            }else if(cor==2){
                ctx.strokeStyle = "pink";
            
            }else if(cor==3){
                ctx.strokeStyle = "red";
             
            }else if(cor==4){
                ctx.strokeStyle = "purple";
            
            }else if(cor==5){
                ctx.strokeStyle = "black";
            } 

            ctx.beginPath();
            ctx.rect(coordX-50, coordY-50, 100, 100);
            ctx.closePath();
            ctx.stroke();
            ctx.font = "20px Arial";
            ctx.fillStyle = "#FF0000";
            ctx.fillText(id_contorno,coordX,coordY);
        }
        function mudaTipo(tipo){
            tipoNucleo = tipo;
        }

        function desfazer(){
            
            $.post("excluirNucleo.php",
                {
                    id_contorno:ultimo_inserido
                    },
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        selecionaContorno(0);
                        $('#excluir_segmento').val(0);
                        $('#undo').attr("disabled", "disabled");
                    }
                );
        }

        function renomear(){
            
            $.post("renomearImagem.php",
                {
                    id:<?php echo $_GET['id']; ?>
                    ,identificacao:$('#identificacao').val()
                    ,lamina:$('#lamina').val()
                    ,ano:$('#ano').val()
                    },
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        $(".alert").show()
                    }
                );
        }

        function carregaNucleos(usuario){
            ctx.clearRect(0, 0, el.width, el.height);
            drawImage();
            $.post("carregaNucleos.php",
                {
                    usuario:usuario
                    ,id_imagem:<?php echo $_GET['id']; ?>
                },
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    dados_contornos = JSON.parse(valor);
                    conteudo_select = '<option value="0">All</option>';
                    for(i2=0;i2<Object.keys(dados_contornos).length;i2++){
                        desenhaSegmento(dados_contornos[i2].coordenadas_nucleo.x , dados_contornos[i2].coordenadas_nucleo.y,dados_contornos[i2].id_imagem_tipo[0],dados_contornos[i2].id_nucleo);
                        
                        conteudo_select = conteudo_select + '<option value="'+dados_contornos[i2].id_nucleo+'">'+dados_contornos[i2].id_nucleo+' - '+dados_contornos[i2].id_imagem_tipo+'</option>'
                    }
                    $('#select_contornos').html(conteudo_select);
                    //$('#excluir_segmento').attr("disabled", "disabled");
                }
            );
        }

        function excluirTodosContornos(){
            $.post("excluirNucleos.php",
                {
                    id_imagem:<?php echo $_GET['id']; ?>,
                    id_usuario:$('#usuarios').val()
                    },
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        selecionaContorno(0);
                        $('#excluir_segmento').val(0);
                        //$('#excluir_segmento').attr("disabled", "disabled");
                    }
                );
        }

        function excluirImagem(){
            $.post("excluirImagem2.php",
                {
                    id_imagem:<?php echo $_GET['id']; ?>
                },
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    window.location.href="principal.php?pagina=listarImagensClassificacao";
                }
            );
        }

        function aprovar(){
            $.post("aprovarClassificacao.php",
                {
                    id:<?php echo $_GET['id']; ?>
                    
                    },
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        
                        $('#aprove').attr("disabled", "disabled");
                    }
                );
        }

        function excluirContorno(){
            if($('#select_contornos').val()==0){

                $('#myModal').modal('show');
            }else{
                $.post("excluirNucleo.php",
                {
                    id_contorno:$('#select_contornos').val()
                    },
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        selecionaContorno(0);
                        $('#excluir_segmento').val(0);
                        //$('#excluir_segmento').attr("disabled", "disabled");
                    }
                );
            }
            
        }
        function excluirContorno2(){
            $.post("excluirContorno.php",
                {
                    id_contorno:id_segmento
                },
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    //selecionaContorno(0);
                   // $('#excluir_segmento').val(0);
                   // $('#excluir_segmento').attr("disabled", "disabled");
                }
            );
        }
        function selecionaContorno(id_contorno){
            if(id_contorno==0){
                carregaNucleos($('#usuarios').val());
                //$('#excluir_segmento').attr("disabled", "disabled");
                $('#excluir_segmento').removeAttr("disabled");

            }else{
                $('#excluir_segmento').removeAttr("disabled");
                ctx.clearRect(0, 0, el.width, el.height);
                drawImage();
                $.post("carregaNucleo.php",
                    {
                        id_contorno:id_contorno
                    },
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        dados_contornos = JSON.parse(valor);                       
                        desenhaSegmento(dados_contornos.coordenadas_nucleo.x,dados_contornos.coordenadas_nucleo.y, dados_contornos.coordenadas_nucleo.tipo,id_contorno);
                    }
                );
            }

        }
        
        function cPush() {
            cStep++;
            if (cStep < cPushArray.length) { cPushArray.length = cStep; }
            cPushArray.push(document.getElementById('c').toDataURL());
        }
        function cUndo() {
            if (cStep > 0) {
                cStep--;
                var canvasPic = new Image();
                canvasPic.src = cPushArray[cStep];
                canvasPic.onload = function () { ctx.drawImage(canvasPic, 0, 0); }
            }
        }
        function getMousePos(canvas, evt){
            // get canvas position
            var obj = canvas;
            var top = 0;
            var left = 0;
            while (obj && obj.tagName != 'BODY') {
                top += obj.offsetTop;
                left += obj.offsetLeft;
                obj = obj.offsetParent;
            }

            // return relative mouse position
            var mouseX = evt.clientX - left + window.pageXOffset;
            var mouseY = evt.clientY - top + window.pageYOffset;
            return {
                x: mouseX,
                y: mouseY
            };
        }
        function rgbToHex(r, g, b) {
            if (r > 255 || g > 255 || b > 255)
                throw "Invalid color component";
            return ((r << 16) | (g << 8) | b).toString(16);
        }

        function apagaFigura(){
            if(desenhandoNucleo){//nucleo
                desenhandoNucleo = 0;
                excluirContorno2();
                carregaContornos($('#usuarios').val());
            }else{
                carregaContornos($('#usuarios').val());
            }
            coordenadasX.length=0;
            coordenadasY.length=0;
        }
        function salvaNucleo(x,y,tipo){
            try{              
				
                $.post("salvarNucleo.php",
                    {
                        id_imagem:<?php echo $_GET['id']; ?>
                        ,tipo:tipo 
                        ,coordenadasY:y
                        ,coordenadasX:x                        
                    },
                    // Carregamos o resultado acima para o campo marca
                    function(valor){
                        ultimo_inserido = valor;
                        $('#undo').removeAttr("disabled");
                    }
                );
            }
            catch(err){
                alert(err.message);
            }

        }
        
        function desenhaCurva(cor){
            //var el = document.getElementById('c');
            //var ctx = el.getContext('2d');
            if(cor==0){
                ctx.strokeStyle = "green";
            }else if(cor==1){
                ctx.strokeStyle = "yellow";
            
            }else if(cor==2){
                ctx.strokeStyle = "pink";
            
            }else if(cor==3){
                ctx.strokeStyle = "red";
            
            }else if(cor==4){
                ctx.strokeStyle = "purple";
         
            }else if(cor==5){
                ctx.strokeStyle = "black";
            } 
            ctx.beginPath();
            ctx.moveTo(coordenadasX[0], coordenadasY[0]);
            for(i=1; i<coordenadasX.length;i++){
                ctx.lineTo(coordenadasX[i], coordenadasY[i]);
            }
            ctx.closePath();
            ctx.stroke();

        }

        function Draw(x, y, isDown) {
            if (isDown) {
                ctx.strokeStyle = "red";
                ctx.lineWidth = 2;
                ctx.lineJoin = "round";
                ctx.lineTo(x, y);
                ctx.stroke();
            }
        }
        function drawImage() {
            var image = new Image();
            image.src = '../imagens/<?php echo $dados['dados'][0]['nome']; ?>';
            $(image).load(function () {
                ctx.drawImage(image, 0, 0);
                cPush();
            });
        }
        
        window.onload = function(){

            el = document.getElementById('c');
            ctx = el.getContext('2d');
            var isDrawing;
            desenhandoNucleo = 0;
            ctx.strokeStyle = "rgb(255,0,0)";

            el.onmousedown = function(e){
                var rect = this.getBoundingClientRect();
               
               //Criamos uma estrutura contendo as coordenadas atuais do mouse
               var coords = {
                      x : e.clientX - rect.left,
                      y : e.clientY - rect.top
               };
               console.log("Coordenada Atual: " + coords.x + ", " + coords.y);
               
               

               if(tipoNucleo==0){
                ctx.strokeStyle = "green";
            }else if(tipoNucleo==1){
                ctx.strokeStyle = "yellow";
             
            }else if(tipoNucleo==2){
                ctx.strokeStyle = "pink";
            
            }else if(tipoNucleo==3){
                ctx.strokeStyle = "red";
             
            }else if(tipoNucleo==4){
                ctx.strokeStyle = "purple";
            
            }else if(tipoNucleo==5){
                ctx.strokeStyle = "black";
            } 
               //Preenchemos a cor em hexadecimal
               ctx.beginPath();

               //Criamos o retangulo na tela
               ctx.rect(coords.x-50, coords.y-50, 100, 100);
               ctx.stroke();
               salvaNucleo(coords.x,coords.y,tipoNucleo);
            }


            
            drawImage();
        };

    </script>

</div> <!-- /container -->
