<?php
if (!$this -> session -> userdata('user_id')) {
	redirect("user_management/login");
}
if (!isset($link)) {
	$link = null;
}
if (!isset($quick_link)) {
	$quick_link = null;
}
$access_level = $this -> session -> userdata('user_indicator');

$user_is_super = false;
$user_is_demo = false;

$user_is_super_admin = false;


if ($access_level == "user") {
	$user_is_demo = true; 
	
}

if ($access_level == "Super_admin") {
	$user_is_super = true;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
	<link href="<?php echo base_url().'assets/css/style.css'?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo base_url().'assets/metro-bootstrap/docs/font-awesome.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/css/bootstrap.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?php echo base_url().'assets/css/bootstrap-responsive.css'?>" type="text/css" rel="stylesheet"/>
	<script src="<?php echo base_url().'assets/scripts/jquery.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/jquery-1.8.0.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/highcharts.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/exporting.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/metro-bootstrap/docs/bootstrap.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/alert.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/affix.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/popover.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/scrollspy.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/collapse.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/jquery-ui.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/jquery.form.js'?>" type="text/javascript"></script>		
	<script src="<?php echo base_url().'assets/scripts/validator.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/scripts/jquery.validate.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/metro-bootstrap/docs/application.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/metro-bootstrap/docs/jquery.validate.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/metro-bootstrap/docs/jquery.validate.unobtrusive.js'?>" type="text/javascript"></script>
	<script src="<?php echo base_url().'assets/metro-bootstrap/docs/jquery.unobtrusive-ajax.js'?>" type="text/javascript"></script>

<!--<script src="http://code.highcharts.com/highcharts-more.js"></script>-->

<script type="text/javascript">

	
	
</script>
</head>
 
<body>


	<div id="header_container" class="" id="top-panel" style="margin-bottom: 0px" >
      

	

		<div class="banner_logo">
			<a class="logo" href="<?php echo base_url();?>" ></a> 
		</div>

				<div id="logo_text">
					<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Ministry of Health</span>
					<span style="display: block; font-size: 12px;">Division Of Reproductive Health(DRH)</span>	
				</div>
				<?php $facility = $this -> session -> userdata('news'); ?>
<div id="main_menu"> 

 	<nav id="navigate">
<ul>
 	
<?php
if($user_is_super){
?>
<li class=""><a  href="<?php echo base_url(); ?>home_controller">Service Statistics</a></li>
 	 
<!--<li><a  href="<?php echo base_url(); ?>fp_management/pipeline" class="">Stock Management</a></li>-->
<li><a  href="<?php echo base_url(); ?>fp_management/" class="">Commodities</a></li>
<li><a  href="<?php echo base_url(); ?>reports" class="">Downloads</a></li>
<li><a  href="<?php echo base_url(); ?>settings" class="">Settings</a></li>
<?php } elseif ($user_is_demo) { ?>
<li class=""><a  href="<?php echo base_url(); ?>home_controller">Service Statistics</a></li>
<li><a  href="<?php echo base_url(); ?>fp_management/" class="">Commodities</a></li>
<li><a  href="<?php echo base_url(); ?>reports" class="">Downloads</a></li>
<?php }  ?>

</ul>
</nav>

</div>

<div class="btn-group " id="btnlogout">
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-user icon-white"></i> <?php echo $this -> session -> userdata('names'); ?> <?php echo $this -> session -> userdata('inames'); ?><span style="margin-left: 0.3em;" class="caret"></span></a>
  
  <ul class="dropdown-menu" style="font:#FFF;">
    <li><a href="#"><i class="icon-pencil"></i> Edit Settings</a></li>
    <li><a href="#myModal" data-toggle="modal" data-target="#myModal" id="changepswd" ><i class="icon-edit"></i> Change password</a></li>
    
    
    <li class="divider"></li>
    <li><a href="<?php echo base_url(); ?>user_management/logout"><i class=" icon-off"></i> Log Out</a></li>
  </ul>
</div>
				
	</div>
	<div>
	<div class="divide" >
	
    			<div   id="banner_text">
      				<?php echo  $banner_text; ?>
            			    				</div>
    				
    				<div  id="system_alerts">
      				<?php $flash_success_data = NULL;
					      $flash_error_data = NULL;
	                      $flash_success_data = $this -> session -> flashdata('system_success_message');
						  $flash_error_data = $this -> session -> flashdata('system_error_message');
							if ($flash_success_data != NULL) {
							echo '<div class="alert alert-success alert-dismissable" >
							<button type="button" class=" close" data-dismiss="alert" aria-hidden="true">×</button>' . $flash_success_data . '</div>';
						   } elseif ($flash_error_data != NULL) {
							echo '<div class="alert alert-danger alert-dismissable" >
							<button type="button" class=" close" data-dismiss="alert" aria-hidden="true">×</button>' . $flash_error_data . '</div>';
							}
 						?>
    				</div>
    				
  				
  				</div>




 <div id="inner_wrapper"> 
 		
	<?php $this -> load -> view($content_view); ?>
<!-- end inner wrapper -->

  <!--End Wrapper div-->
    
    
 </div>
 </div>
    <div id="bottom_ribbon"><div id="footer"><?php $this -> load -> view("footer");?></div></div>

	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
		
			
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel">Change Password</h3>
    <div id="errsummary" style=""></div>
  </div>
  
  <form class="form-horizontal" action="<?php echo base_url().'User_Management/save_new_password'?>" method="post" id="change">
  <div class="control-group" style="margin-top: 1em;">
    <label class="control-label" for="inputPassword">Old Password</label>
    <div class="controls">
      <input type="password" id="old_password"  name="old_password" placeholder="Old Password" required="required"><span class="error" id="err" style="margin-left: 0.2em;font-size: 10px"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">New Password</label>
    <div class="controls">
      <input type="password" id="new_password" name="new_password" placeholder="New Password" required="required"><span class="error" id="result" style="margin-left: 0.2em;font-size: 10px"></span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Confirm Password</label>
    <div class="controls">
      <input type="password" id="new_password_confirm" name="new_password_confirm" placeholder="Confirm Password" required="required"><span class="error" id="confirmerror" style="margin-left: 0.2em;font-size: 10px"></span>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-primary" id="changepsaction" name="changepsaction">Change Password</button>
    <div class="error"></div>
  </div>


</div>
</form>
<?php
	echo form_close();
		?>
		


</body>
<script>
	$(document).ready(function() {
		
		//enables bootstrap alerts dismiss
		$(".alert").alert()
		

		$('#new_password').keyup(function() {
			$('#result').html(checkStrength($('#new_password').val()))
		})
		$('#new_password_confirm').keyup(function() {
			var newps = $('#new_password').val()
			var newpsconfirm = $('#new_password_confirm').val()
			
			if(newps!= newpsconfirm){
						
						 $('#confirmerror').html('Your passwords dont match');
						
							}else{
								
								$("#confirmerror").empty();
								$('#confirmerror').html('Your passwords match');
								$('#confirmerror').removeClass('error');
								$('#confirmerror').addClass('successtext')
								
								
							}
		})
		function checkStrength(password) {

			//initial strength
			var strength = 0

			//if the password length is less than 6, return message.
			if (password.length < 6) {
				$('#result').removeClass()
				$('#result').addClass('short')
				return 'Too short'
			}

			//length is ok, lets continue.

			//if length is 8 characters or more, increase strength value
			if (password.length > 7)
				strength += 1

			//if password contains both lower and uppercase characters, increase strength value
			if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
				strength += 1

			//if it has numbers and characters, increase strength value
			if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))
				strength += 1

			//if it has one special character, increase strength value
			if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))
				strength += 1

			//if it has two special characters, increase strength value
			if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/))
				strength += 1

			//now we have calculated strength value, we can return messages

			//if value is less than 2
			if (strength < 2) {
				$('#result').removeClass()
				$('#result').addClass('weak')
				$("#result").css("color","#BE2E21")
				return 'Weak'
			} else if (strength == 2) {
				$('#result').removeClass()
				$('#result').addClass('good')
				$("#result").css("color","#006633")
				
				return 'Good'
			} else {
				$('#result').removeClass()
				$('#result').addClass('strong')
				$("#result").css("color","#003300")
				return 'Strong'
			}
		}


		$('#change').submit(function(){
			
			 $.ajax({
	            type: $('#change').attr('method'),

	            	url:$('#change').attr('action'),
					cache:"false",
					data:$('#change').serialize(),
					dataType:'json',
					beforeSend:function(){
						 $("#err").html("Processing...");
					},
					complete:function(){
						
					},
					success: function(data){
						//alert(data.response);
					if(data.response=='false'){
						
						 $('#err').html(data.msg);
						
							}else if(data.response=='true'){
								$("#err").empty();
								
								window.location="<?php echo base_url();?>";
								
							}

						}
	
							
	});

	return false;
	});
		});

</script>

</html>
