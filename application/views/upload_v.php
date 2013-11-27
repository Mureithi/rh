<?php $facility=$this -> session -> userdata('news');
$access_level = $this -> session -> userdata('user_indicator');
?>
<style>
	
	
</style>

		    <div class="">
	      		
		
		
		<?php echo form_open_multipart('Upload_Management/upload_csv');?>
		<div class="upload_form">
			
			<input type="file" name="file" class="btn btn-success"  />
			<input name="btn_save" class="btn btn-primary" type="submit"  value="Upload" />	
		</div>
		
		
			</div>	
		
	

