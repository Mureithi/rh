<?php 
$fpcommodity=$this -> session -> userdata('commodity');
 //echo $fpcommodity; 
?>

	<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: 'FP Commodities By County (<?php echo $fpcommodity ?>)',
            },
            subtitle: {
                text: 'Source: DHIS',
                x: -20
            },
            xAxis: {
                categories: <?php echo $arrayName ?>,
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '0.85em',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Consumption (Persons) in "000'
                }
            },credits: {
		enabled: false
		},
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: $('#getcommodity').val(),
            },
            series: [{
                name: $('#getcommodity').val(),
                data: <?php echo $arrayData ?>,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '0.7em',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });
    });
    

		</script>

<div id="container" style="margin: 0 auto;width:100%;height:100%"></div>

