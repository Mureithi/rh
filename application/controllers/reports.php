<?php
class Reports extends MY_Controller {

function __construct() {
	parent::__construct();
	$this -> load -> helper(array('form', 'url' ));
}

public function index() {
			
		$data['content_view'] = "downloads_v";
		$data['title'] = "Downloads";
		$data['banner_text'] = "Downloads";
		//$data['soh'] = Pipeline::getid_soh($fpid);
		$this -> load -> view("template", $data);
			}


			
public function getstock_summary(){
		
		$dateof=$_POST['dateas_of'];
			
		$date_of=date('Y-m-d',strtotime($dateof));
		$split_date=explode('-', $date_of);
		$year=$split_date[0];
		$month=$split_date[1];
		$day=$split_date[2];
		//echo $day.'-'.$month.'-'.$year;
		$date_now=date('Y-m-d',strtotime($year.'-'.$month.'-'.$day)); 
		$date_next=date('Y-m-d',strtotime(($year+2).'-'.$month.'-'.$day));
		//exit;
			$split_date2=explode('-', $date_now);
			$month2=$split_date2[1];
			
		if ($month2 >= 7) {
			$year1=$year+1;
			$fyear=$year.'-'.$year1;
			
		} else {
			$year1=$year-1;
			 $fyear=$year.'-'.$year1;
			
		}
		
	
		$report_name='Family Planning Commodities ';
		$report = Pipeline::getsummary_monthly($date_now,$month,$year);
		$report2 = Pipeline::getsummary_plan($fyear);
		
		
		$finaldate=$date_now;
		$as_at = date('F, Y ', strtotime($finaldate));
		
		$title='DRH';
		
			
											/**************************************set the style for the table****************************************/

$html_data='<style>table {
  max-width: 100%;
  background-color: transparent;
  border-collapse: collapse;
  border-spacing: 0;
}

.table {
  width: 100%;
  margin-bottom: 20px;
}

.table th,
.table td {
  padding: 8px;
  line-height: 20px;
  text-align: left;
  vertical-align: top;
  border-top: 1px solid #dddddd;
}

.table th {
  font-weight: bold;
}

.table thead th {
  vertical-align: bottom;
}

.table caption + thead tr:first-child th,
.table caption + thead tr:first-child td,
.table colgroup + thead tr:first-child th,
.table colgroup + thead tr:first-child td,
.table thead:first-child tr:first-child th,
.table thead:first-child tr:first-child td {
  border-top: 0;
}

.table tbody + tbody {
  border-top: 2px solid #dddddd;
}

.table .table {
  background-color: #ffffff;
}

.table-condensed th,
.table-condensed td {
  padding: 4px 5px;
}

.table-bordered {
  border: 1px solid #dddddd;
  border-collapse: separate;
  *border-collapse: collapse;
  border-left: 0;
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}

.table-bordered th,
.table-bordered td {
  border-left: 1px solid #dddddd;
}

.table-bordered caption + thead tr:first-child th,
.table-bordered caption + tbody tr:first-child th,
.table-bordered caption + tbody tr:first-child td,
.table-bordered colgroup + thead tr:first-child th,
.table-bordered colgroup + tbody tr:first-child th,
.table-bordered colgroup + tbody tr:first-child td,
.table-bordered thead:first-child tr:first-child th,
.table-bordered tbody:first-child tr:first-child th,
.table-bordered tbody:first-child tr:first-child td {
  border-top: 0;
}

.table-bordered thead:first-child tr:first-child > th:first-child,
.table-bordered tbody:first-child tr:first-child > td:first-child,
.table-bordered tbody:first-child tr:first-child > th:first-child {
  -webkit-border-top-left-radius: 4px;
          border-top-left-radius: 4px;
  -moz-border-radius-topleft: 4px;
}

.table-bordered thead:first-child tr:first-child > th:last-child,
.table-bordered tbody:first-child tr:first-child > td:last-child,
.table-bordered tbody:first-child tr:first-child > th:last-child {
  -webkit-border-top-right-radius: 4px;
          border-top-right-radius: 4px;
  -moz-border-radius-topright: 4px;
}

.table-bordered thead:last-child tr:last-child > th:first-child,
.table-bordered tbody:last-child tr:last-child > td:first-child,
.table-bordered tbody:last-child tr:last-child > th:first-child,
.table-bordered tfoot:last-child tr:last-child > td:first-child,
.table-bordered tfoot:last-child tr:last-child > th:first-child {
  -webkit-border-bottom-left-radius: 4px;
          border-bottom-left-radius: 4px;
  -moz-border-radius-bottomleft: 4px;
}

.table-bordered thead:last-child tr:last-child > th:last-child,
.table-bordered tbody:last-child tr:last-child > td:last-child,
.table-bordered tbody:last-child tr:last-child > th:last-child,
.table-bordered tfoot:last-child tr:last-child > td:last-child,
.table-bordered tfoot:last-child tr:last-child > th:last-child {
  -webkit-border-bottom-right-radius: 4px;
          border-bottom-right-radius: 4px;
  -moz-border-radius-bottomright: 4px;
}

.table-bordered tfoot + tbody:last-child tr:last-child td:first-child {
  -webkit-border-bottom-left-radius: 0;
          border-bottom-left-radius: 0;
  -moz-border-radius-bottomleft: 0;
}

.table-bordered tfoot + tbody:last-child tr:last-child td:last-child {
  -webkit-border-bottom-right-radius: 0;
          border-bottom-right-radius: 0;
  -moz-border-radius-bottomright: 0;
}

.table-bordered caption + thead tr:first-child th:first-child,
.table-bordered caption + tbody tr:first-child td:first-child,
.table-bordered colgroup + thead tr:first-child th:first-child,
.table-bordered colgroup + tbody tr:first-child td:first-child {
  -webkit-border-top-left-radius: 4px;
          border-top-left-radius: 4px;
  -moz-border-radius-topleft: 4px;
}

.table-bordered caption + thead tr:first-child th:last-child,
.table-bordered caption + tbody tr:first-child td:last-child,
.table-bordered colgroup + thead tr:first-child th:last-child,
.table-bordered colgroup + tbody tr:first-child td:last-child {
  -webkit-border-top-right-radius: 4px;
          border-top-right-radius: 4px;
  -moz-border-radius-topright: 4px;
}

.table-striped tbody > tr:nth-child(odd) > td,
.table-striped tbody > tr:nth-child(odd) > th {
  background-color: #f9f9f9;
}

.table-hover tbody tr:hover > td,
.table-hover tbody tr:hover > th {
  background-color: #f5f5f5;
}

table td[class*="span"],
table th[class*="span"],
.row-fluid table td[class*="span"],
.row-fluid table th[class*="span"] {
  display: table-cell;
  float: none;
  margin-left: 0;
}

.table td.span1,
.table th.span1 {
  float: none;
  width: 44px;
  margin-left: 0;
}

.table td.span2,
.table th.span2 {
  float: none;
  width: 124px;
  margin-left: 0;
}

.table td.span3,
.table th.span3 {
  float: none;
  width: 204px;
  margin-left: 0;
}

.table td.span4,
.table th.span4 {
  float: none;
  width: 284px;
  margin-left: 0;
}

.table td.span5,
.table th.span5 {
  float: none;
  width: 364px;
  margin-left: 0;
}

.table td.span6,
.table th.span6 {
  float: none;
  width: 444px;
  margin-left: 0;
}

.table td.span7,
.table th.span7 {
  float: none;
  width: 524px;
  margin-left: 0;
}

.table td.span8,
.table th.span8 {
  float: none;
  width: 604px;
  margin-left: 0;
}

.table td.span9,
.table th.span9 {
  float: none;
  width: 684px;
  margin-left: 0;
}

.table td.span10,
.table th.span10 {
  float: none;
  width: 764px;
  margin-left: 0;
}

.table td.span11,
.table th.span11 {
  float: none;
  width: 844px;
  margin-left: 0;
}

.table td.span12,
.table th.span12 {
  float: none;
  width: 924px;
  margin-left: 0;
}

.table tbody tr.success > td {
  background-color: #dff0d8;
}

.table tbody tr.error > td {
  background-color: #f2dede;
}

.table tbody tr.warning > td {
  background-color: #fcf8e3;
}

.table tbody tr.info > td {
  background-color: #d9edf7;
}

.table-hover tbody tr.success:hover > td {
  background-color: #d0e9c6;
}

.table-hover tbody tr.error:hover > td {
  background-color: #ebcccc;
}

.table-hover tbody tr.warning:hover > td {
  background-color: #faf2cc;
}

.table-hover tbody tr.info:hover > td {
  background-color: #c4e3f3;
}

[class^="icon-"],
[class*=" icon-"] {
  display: inline-block;
  width: 14px;
  height: 14px;
  margin-top: 1px;
  *margin-right: .3em;
  line-height: 14px;
  vertical-align: text-top;
  background-image: url("../Images/glyphicons-halflings.png");
  background-position: 14px 14px;
  background-repeat: no-repeat;
}</style>';


