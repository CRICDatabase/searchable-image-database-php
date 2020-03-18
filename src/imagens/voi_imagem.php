<?php
/**
 * Created by PhpStorm.
 * User: Paulo
 * Date: 8/31/15
 * Time: 11:31 AM
 */
$imagem = new Imagem();
$dados = $imagem->getImagemById($_GET['id']);

$imagem_tipo = new ImagemTipo();
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
<div class="container">
    <ul class="breadcrumb">
        <li><a href="principal.php">Início</a> <span class="divider">/</span></li>
        <li class="active">Imagens</li>
    </ul>
    <div id="atualizadoSucesso" class="alert alert-success hide">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Conteúdo atualizado com sucesso.
    </div>
    <h3>VOI Imagens</h3>
    <!-- Modal -->
    Carregar Contornos
    <select id="usuarios" onchange="carregaContornos(this.value);">
        <option value="">Selecione</option>
        <?php
        $sql = "SELECT usuarios.id, usuarios.nome, usuarios.sobrenome FROM usuarios
        INNER JOIN imagem_segmentos ON usuarios.id = imagem_segmentos.id_usuario
        WHERE imagem_segmentos.excluido = 0 GROUP BY usuarios.id ORDER BY nome ASC, sobrenome ASC";
        $query = mysqli_query($conexao, $sql);
        while($resultado = mysqli_fetch_assoc($query)){
            echo '<option value="'.$resultado['id'].'">'.$resultado['nome']." ".$resultado['sobrenome'].'</option>';
        }
        ?>
    </select>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Dados segmento</h4>
                </div>
                <div class="modal-body">
                    <div id="nucleo" class="hide">Confirmar marcação do núcleo</div>
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
                    <button type="button" onclick="apagaFigura();" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" onclick="salvar();" class="btn btn-primary" data-dismiss="modal">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <canvas id="c" width="1280" height="1024"></canvas>
    <script>
        id_segmento = 0;
        coordenadasX = [];
        coordenadasY = [];
        var el = document.getElementById('c');
        var ctx = el.getContext('2d');
        var cPushArray = new Array();
        var cStep = -1;
        function desenhaSegmento(coordX,coorY, cor){
            if(cor==1){
                ctx.strokeStyle = "rgba(0,0,255,0.8)";
            }else if(cor==2){
                ctx.strokeStyle = "rgba(0,255,0,0.8)";
            } else if(cor==3){
                ctx.strokeStyle = "rgba(0,255,255,0.8)";
            }
            ctx.beginPath();
            ctx.moveTo(coordX[0], coorY[0]);
            for(i=1; i<coordX.length;i++){
                ctx.lineTo(coordX[i], coorY[i]);
            }
            ctx.closePath();
            ctx.stroke();
        }

        function carregaContornos(usuario){
            ctx.clearRect(0, 0, el.width, el.height);
            drawImage();
            $.post("carregaContornos.php",
                {
                    usuario:usuario
                    ,id_imagem:<?php echo $_GET['id']; ?>
                },
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    dados_contornos = JSON.parse(valor);
                    for(i2=0;i2<Object.keys(dados_contornos).length;i2++){
                        desenhaSegmento(dados_contornos[i2].coordenadas_segmento.x,dados_contornos[i2].coordenadas_segmento.y, dados_contornos[i2].id_imagem_tipo[0]);
                        if(Object.keys(dados_contornos[i2]).length==4){
                            desenhaSegmento(dados_contornos[i2].coordenadas_nucleo.x,dados_contornos[i2].coordenadas_nucleo.y, dados_contornos[i2].id_imagem_tipo[0]);
                        }
                    }
                }
            );
        }
        function carregaSelect2(selecionado){
            $("#select3").hide();
            $("#select4").hide();
            $("#select2").show();
            $("#select5").hide();
            $("#select6").hide();
            $("#select2").html('<option value="">Carregando...</option>');
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
            cUndo();
            coordenadasX.length=0;
            coordenadasY.length=0;
        }
        function salvaContorno(selecionado,tipo){
            $.post("salvarRoi.php",
                {
                    id_imagem:<?php echo $_GET['id']; ?>
                    ,id_imagem_tipo:selecionado
                    ,tipo:tipo //1- contorno, 2 - nucleo
                    ,coordenadasX:coordenadasX
                    ,coordenadasY:coordenadasY
                    ,id_segmento:id_segmento
                },
                // Carregamos o resultado acima para o campo marca
                function(valor){
                    if(valor){
                        id_segmento = valor;
                    }
                }
            );
        }
        function salvar(){
            if(desenhandoNucleo){//nucleo
                desenhandoNucleo = 0;
                desenhaCurva(1);
                salvaContorno(0,2);
            }else{
                if($("#select1").val()==1 && $("#select2 option:selected").text()!="Glandular"){
                    alert("Marque o núcleo");
                    desenhaCurva(1);
                    desenhandoNucleo = 1;
                    selecionado=0;
                    if($('#select6').is(":visible")){
                        selecionado = $('#select6').val();
                    }else if($('#select5').is(":visible")){
                        selecionado = $('#select5').val();
                    }else if($('#select4').is(":visible")){
                        selecionado = $('#select4').val();
                    }else if($('#select3').is(":visible")){
                        selecionado = $('#select3').val();
                    }else if($('#select2').is(":visible")){
                        selecionado = $('#select2').val();
                    }
                    salvaContorno(selecionado,1);
                }else if($("#select1").val()==1){
                    desenhaCurva(1);
                    selecionado=0;
                    if($('#select6').is(":visible")){
                        selecionado = $('#select6').val();
                    }else if($('#select5').is(":visible")){
                        selecionado = $('#select5').val();
                    }else if($('#select4').is(":visible")){
                        selecionado = $('#select4').val();
                    }else if($('#select3').is(":visible")){
                        selecionado = $('#select3').val();
                    }else if($('#select2').is(":visible")){
                        selecionado = $('#select2').val();
                    }
                    salvaContorno(selecionado,1);
                }else if($("#select1").val()==2){
                    desenhaCurva(2);
                    salvaContorno($('#select2').val(),1);
                }else if($("#select1").val()==3){
                    desenhaCurva(3);
                    salvaContorno($('#select2').val(),1);
                }
            }

            coordenadasX.length=0;
            coordenadasY.length=0;
        }
        function desenhaCurva(cor){
            //var el = document.getElementById('c');
            //var ctx = el.getContext('2d');
            if(cor==1){
                ctx.strokeStyle = "rgba(0,0,255,0.8)";
            }else if(cor==2){
                ctx.strokeStyle = "rgba(0,255,0,0.8)";
            } else if(cor==3){
                ctx.strokeStyle = "rgba(0,255,255,0.8)";
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
        function abrePopUp(varNucleo){
            if(varNucleo){
                $("#nucleo").show();
                $("#select3").hide();
                $("#select4").hide();
                $("#select2").hide();
                $("#select5").hide();
                $("#select6").hide();
                $("#select1").hide();
            }else{

                $("#select1").show();
                $('#select1 option:eq(0)').prop('selected', true);
                $("#nucleo").hide();
                $("#select3").hide();
                $("#select4").hide();
                $("#select2").hide();
                $("#select5").hide();
                $("#select6").hide();
            }
            $('#myModal').modal('show');
        }
        window.onload = function(){

            el = document.getElementById('c');
            ctx = el.getContext('2d');
            var isDrawing;
            desenhandoNucleo = 0;
            ctx.strokeStyle = "rgb(255,0,0)";
            el.onmousedown = function(e) {
                isDrawing = true;
                var mousePos = getMousePos(el, e);
                coordenadasX.push(mousePos.x);
                coordenadasY.push(mousePos.y);
                ctx.beginPath();
                ctx.moveTo(mousePos.x, mousePos.y);
                Draw(mousePos.x, mousePos.y, false);
            };
            el.onmousemove = function(e) {
                var mousePos = getMousePos(el, e);
                if (isDrawing) {
                    coordenadasX.push(mousePos.x);
                    coordenadasY.push(mousePos.y);
                    Draw(mousePos.x, mousePos.y, true);
                }
            };
            el.onmouseup = function() {
                ctx.closePath();
                ctx.stroke();
                cPush();
                isDrawing = false;
                abrePopUp(desenhandoNucleo);
            };
            drawImage();
        };

    </script>

</div> <!-- /container -->
