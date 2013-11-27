  <?php
include ("Scripts/FusionCharts/FusionCharts.php");
//$selectedItem = '';
?>
  <SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url(); ?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>

  <script> 
  	$(function() {
		$(document).ready(function() {
			$('#county').val(1);
  	var url = "<?php echo base_url().'statistics_controller/get_default_perdistrict'?>
				";
				$.ajax({
				type: "POST",
				//data: {},
				url: url,
				beforeSend: function() {
				$(".my_chart").html("");
				},
				success: function(msg) {
				$(".my_chart").html(msg);

				}
				});

				$("#generategraph").click(function(){
				var url = "
<?php echo base_url().'statistics_controller/get_commodity_perdistrict'?>
			";
			//alert ($('#getcommodity').val());
			$.ajax({
			type: "POST",
			data: { 'county': $('#county').val()},
			url: url,
			beforeSend: function() {
			$(".my_chart").html("");
			},
			success: function(msg) {
			$(".my_chart").html(msg);

			}
			});
			});
			});
			});

  </script>  
  <style>
	.container {

		width: 100%;
		height: auto;
		min-height: 65em;
		margin: auto;
		padding: 3px;
	}
	.my_chart {
		width: 90%;
		resize: both;
		height: auto;
		margin: auto;
		overflow: auto;
	}
	.top_content {
		width: 100%;
		height: auto;;
		margin: auto;
		padding: 3px;
		display: inline;
	}
	#generategraph {

	}

   </style>
   
   
   
	
	<div class="container">
		
				
	<div class="top_content" style="display: inline-block;">
		
		<h2 style="margin-left:8% ">Click below to select County</h2>
	
	
	
				
        <select class="dropdownsize" id="county" name="county" style="width: 25%; margin-left:8% ">
    <option>Select FP Commodity</option>
		<?php 
		foreach ($county as $county) {
			$id=$county->id;
			$drug=$county->county;
			?>
			<option value="<?php echo $id; ?>"><?php echo $drug; ?></option>
		<?php } ?>
	</select>        
	<button class="awesome blue" id="generategraph" style="margin-left:0.5%">Generate</button>
		
	</div>	
	
	<div class="my_chart">
		
		
	</div>	
		
		
	
	