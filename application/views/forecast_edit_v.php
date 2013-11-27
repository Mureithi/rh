<script>
	
	
      $(function() {
	$('#fpscaleup,#fpcorrection').keyup(function() {
					var scaleup=$('input:[id=fpscaleup]').val();
					var correction=$('input:[id=fpcorrection]').val();
					var clientNo=$('input:[id=clientNofp]').val();
					var fptotal=$('input:[id=fptotal]').val();
					var modifyfp=correction*scaleup*clientNo*4;	
					//Math.round(modifyfp*100)/100;				
					$('input:text[id=modifiedfprq]').val(modifyfp);
							});
						
						
						$('#pillmitscaleup,#pillmitcorrection').keyup(function() {
					var scaleup1=$('input:[id=pillmitscaleup]').val();
					var correction1=$('input:[id=pillmitcorrection]').val();
					var clientNopm1=$('input:[id=clientNopm1]').val();
					var modifypmit=correction1*scaleup1*clientNopm1*12;
					$('input:text[id=modifiedpmrq1]').val(modifypmit);
							});
							
							$('#pillmgnscaleup,#pillmgncorrection').keyup(function() {
					var scaleup2=$('input:[id=pillmgnscaleup]').val();
					var correction2=$('input:[id=pillmgncorrection]').val();
					var clientNopm2=$('input:[id=clientNopm2]').val();
					var modifypmgn=correction2*scaleup2*clientNopm2*12;					
					$('input:text[id=modifiedpmgn]').val(modifypmgn);
							});
							
							$('#IUCDscaleup,#IUCDcorrection').keyup(function() {
					var scaleup3=$('input:[id=IUCDscaleup]').val();
					var correction3=$('input:[id=IUCDcorrection]').val();
					var clientNoiucd=$('input:[id=clientNoiucd]').val();
					var modifyiucd=correction3*scaleup3*clientNoiucd;					
					$('input:text[id=IUCD]').val(modifyiucd);
							});
							
							$('#implantsscaleup,#implantscorrection').keyup(function() {
					var scaleup4=$('input:[id=implantsscaleup]').val();
					var correction4=$('input:[id=implantscorrection]').val();
					var clientNoimplants=$('input:[id=implants]').val();
					var modifyimplants=correction4*scaleup4*clientNoimplants;					
					$('input:text[id=modifyimplants]').val(modifyimplants);
							});
							$('#sterilescaleup,#sterilecorrection').keyup(function() {
					var scaleup5=$('input:[id=sterilescaleup]').val();
					var correction5=$('input:[id=sterilecorrection]').val();
					var sterile=$('input:[id=sterile]').val();
					var modifysterile=correction5*scaleup5*sterile;					
					$('input:text[id=modifysterile]').val(modifysterile);
							});
							
							$('#vasectomyscaleup,#vasectomycorrection').keyup(function() {
					var scaleup6=$('input:[id=vasectomyscaleup]').val();
					var correction6=$('input:[id=vasectomycorrection]').val();
					var vasectomy=$('input:[id=vasectomy]').val();
					var modifyv=correction6*scaleup6vasectomy;					
					$('input:text[id=modifyvasectomy]').val(modifyv);
							});
							
							$('#nfpscaleup,#nfpcorrection').keyup(function() {
					var scaleup7=$('input:[id=nfpscaleup]').val();
					var correction7=$('input:[id=nfpcorrection]').val();
					var nfp=$('input:[id=NFP]').val();
					var modifynfp=correction7*scaleup7*nfp;					
					$('input:text[id=modifynfp]').val(modifynfp);
							});
							$('#otherscaleup,#othercorrection').keyup(function() {
					var scaleup8=$('input:[id=otherscaleup]').val();
					var correction8=$('input:[id=othercorrection]').val();
					var others=$('input:[id=Others]').val();
					var modifynfp=correction8*scaleup8*others;					
					$('input:text[id=modifyothers]').val(modifynfp);
							});
							
							$('#condomsscaleup,#condomscorrection').keyup(function() {
					var scaleup9=$('input:[id=condomsscaleup]').val();
					var correction9=$('input:[id=condomscorrection]').val();
					var condoms=$('input:[id=condoms]').val();
					var modifycondoms=correction9*scaleup9*condoms*120;					
					$('input:text[id=modifyothers]').val(modifycondoms);
							});
						});
					
					