		$html_data1 ='';
		$html_data2 ='';	
		
		/*****************************setting up the report*******************************************/

$html_data1 .='

<table class="table table-bordered table-striped">

			<thead style="font-size: 13px; background: #C8D2E4 ">
			<tr>
			<th colspan="8">
			* SOH - Stock On Hand
			</th>
			</tr>
<tr>
		<th colspan="2"></th>
		<th colspan="2">SOH *</th>
		<th colspan="2">Pending Consignment</th>
		<th colspan="2">Received During Month</th>
</tr>	
		<tr>	
		<th width="17.5%">FP Commodity</th>
		<th width="7.5%">Unit</th>
		<th width="12.5%">KEMSA</th>
		<th width="12.5%" >PSI</th>
		<th width="12.5%">KEMSA</th>
		<th width="12.5%">PSI</th>
		<th width="12.5%">KEMSA </th>
		<th width="12.5%">PSI </th>
		</tr>
	</thead>';

/*******************************begin adding data to the report*****************************************/

	foreach($report as $val){
			
											
		 $html_data1 .='<tr><td>'.$val['fp_name'].'</td>
							<td>'.$val['Unit'].'</td>
							<td>'.number_format($val['SOHKEMSA']).'</td>
							<td>'.number_format($val['SOHPSI']).'</td>
							<td>'.number_format($val['PENDINGKEMSA']).'</td>
							<td >'.number_format($val['PENDINGPSI']).'</td>
							<td >'.number_format($val['RECEIVED_KEMSA']).'</td>
							<td>'.number_format($val['RECEIVED_PSI']).'</td>
							
							</tr>';

/***********************************************************************************************/
					
		  }
		$html_data1 .='</tbody><tfoot>
		<tr>
			<td colspan="8" style="font-size:10.5px; margin:4px;">Data sources: DRH,KEMSA,NASCOP,UNFPA,PSI,KfW,USAID,DELIVER,DFID</td>
			
