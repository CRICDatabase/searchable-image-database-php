<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto; margin-top:20px;"></div>

<?php 
/*$sql = "SELECT count(imagem_segmentos.id) as total,imagem_tipo.tipo  FROM `imagem_segmentos`
INNER JOIN imagem_tipo ON imagem_tipo.id = imagem_segmentos.id_imagem_tipo
WHERE 1 GROUP BY tipo
ORDER BY imagem_tipo.tipo ASC;
";
$result = mysql_query($sql);
$dados['total'] = mysql_num_rows($result);
while ($dados2 = mysql_fetch_assoc($result)) {
  $dados['dados'][] = $dados2;
}

?>

<script type="text/javascript">
  $(function () {

    $(document).ready(function () {

        // Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Availble Cells in Database'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [
              {
                name: 'Samples',
                colorByPoint: true,
                data: [
                {
                    name: '<?php echo $dados['dados'][0]['tipo']; ?>',
                    y: <?php echo $dados['dados'][0]['total']; ?>
                }
                <?php
                  for($i=1;$i<$dados['total'];$i++){
                   ?>
                   , {
                    name: '<?php echo utf8_encode($dados['dados'][$i]['tipo']); ?>',
                    y: <?php echo $dados['dados'][$i]['total']; ?>
                    }
                   <?php
                  }
                ?> 
                ]
            }]
        });
    });
});

</script>
*/ ?>

<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto; margin-top:20px;"></div>

<?php 
$sql = "SELECT COUNT(imagem_nucleos.id) as total,`id_imagem_tipo` FROM `imagem_nucleos`
INNER JOIN imagem ON imagem_nucleos.id_imagem = imagem.id
WHERE imagem.excluido=0
GROUP BY `id_imagem_tipo`;";
$result = mysqli_query($conexao,$sql);
$dados['total'] = mysqli_num_rows($result);
while ($dados2 = mysqli_fetch_assoc($result)) {
  $dados['dados'][] = $dados2;
}
$tipos = [ 
            0=>'Normal'
            ,1=>'ASC-US'
            ,2=>'LSIL'
            ,3=>'ASC-H'
            ,4=>'HSIL'
            ,5=>'Carcinoma'
        ];

?>

<script type="text/javascript">
  $(function () {

    $(document).ready(function () {

        // Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Availble Nuclei in Database'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [
              {
                name: 'Nuclei Samples',
                colorByPoint: true,
                data: [
                {
                    name: 'Normal',
                    y: <?php echo $dados['dados'][0]['total']; ?>
                }
                <?php
                  for($i=1;$i<$dados['total'];$i++){
                   ?>
                   , {
                    name: '<?php echo $tipos[$dados['dados'][$i]['id_imagem_tipo']]; ?>',
                    y: <?php echo $dados['dados'][$i]['total']; ?>
                    }
                   <?php
                  }
                ?> 
                ]
            }]
        });
    });
});

</script>