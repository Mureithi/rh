<?php 
$selectedItem = '';

$current_year = date('Y');
$earliest_year = $current_year - 5;
$facility_Code=$this -> session -> userdata('news');	

?>
<style>
h3{
	margin: 0;
}
.label-success a{
	font:white;
	text-decoration:none;
}
.collapsible,
.page_collapsible,
.accordion {
    margin: 0;
    padding:5%;
    border-top:#f0f0f0 1px solid;
    background: #cccccc;
    font-size:0.8em ;
    text-decoration:none;
    text-transform:uppercase;
	background: #29527b; /* Old browsers */
    color: #fff; }
     
.accordion-open,
.collapse-open {
	background: #289909; /* Old browsers */    
    color: #fff; }
.accordion-open span,
.collapse-open span {
    display:block;
    float:right;
    padding:3%; }
.accordion-open span,
.collapse-open span {
    background:url('<?php echo base_url()?>assets/img/minus.jpg') center center no-repeat; }
.accordion-close span,
.collapse-close span {
    display:block;
    float:right;
    background:url('<?php echo base_url()?>assets/img/plus.jpg') center center no-repeat;
    padding:3%; }
div.container {
    width:auto;
    height:auto;
    padding:0;
    margin:0; }
div.content {
    background:#f0f0f0;
    margin: 0;
    padding:10px;
    font-size:.9em;
    line-height:1.5em;
    
div.content ul, div.content p {
    padding:0;
    margin:0;
    padding:3px; }
div.content ul li {
    list-style-position:inside;
    line-height:25px; }
div.content ul li a {
    color:#555555; }
code {
    overflow:auto; }
.accordion h3.collapse-open {}
.accordion h3.collapse-close {}
.accordion h3.collapse-open span {}
.accordion h3.collapse-close span {}




    
</style>
<script src="<?php echo base_url().'assets/scripts/accordion.js'?>" type="text/javascript"></script></script> 

<script type="text/javascript">
$(document).ready(function(){
	
     /* $(function() {
$("body").on({
    ajaxStart: function() { 
        $(this).addClass("loading"); 
    },
    ajaxStop: function() { 
        $(this).removeClass("loading"); 
    }    
});
});*/
        var div=".my_chart";
		var url = "<?php echo base_url()."statistics_controller/nationalpie"?>";
		request (url,div);
         
         $("#generatepie").click(function(){
         	
         	var div=".my_chart";
		var url = "<?php echo base_url()."statistics_controller/nationalpie"?>";
		request (url,div);
      
    });
  
    
   $("#generategraph").click(function(){
   	var div=".my_chart";
		var url = "<?php echo base_url()."statistics_controller/get_commodity_analyse"?>";
		request (url,div);
     
    });
  $("#generatecompare").click(function(){
  	var div=".my_chart";
		var url = "<?php echo base_url()."statistics_controller/get_commodity_perdistrict"?>";
		request (url,div);
	
     });
    
 $("#countyforecast").change(function() {
    var div=".my_chart";
		var url = "<?php echo base_url()."statistics_controller/forecastedit_county_v"?>";
		request (url,div);
	
    });
    $("#gettrend").click(function() {
    	
    	var div=".my_chart";
		var url = "<?php echo base_url()."statistics_controller/trend_analysis"?>";
		request (url,div);
    
     
    });
function request (url,div){
	var url =url;
	var loading_icon="<?php echo base_url().'assets/img/301.gif' ?>";
	 $.ajax({
          type: "POST",
          url: url,
          data: { 'getcommodity': $('#getcommodity').val(),'county': $('#county').val(),'countytrend': $('#countytrend').val(),'getcommoditytrend': $('#getcommoditytrend').val(),'year_from': $('#year_from').val(),'countyforecast': $('#countyforecast').val()},
          beforeSend: function() {
            $(div).html("");
            
             $(div).html("<img style='margin-left:45%;margin-top:18%;' src="+loading_icon+">");
            
          },
          success: function(msg) {
          $(div).html("");
            $(div).html(msg);           
          }
        });
         
}

});
</script>

<script>
json_obj = {
				"url" : "<?php echo base_url().'Images/calendar.gif';?>",
				};
	var baseUrl=json_obj.url;
    $(function() {
     $(document).ready(function() {
        //$('.accordion').accordion({defaultOpen: ''});
         //custom animation for open/close
    $.fn.slideFadeToggle = function(speed, easing, callback) {
        return this.animate({opacity: 'toggle', height: 'toggle'}, speed, easing, callback);
    };

    $('.accordion').accordion({
        defaultOpen: 'section1',
        cookieName: 'nav',
        speed: 'medium',
        animateOpen: function (elem, opts) { //replace the standard slideUp with custom function
            elem.next().slideFadeToggle(opts.speed);
        },
        animateClose: function (elem, opts) { //replace the standard slideDown with custom function
            elem.next().slideFadeToggle(opts.speed);
        }
    });
    $( "#datepicker" ).datepicker({
			showOn: "button",
			dateFormat: 'd M, yy', 
			buttonImage: baseUrl,
			buttonImageOnly: true
		});
    });
    
    
});

</script>
<div class="leftpanel">

<div class="dash_menu">
    
    
    <h3 class="accordion" id="section1" style="">National Data<span></span><h3>
<div class="container">
    <div class="content">
    	<button class="btn btn-primary" id="generatepie" style="margin-left:0.5%">Generate Pie</button>
    </div>
</div>

<h3 class="accordion" id="leadtime">Compare By County<span></span><h3>
<div class="container form-group">
    <div class="content">
    	<h2 style="margin-left:2% ;font-size: 0.9em">Click below to select County</h2>
      <select class="form-control" id="county" name="county" style="width: 60%; margin-left:2%;font-size: 0.8em ">
    <option>Select County</option>
		<?php 
		foreach ($county as $county1) {
			$id=$county1->id;
			$drug=$county1->county;
			?>
			<option value="<?php echo $id;?>"><?php echo $drug;?></option>
		<?php }
		?>
	</select>        
	<button class="btn btn-primary" id="generatecompare" style="margin-left:0.5% ;margin-top: 2%;">Generate</button>
    
    </div>
</div>

<h3 class="accordion" id="section3">Consumption By County<span></span><h3>
<div class="container form-group">
    <div class="content">
      <h2 style="margin-left:2% ;font-size: 0.9em">Click below to select FP Commodity</h2>
    	 <select class="form-control"  id="getcommodity" name="getcommodity" style="width: 70%; margin-left:2%;  ">
    <option>Select fp Commodity</option>
		<?php 
		foreach ($commodity as $commodity1) {
			$id=$commodity1->identifier;
			$drug=$commodity1->fpcommodity_name;
			?>
			<option value="<?php echo $id;?>"><?php echo $drug;?></option>
		<?php }
		?>
	</select>        
	<button class="btn btn-primary" id="generategraph" style="margin-left:0.5%;margin-top: 2%;">Generate</button>
    
    </div>
</div>

<h3 class="accordion" id="section4">Forecast<span></span><h3>
<div class="container form-group">
    <div class="content">
       <h2 style="margin-left:2% ;font-size: 0.9em">Click below to select County</h2>
      <select class="form-control" id="countyforecast" name="countyforecast" style="width: 60%; margin-left:2%; ">
    <option>Select County</option>
		<?php 
		foreach ($county as $county2) {
			$id=$county2->id;
			$drug=$county2->county;
			?>
			<option value="<?php echo $id;?>"><?php echo $drug;?></option>
		<?php }
		?>
	</select>  
    </div>
</div>

<h3 class="accordion" id="section4">Consumption Trends<span></span><h3>
<div class="container form-group" >
    <div class="content">
       <h2 style="margin-left:2% ;font-size: 0.9em">Click below to select County</h2>
      <select class="form-control" id="countytrend" name="countytrend" style="width: 60%; margin-left:2% ;">
    <option>Select County</option>
		<?php 
		foreach ($county as $county3) {
			$id=$county3->id;
			$drug=$county3->county;
			?>
			<option value="<?php echo $id;?>"><?php echo $drug;?></option>
		<?php }
		?>
		
	</select>
	<select class="form-control" id="getcommoditytrend" name="getcommoditytrend" style="width: 70%; margin-left:2% ; margin-top: 2%;">
    <option>Select fp Commodity</option>
		<?php 
		foreach ($commodity as $commodity) {
			$id=$commodity->identifier;
			$drug=$commodity->fpcommodity_name;
			?>
			<option value="<?php echo $id;?>"><?php echo $drug;?></option>
		<?php }
		?>
	</select>
	<select class="form-control" name="year_from" id="year_from" style="margin-top: 2%;margin-left:2% ;width: 60%;">
			<?php
for($x=$current_year;$x>=$earliest_year;$x--){
			?>
			<option value="<?php echo $x+1;?>"
			<?php
			if ($x == $current_year) {echo "selected";
			}
			?>><?php echo $x+1;?></option>
			<?php }?>
		</select>
		<button class="btn btn-primary" id="gettrend" style="margin-left:8%; margin-top: 1%;">Get trend</button>  
    </div>
</div>

</div><!--End div for the dashboard side menu!-->

<div class="panel panel-info">
	<div class="panel-heading">
		<h4 class="panel-title">Quick Access</h4>
	</div>
  <div class="panel-body">
   
		<h3 ><span class="label label-success" style="font-size: 60%;">
			<span class="glyphicon glyphicon-upload"></span>&nbsp;<a style="color: white" href="<?php echo site_url('Upload_Management/');?>">Upload CSV</a></span></h3>
		
  </div>
  <div class="panel-footer"></div>
</div>
</div>


<div class="dash_main" id = "dash_main">
<div class="my_chart well well-lg" style="background-color: white;">
		
		
	</div>	
</div>