		</tr>
		</tfoot></table>';

		
			$html_data .= $html_data1;
			
			$html_data2 .='<table class="table table-bordered table-striped">

			<thead style="font-size: 13px; background: #C8D2E4 ">
			<tr>
			<th colspan="11">
			Estimated Time Of Arrival Of Pending FP Consignments (Public Sector Pipeline)
			</th>
			<tr>
		<th>FP Commodity</th>
		<th>Unit</th>
		<th>Funding Source</th>
		<th>E.T.A Details</th>
		<th>Date Received</th>
		<th>Revised ETA</th>
		<th>No Days Delayed</th>
		<th>Quantity Expected</th>
		<th>Quantity Received</th>
		<th>Quantity Remaining</th>
		<th>Status</th>
		
	</tr>
	</thead>';

/*******************************begin adding data to the report*****************************************/

	foreach($report2 as $val){
			if ($val['date_receive']=='0000-00-00'||$val['date_receive']=='1970-01-01') {
								$receivedate=' - ';
							} else {
								$receivedate =date('F j, Y ', strtotime($val['date_receive']));
							}

if ($val['delay_to']=='0000-00-00'||$val['delay_to']=='1970-01-01') {
								$delaydate=' - ';
							} else {
								$delaydate= date('F j, Y ', strtotime($val['delay_to']));
							}
if ($val['delay_to']=='0000-00-00'||$val['delay_to']=='1970-01-01') {
								$Nodays= '0';
							} else {
								//echo date('F j, Y ', strtotime());
								$Nodays= (strtotime($val['delay_to']) - strtotime($val['fp_date']))/ (60 * 60 * 24).' '.'days';
								
							}
		if ($val['transaction_type']=='PENDINGKEMSA') {
								$status= '<button class="btn btn-mini btn-warning" id="" name="" >Pending</button>';
							} elseif($val['transaction_type']=='INCOUNTRY') {
								$status= '<button class="btn btn-mini btn-success" id="" name="" >Incountry- Not Cleared</button>';
							}elseif($val['transaction_type']=='DELAYED') {
								$status= '<button class="btn btn-mini btn-danger" id="" name="" >Delayed</button>';
							}elseif($val['transaction_type']=='RECEIVED') {
								$status= '<button class="btn btn-mini btn-danger" id="" name="" >Received</button>';
							}
											
		 $html_data2 .='<tr><td>'.$val['fp_name'].'</td>
							<td>'.$val['Unit'].'</td>
							<td>'.$val['funding_source'].'</td>
							<td>'.date('F j, Y ', strtotime($val['fp_date'])).'</td>
							<td>'.$receivedate.'</td>
							<td>'.$delaydate.'</td>
							<td>'.$Nodays.'</td>
							<td>'.number_format($val['fp_quantity']).'</td>
							<td>'.number_format($val['qty_receive']).'</td>
							<td>'.number_format($val['fp_quantity']-$val['qty_receive']).'</td>
							<td>'.$status.'</td>
							</tr>';

/***********************************************************************************************/
					
		  }
		$html_data2 .='</tbody><tfoot>
		<tr>
			<td colspan="11" style="font-size:10.5px; margin:4px;"></td>
			
