<script src="<?php echo base_url().'Scripts/highcharts.js'?>" type="text/javascript"></script>
<script src="<?php echo base_url().'Scripts/exporting.js'?>" type="text/javascript"></script>
<?php 
$fpcommodity=$this -> session -> userdata('commodity');
 //echo $fpcommodity; 
?>

<script>

		$(document).ready(function() {
	$(function () {
        $('#container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Consumption by District'
            },
            xAxis: {
                categories: <?php echo $arrayN ?>
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Family Planning Commodity consumption'
                }
            },
            tooltip: {
                pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
                shared: true
            },
            plotOptions: {
                column: {
                    stacking: 'percent'
                }
            },credits: {
		enabled: false
		},
                series: [{
                name: 'FP injections',
                data: <?php echo $arrayseries1 ?>
            }, {
                name: 'Pills Microlut',
                data: <?php echo $arrayseries2 ?>
            }, {
                name: 'Pills Microgynon',
                data: <?php echo $arrayseries3 ?>
            },{
                name: 'IUCD insertion',
                data: <?php echo $arrayseries4 ?>
            },{
                name: 'IUCD Removals',
                data: <?php echo $arrayseries5 ?>
            },{
                name: 'Implants insertion',
                data: <?php echo $arrayseries6 ?>
            },{
                name: 'Implants_Removal',
                data: <?php echo $arrayseries7 ?>
            },{
                name: 'Sterilization BTL',
                data: <?php echo $arrayseries8 ?>
            },{
                name: 'Steriliz Vasectomy',
                data: <?php echo $arrayseries9 ?>
            },{
                name: 'NFP',
                data: <?php echo $arrayseries10 ?>
            },{
                name: 'All others FPs',
                data: <?php echo $arrayseries11 ?>
            },{
                name: 'Clints condom',
                data: <?php echo $arrayseries12 ?>
            }
            ]
        });
    });
    

    
	 });
	
</script>


<div id="container" style="margin: 0 auto;width:100%;height:100%"></div>