</script>





	<table class="table table-striped table-hover">
	<th class="success" colspan="14" style="height: 2em; text-align: center; font-size: 1.5em"> Family Planning Forecast(By County)</th>	
	
	<tr class="danger">
		<th><strong>County</strong></th>
		
		
		<th><strong>FP Commodity</strong></th>
		<th><strong>No Clients</strong></th>
		<th><strong>Scale Up/Down</strong></th>
		<th><strong>Correction</strong></th>
		<th><strong>Requirement(1)</strong></th>
		<th><strong>Requirement(Modified)</strong></th>
		
	</tr><tbody style="text-align: center;">
		<?php 
		foreach ($result as $value) {
			
			
						?>
						<tr >
							
							<td rowspan="10"><h3><?php echo $value['county'];?></h3></td>
							
							<td>FP Injections</td>
							<td><input type="text" readonly="readonly" value="<?php echo round(($value['FP_injections']/4));?>" id="clientNofp"/></td>
							<td><input type="text"  value="1.1" id="fpscaleup"/></td>
							<td><input type="text"  value="1.25" id="fpcorrection"/></td>
							<td><?php echo round(($value['FP_injections'])*1.05*1.1*1.25);?> <input type="hidden" value="<?php echo round($value['FP_injections']);?>" id="fptotal"/> </td>
							<td><input type="text"  value="" id="modifiedfprq"/> </td>
													
							
						</tr>
						<tr>
							
							
							
							<td>Pills Microlut</td>
							<td><input type="text" readonly="readonly" value="<?php echo round(($value['Pills_Microlut']/12));?>" id="clientNopm1"/></td>
							<td><input type="text"  value="1.1" id="pillmitscaleup"/></td>
							<td><input type="text"  value="1.25" id="pillmitcorrection"/></td>
							<td><?php echo round(($value['Pills_Microlut'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifiedpmrq1"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>Pills Microgynon</td>
							<td><input type="text" readonly="readonly" value="<?php echo round(($value['Pills_Microgynon']/12));?>" id="clientNopm2"/></td>
							<td><input type="text"  value="1.1" id="pillmgnscaleup"/></td>
							<td><input type="text"  value="1.25" id="pillmgncorrection"/></td>
							<td><?php echo round(($value['Pills_Microgynon'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifiedpmgn"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>IUCD insertion</td>
							<td><input type="text" readonly="readonly" value="<?php echo $value['IUCD_insertion'];?>" id="clientNoiucd"/></td>
							<td><input type="text"  value="1.1" id="IUCDscaleup"/></td>
							<td><input type="text"  value="1.25" id="IUCDcorrection"/></td>
							<td><?php echo round(($value['IUCD_insertion'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="IUCD"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>Implants insertion</td>
							<td><input type="text" readonly="readonly" value="<?php echo $value['Implants_insertion'];?> " id="implants"/></td>
							<td><input type="text"  value="1.1" id="implantsscaleup"/></td>
							<td><input type="text"  value="1.25" id="implantscorrection"/></td>
							<td><?php echo round(($value['Implants_insertion'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifyimplants"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>Sterilization BTL</td>
							<td><input type="text" readonly="readonly" value="<?php echo $value['Sterilization_BTL'];?>" id="sterile"/></td>
							<td><input type="text"  value="1.1" id="sterilescaleup"/></td>
							<td><input type="text"  value="1.25" id="sterilecorrection"/></td>
							<td><?php echo round(($value['Sterilization_BTL'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifysterile"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>Sterilize Vasectomy</td>
							<td><input type="text" readonly="readonly" value="<?php echo $value['Steriliz_Vasectomy'];?>"  id="vasectomy"/></td>
							<td><input type="text"  value="1.1" id="vasectomyscaleup"/></td>
							<td><input type="text"  value="1.25" id="vasectomycorrection"/></td>
							<td><?php echo round(($value['Steriliz_Vasectomy'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifyvasectomy"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>NFP</td>
							<td><input type="text" readonly="readonly" value="<?php echo $value['NFP'];?>" id="NFP"/> </td>
							<td><input type="text"  value="1.1" id="nfpscaleup"/></td>
							<td><input type="text"  value="1.25" id="nfpcorrection"/></td>
							<td><?php echo round(($value['NFP'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifynfp"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>Others FP</td>
							<td><input type="text" readonly="readonly" value="<?php echo $value['All_others_FP'];?> " id="Others"/></td>
							<td><input type="text"  value="1.1"  id="otherscaleup"/></td>
							<td><input type="text"  value="1.25" id="othercorrection"/></td>
							<td><?php echo round(($value['All_others_FP'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifyothers"/> </td>
													
							
						</tr>
						<tr>
							
							
							<td>Clints condom</td>
							<td><input type="text" readonly="readonly" value="<?php echo $value['Clints_condom']/120;?>" id="condoms"/> </td>
							<td><input type="text"  value="1.1" id="condomsscaleup"/></td>
							<td><input type="text"  value="1.25" id="condomscorrection"/></td>
							<td><?php echo round(($value['Clints_condom'])*1.05*1.1*1.25);?>  </td>
							<td><input type="text"  value="" id="modifycondoms"/> </td>
													
							
						</tr>
					
		</tbody>
		
			 <?php }
		?>
</table>
	
	
	
	
	