		</tr>
		</tfoot></table>';

		
			$html_data .= $html_data2;
			
		
		//echo $html_data;
		//exit;
         
	  	$this->generatescc_pdf($report_name,$title,$html_data,$as_at);
		
				
			}
public function generatescc_pdf($report_name,$title,$html_data,$as_at)
{
		/********************************************setting the report title*********************/
			
		$html_title="<img src='".base_url()."Images/coat_of_arms.png' style='position:fixed; top:30px; right:5px; width:75px; '></img>
		<h2 style='text-align:center; font-size: 18px;'>Ministry Of Health</h2>
     	<span style='text-align:center;' >
       <h2 style='text-align:center; font-size: 15px;'>Division Of Reproductive Health</h2>
      
       <h2 style='text-align:center; font-size: 14px;'>Family Planning Commodities Stock Status Report For End of $as_at</h2>
      
       <hr />  ";
	   
	   $timestamp=date("F j, Y, g:i a");
		 			$stylesheet=base_url().'CSS/bootstrap.css';	
			
				///**********************************initializing the report **********************/
		//$stylesheet = file_get_contents($stylesheet);
            $this->load->library('mpdf');
           $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
		   $this->mpdf->SetHTMLHeader("<div align='right' style='padding-bottom:20px;'> $timestamp</div>") ;
		   $this->mpdf->SetHTMLFooter('<div align="right">{PAGENO}</div>') ;
           $this->mpdf->SetTitle($title);
           $this->mpdf->WriteHTML($html_title);
		    $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML('<br/>');
			$this->mpdf->WriteHTML($html_data);
			$report_name = $report_name.".pdf";
           $this->mpdf->Output($report_name,'D');
			
		
		
}
	}
	