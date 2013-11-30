 <?php
$current_year = date('Y');
$earliest_year = $current_year - 4;
$current_month = date('n');

$montharray = array(1 => 'January',  2 => 'February',  3 => 'March',  4 => 'April',  5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

?>
<style>
.dash_contain{
	width: 100%;
	height:auto;
	border: 1px solid #036;	
}
#sub-menu{
	width: 12%;
	height:20em;
	border: 1px solid #036;
	display:inline-block;
	vertical-align: top;
	margin: auto;	
}
#c_dashboard{
	width: 86%;
	height:50em;
	border: 1px solid #036;
	display:inline-block;
	vertical-align: top;
	margin: auto;	
}

	
</style>

	<div class="dash_contain">
<div id="sub-menu">
	<?php
if($indicator=='Super_admin'){
?>
<a class="btn btn-primary " href="<?php echo base_url(); ?>fp_management/soh_home">Enter Stocks on Hand</a>
<a class="btn btn-primary " href="<?php echo base_url(); ?>fp_management/editsupply_plan">Update Supply Plan</a>
<a class="btn btn-primary " href="<?php echo base_url(); ?>fp_management/soh_detailed">Detailed SOH</a>
<button class="btn btn-primary" id="" name="" data-toggle="modal" data-target="#supplyplanModal">View Supply Plan</button>
<?php } elseif ($indicator== "facility" || $indicator == "fac_user") { ?>
<a class="btn btn-primary " href="<?php echo base_url(); ?>fp_management/soh_detailed">Detailed SOH</a>
<button class="btn btn-primary" id="" name="" data-toggle="modal" data-target="#supplyplanModal">View Supply Plan</button>
<?php }  ?>

            </div>
            
<div id="c_dashboard"></div>
            
            
  </div>          