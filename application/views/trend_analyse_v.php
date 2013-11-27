<script src="<?php echo base_url().'Scripts/highcharts.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'Scripts/exporting.js'?>" type="text/javascript"></script>
<script>

$(function () {
        $('#container').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Consumption Trends',
                x: -20 //center
            },
            subtitle: {
                text: 'Source: ',
                x: -20
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Unit of quantity'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },credits: {
		enabled: false
		},
            tooltip: {
                valueSuffix: 'units'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Fp',
                data: <?php echo $myarray ?>
            } ]
        });
    });
    
</script>

<div id="container" style="margin: 0 auto;width:100%;height:100%"></div>