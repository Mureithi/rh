<style>

	.whole_report{
	      
    position: relative;
  width: 92%;
  background: #FFFAF0;
  -moz-border-radius: 4px;
  border-radius: 4px;
  padding: 2em 1.5em;
  color: rgba(0,0,0, .8);
  
  line-height: 1.5;
  margin: 20px auto;
  -webkit-box-shadow: 0px 0px 10px rgba(0,0,0,.8);
   -moz-box-shadow: 0px 0px 10px rgba(0,0,0,.8);
   box-shadow: 0px 0px 10px rgba(0,0,0,.8);	
	}
	
</style>

<div class="whole_report">
<table class="data-table">
	<th colspan="14" style="height: 3em; text-align: center; font-size: 3em"> Family Planning Forecast(By County)</th>	
	
	<tr>
		<th><strong>County</strong></th>
		
		
		<th><strong>FP Injections</strong></th>
		<th><strong>Pills Microlut</strong></th>
		<th><strong>Pills Microgynon</strong></th>
		<th><strong>IUCD insertion</strong></th>
		<th><strong>IUCD Removals</strong></th>
		<th><strong>Implants insertion</strong></th>
		<th><strong>Implants Removal</strong></th>
		<th><strong>Sterilization BTL </strong></th>
		<th><strong>Steriliz Vasectomy</strong></th>
		<th><strong>NFP</strong></th>
		
		<th><strong><b>All others FPs</b></strong></th>
		<th><strong><b>Clints condom</b></strong></th>
	</tr><tbody>
		
		<?php 
				foreach ($result as $result ) { ?>
					
							
						<tr>
							
							<td><?php echo $result['county'];?> </td>
							
							
							<td><?php echo round(($result['FP_injections']/3)*12*1.05*1.1*1.25);?> </td>
							<td><?php echo round(($result['Pills_Microlut']/3)*12*1.05*1.1*1.25);?></td>
							<td><?php echo round(($result['Pills_Microgynon']/3)*12*1.05*1.1*1.25);?></td>
							<td> <?php echo round(($result['IUCD_insertion']/3)*12*1.05*1.1*1.25);?> </td>
							<td><?php echo round(($result['IUCD_Removals']/3)*12*1.05*1.1*1.25);?> </td>
							<td><?php echo round(($result['Implants_insertion']/3)*12*1.05*1.1*1.25);?></td>
							<td> <?php echo round(($result['Implants_Removal']/3)*12*1.05*1.1*1.25);?> </td>
							<td> <?php echo round(($result['Sterilization_BTL']/3)*12*1.05*1.1*1.25);?> </td>
							<td><?php echo round(($result['Steriliz_Vasectomy']/3)*12*1.05*1.1*1.25);?> </td>
							<td><?php echo round(($result['NFP']/3)*12*1.05*1.1*1.25);?></td>
							<td><?php echo round(($result['All_others_FP']/3)*12*1.05*1.1*1.25);?></td>
							<td> <?php echo round(($result['Clints_condom']/3)*12*1.05*1.1*1.25);?> </td>
							
							
						</tr>
					
		</tbody>
		
		<?php }
					?>	
	 
</table>

</div>
