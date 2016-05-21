<form method="get">
    软件：<?=\Common\Helper\AdminForm::checkboxSoft($aGetSoftId, 'soft_ids', false)?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    日期：<?=\Common\Helper\Form::input_date('start_date', $sStartDate)?>
    至 <?=\Common\Helper\Form::input_date('end_date', $sEndDate)?>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <?=\Common\Helper\Form::submit('', '查询')?>
</form>
<hr>

<?php foreach ($aGetSoftId as $iSoftId) :?>
    <div style="width: 49%; float: left;" id="chart_effect_org_<?=$iSoftId?>"></div>
<?php endforeach;?>

<div style="clear: both;"></div>

<script>
$(function() {
    var chart_data = <?=json_encode($aSoftInstall);?>;
    var soft_key = <?=json_encode($aSoftKey);?>;

    for (var i in soft_key) {
        var series = [];
        series.push({
            name: soft_key[i],
            data: chart_data.effect[i],
            pointStart: chart_data.startTime,
            pointInterval: 24 * 3600 * 1000
        });
        new Highcharts.Chart({
            chart: {
                renderTo: 'chart_effect_org_' + i,
                type: 'spline'
            },
            title: {
                text: "软件有效安装曲线",
                useHTML: true
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                title:{text:'日期（月-日）'},
                //categories: chart_data.x_detail
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%m-%d'
                }
            },
            yAxis: {
                title: {
                    text: '每天有效安装'
                },
                min: 0
            },
            tooltip: {
                crosshairs: true,
                shared: true,
                xDateFormat: '%Y-%m-%d'
            },
            series: series
        });
    }
});
</script>
<script src="/Public/Highcharts-4.0.1/js/highcharts.js"></script>
