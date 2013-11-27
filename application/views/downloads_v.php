<style>

.downloads{
	width:80%;
	margin:auto;
	
}
.accordion-heading a{
		background: #29527b; /* Old browsers */
		color: #fff;
		text-decoration:none;
		font-size:15px;
		
	}
	ul a {
		font-size:14px;
	}
</style>
<script>

$(document).ready(function() {
	$(function() {
	$(".collapse").collapse()
	$('#myTab a').click(function (e) {
 		 e.preventDefault();
 			 $(this).tab('show');
})
$( ".dateclass" ).datepicker({
			showAnim:'drop',
			dateFormat: 'd M yy', 
			
		});	
		
	});
	});
	
</script>

<div class="downloads">
	<div class="panel-group" id="accordion">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Service Statistics
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          Commodities
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
      	    <ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#home">2 Pager</a></li>
  <li><a href="#profile">Supply Plan</a></li>
  
		</ul>
 
<div class="tab-content">
  <div class="tab-pane active" id="home">
  	<?php 
    $att=array("name"=>'','id'=>'',"class"=>'form-horizontal');
	 echo form_open('reports/getstock_summary',$att); ?>
  	<div id="" class=" " style="max-height:50em;">
		
        <div class="form-horizontal">
    	
  <div class="control-group">
    <label class="control-label" for="monthdownload">Date as Of</label>
    <div class="controls">
      <input class="span2 dateclass" type="text" placeholder="Date as of" id="dateas_of" name="dateas_of">
    </div>
  </div>
  
  
  <div class="control-group">
    <div class="controls">
      
      <button type="submit" class="btn download">Download</button>
    </div>
  </div>
</div>
      
      </div>
      <?php 
echo form_close();
?>
  </div>
  <div class="tab-pane" id="profile">asdasd</div>
  
</div>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>

