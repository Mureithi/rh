<?php
class Fp_management extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> helper(array('form', 'url'));
		ini_set("max_execution_time", "1000000");
		//ini_set("upload_max_filesize", "500000000");
		ini_set("memory_limit", '2048M');
		
	}

	public function index() {

		$this -> pipeline();
	}

	public function pipeline() {

		
		$data['title'] = "Pipeline";
		$data['content_view'] = "commodities_v";
		$data['banner_text'] = "Family Planning Stock Status";
		$data['indicator'] = $this -> session -> userdata('user_indicator');
		
		$this -> load -> view("template", $data);
	}

	public function edit_transaction($trid) {
		
		$data['content_view'] = "edit_v";
		$data['title'] = "Edit";
		$data['banner_text'] = "Edit Supply Plan";
		$data['editdata'] = Pipeline::getAll_edit($trid);
		$this -> load -> view("template", $data);

	}
	public function update_transaction() {
		$action=$_POST['action'];
		$store=$_POST['storeid'];
		$cancel_date=$_POST['cancel_date'];	
		$trid=$_POST['trid'];		
	    $Receive=$_POST['receive'];
		$qtyReceive=$_POST['qtyReceive'];
		$receive_wait=$_POST['receive_wait'];
		$qty_incountry=$_POST['qty_incountry'];
		$delay=$_POST['delay'];
		$comment=$_POST['comment'];
		$cancel_date=date('Y-m-d',strtotime($cancel_date));
		$date_incountry=date('Y-m-d',strtotime($receive_wait));
		$receivedate=date('Y-m-d',strtotime($Receive));
		$delaydate=date('Y-m-d',strtotime($delay));
		
		if ($store=='1') {
			if ($action==1) {
			$updateaction='INCOUNTRY';
			
		}elseif ($action==2) {
			 $updateaction='RECEIVED';
			
		}elseif ($action==3) {
			 $updateaction='DELAYED';
			
		}elseif ($action==4) {
			 $updateaction='CANCELED';
			
		}
		
		} elseif($store=='2') {
			if ($action==1) {
			$updateaction='INCOUNTRYPSI';
			
		}elseif ($action==2) {
			 $updateaction='RECEIVEDPSI';
			
		}elseif ($action==3) {
			 $updateaction='DELAYEDPSI';
			
		}elseif ($action==4) {
			 $updateaction='CANCELEDPSI';
			
		}
		}
		
		
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute( " UPDATE  `drh`.`pipeline` SET  `date_receive` =  '$receivedate', `qty_receive` = '$qtyReceive',
		`transaction_type`='$updateaction' ,`delay_to` = '$delaydate', `cancel_date`='$cancel_date',`comment` = '$comment',`date_incountry` = '$date_incountry', `qty_incountry` = '$qty_incountry' WHERE  `pipeline`.`id` ='$trid'; ");
		
			//exit;
		$this->session->set_flashdata('system_success_message', "Transaction Updated");
		redirect('fp_management/editSupply_plan');

	}
	
	public function Supply_plan() {

		$data['content_view'] = "new_consignment_v";
		$data['title'] = "New Supply Plan";
		$data['banner_text'] = "Edit Supply Plan";
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline_management::get_supplyplan();
		$data['fundingsource'] = Funding_source::getAllfpfundingsources();
		$this -> load -> view("template", $data);

	}
	public function soh_home() {

		$data['content_view'] = "soh_v";
		$data['title'] = "New SOH";
		$data['banner_text'] = "New SOH";
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline_management::get_supplyplan();
		$data['fundingsource'] = Funding_source::getAllfpfundingsources();
		$this -> load -> view("template", $data);

	}


	public function editsupply_plan() {

		$data['content_view'] = "edit_supplyplan_v";
		$data['title'] = "Edit Supply Plan";
		$data['banner_text'] = "Edit Supply Plan";
		$data['fundingsource'] = Funding_source::getAllfpfundingsources();
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline::get_supply_plan();
		$this -> load -> view("template", $data);

	}
	public function pending_psi() {

		$data['content_view'] = "psi_plan_v";
		$data['title'] = "Add pending Kemsa";
		$data['banner_text'] = "Add pending PSI";
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline::get_supply_plan();
		$this -> load -> view("template", $data);

	}
	public function supply_plan_filter() {
		
		 $fpids=$_POST['commoditychange'];		
	    $funding_source=$_POST['funding_source'];
	   	$datefrom=$_POST['datefrom'];
		$datefinal=date('y-m-d',strtotime($datefrom));
		$data['banner_text'] = "Edit Supply Plan";
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline::supply_plan_filter($datefinal,$fpids,$funding_source);
		$this -> load -> view("ajax_view/filtered_plan", $data);

	}
public function soh_detailed() {
	   
		$year_from=date('Y');		
	    $month=date('n');
		$store='SOH';
		$data['kemsa_psi'] = Pipeline::soh_kemsa_psi($year_from,$month,$store);
		$data['mycount'] = count(Pipeline::soh_kemsa_psi($year_from,$month,$store));
		$data['content_view'] = "soh_detailed";
		$data['title'] = "SOH";
		$data['banner_text'] = "SOH";
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline::soh_kemsa_psi($year_from,$month,$store);;
		$this -> load -> view("template", $data);	
		//}
		
		

	}

public function soh_filtered() {

		$year_from=$_POST['year_from'];		
	    $month=$_POST['month'];
		$store=$_POST['store'];
		$data['kemsa_psi'] = Pipeline::soh_kemsa_psi($year_from,$month,$store);
		$mycount=count(Pipeline::soh_kemsa_psi($year_from,$month,$store));
		
		if ($mycount==0) {
			echo "<div style='margin-left:50%;margin-top:5%;font-size:22px'>No Record for $month $year_from</>";
		} elseif($mycount>0) {
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline::get_supply_plan();
		$this -> load -> view("ajax_view/filter_soh", $data);

	}
}

	public function Supply_plan_vs_actual() {

		$data['content_view'] = "supplyplan_vs_actual";
		$data['title'] = "Supply Plan Vs Actual";
		$data['banner_text'] = "Supply Plan Vs Actual";
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline::get_supply_plan();
		$this -> load -> view("template", $data);

	}
	
		public function new_supplyplan()
	{
		
		$fpids=$_POST['pipecommodity'];		
	    $f_source=$_POST['funding_source'];
        $qty=$_POST['quantity'];
		$store=$_POST['store'];
		$procureA=$_POST['procureA'];
		$thedate=$_POST['etadetails'];
		
		
		
		 $j=sizeof ($fpids);
		
		
       $count=0;
	   
        for($me=0;$me<$j;$me++){
        	        	
			if ($qty[$me]>0) {
				$count++;
				if ($store[$me]==1) {
			$transaction_type='PENDINGKEMSA';	
		}elseif ($store[$me]==2) {
			$transaction_type='PENDINGPSI';	
		}
				$mydata = array('fpcommodity_Id' => $fpids[$me], 'funding_source'=>$f_source[$me],'store_id'=>$store[$me],'fp_quantity'=> $qty[$me] ,
				 'fp_date'=>date('y-m-d',strtotime($thedate[$me])),'procuring_agency'=>$procureA[$me],'pending_as_of'=>date('y-m-d'),'transaction_type'=>$transaction_type);
				
				$u = new Pipeline();

    			$u->fromArray($mydata);

    			$u->save();
				
			}
			
		}
        
		 $this->session->set_flashdata('system_success_message', "Your Supply Plan has been Populated");
		 redirect('fp_management/editSupply_plan');
		
	}
		
	public function new_soh()
	{
		
		$fpids=$_POST['actualcommodity'];		
	    $store=$_POST['store'];
        $actualqty=$_POST['actualqty'];
		$thedate=$_POST['dateofstock'];
		
		 $j=sizeof ($fpids);
		
       $count=0;
	   
        for($me=0;$me<$j;$me++){
        	        	
			if ($actualqty[$me]>0) {
				$count++;
				
				$mydata = array('fpcommodity_Id' => $fpids[$me], 'fp_quantity'=> $actualqty[$me] ,
				 'fp_date'=>date('y-m-d',strtotime($thedate[$me])),'transaction_type'=>$store[$me]);
				
				$u = new Pipeline();

    			$u->fromArray($mydata);

    			$u->save();
				
			}
			
		}
        
		 $this->session->set_flashdata('system_success_message', "Your Actual Stock has been Populated");
		 redirect('fp_management');
		
		
	}
	
	
	public function supply_plan_default() {
				//create array to carry months
		
		$montharray = array('7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December', '1' => 'January', '2' => 'Febuary', '3' => 'March', '4'=> 'April', '5' => 'May', '6'=> 'June');
if ($this->input->post('financeyear') && $this->input->post('commoditychange1') ){
		$f_year=$_POST['financeyear'];		
	   $fpcommodity1=$_POST['commoditychange1'];
	   
	   $graphtype=$_POST['graphtype'];
	} else {
	 $f_year='2013-2014';		
	 $fpcommodity1=2;
	 $graphtype='line';
		//exit;
	}
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT fpcommodity_Id, SUM( sohkemsa ) AS sohkemsa, monthn, financial_year, fp_name
FROM ( SELECT CASE WHEN MONTH(  `fp_date` ) >=7
THEN CONCAT( YEAR(  `fp_date` ) ,  '-', YEAR(  `fp_date` ) +1 ) 
ELSE CONCAT( YEAR(  `fp_date` ) -1,  '-', YEAR(  `fp_date` ) ) 
END AS financial_year,  `fp_quantity` / fpcommodities.projected_monthly_c AS sohkemsa,  `fpcommodity_Id` , MONTH(  `fp_date` ) AS monthn, fp_name
FROM pipeline, fpcommodities WHERE pipeline.`fpcommodity_Id` = fpcommodities.id AND  `transaction_type` =  'SOHKEMSA' 
AND `fpcommodity_Id` ='$fpcommodity1' ) AS temp WHERE financial_year =  '$f_year' GROUP BY monthn, fpcommodity_Id ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		
				
		$monthnos =  array();
		$actual = array();
		$commodity = array();
		foreach ($result as $value) {

			$monthnos[] = $value['monthn'];
			$actual[] = (double)$value['sohkemsa'];
			$commodity[] = $value['fp_name'];

		}
		
		if (count($monthnos)==0 && count($actual)==0) {
			
			echo "<div style='margin-left:40%;margin-top:5%;font-size:22px'>No Data Available For Actual Stocks</br> Can't Plot Chart </>";
			exit;
		}elseif (count($monthnos)==0 || count($actual)==0) {
			$monthnos=array(7,8);
			$arrayfp=array("0","0");
		} 
		//var_dump($monthnos);
		//var_dump($actual);
		//exit;
		$combined = array_combine($monthnos, $actual);
		$basket = array_replace($montharray, $combined);
		

		//loop through to replace string values in array with int
		foreach ($basket as $key => $val) {
			if (is_string($val)) {
				$basket[$key] = 0;
			}

		}
		$actualbasket = array();
		foreach ($basket as $key => $val) {
			$actualbasket[] = $basket[$key];
		}
		unset($combined);
		
		
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT * 
FROM ( SELECT CASE WHEN MONTH( fp_date ) >=7
THEN CONCAT( YEAR( fp_date ) ,  '-', YEAR( fp_date ) +1 ) 
ELSE CONCAT( YEAR( fp_date ) -1,  '-', YEAR( fp_date ) ) 
END AS financial_year,  `fp_quantity` / fpcommodities.projected_monthly_c AS pending,  `fpcommodity_Id` , MONTHNAME( fp_date ) AS monthname, MONTH( fp_date ) AS monthno, YEAR( fp_date ) AS yearname
FROM pipeline, fpcommodities WHERE  `fpcommodity_Id` ='$fpcommodity1' AND fpcommodities.id = pipeline.`fpcommodity_Id` AND  (`transaction_type` =  'PENDINGKEMSA'
OR  `transaction_type` =  'DELAYED' OR  `transaction_type` =  'INCOUNTRY' )) AS temp WHERE financial_year =  '$f_year'");
		//sanitize for use in array
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$monthno = array();
		$pend = array();
		//populate arrays
		foreach ($result as $value) {
			$monthno[] = $value['monthno'];
			$pend[] = (double)$value['pending'];
		}
		
		if (count($pend)==0) {
			$pend[]=0;
			$monthno[]=7;
			
		} 
		
		
		
		//combine data for corespondence, ie map months with respective values
		$arraycombined = array_combine($monthno, $pend);
		$basket = array_replace($montharray, $arraycombined);
		
		//loop through to replace string values in array with int
		foreach ($basket as $key => $val) {
			if (is_string($val)) {
				$basket[$key] = 0;
			}

		}
		
		$arrayfinal = array_combine($montharray, $basket);
		
		$for_calculate = array();
		foreach ($arrayfinal as $key => $value) {
			$for_calculate[] = $arrayfinal[$key];
		}
		
		
$i = 0;
			foreach ($for_calculate as $key => $value) {
				//check for the 1st index

				if ($i == 0) {
					if ($for_calculate[$i] == 0) {
						//var_dump($for_calculate);
		//exit;
						$for_calculate[$key] = $actualbasket[0];

					}
				}

				//clean rest of the array
				if ($i == 1) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[0] - 1 < 0) {
							$for_calculate[1] = 0;
						} else {
							$for_calculate[1] = $for_calculate[0] - 1;
						}
					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[1] = $for_calculate[0] + $for_calculate[1];
					}
				}
				if ($i == 2) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[1] - 1 < 0) {
							$for_calculate[2] = 0;
						} else {
							$for_calculate[2] = $for_calculate[1] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[2] = $for_calculate[1] + $for_calculate[2];
					}
				}
				if ($i == 3) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[2] - 1 < 0) {
							$for_calculate[3] = 0;
						} else {
							$for_calculate[3] = $for_calculate[2] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[3] = $for_calculate[3] + $for_calculate[2];
					}
				}
				if ($i == 4) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[3] - 1 < 0) {
							$for_calculate[4] = 0;
						} else {
							$for_calculate[4] = $for_calculate[3] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[4] = $for_calculate[4] + $for_calculate[3];
					}
				}
				if ($i == 5) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[4] - 1 < 0) {
							$for_calculate[5] = 0;
						} else {
							$for_calculate[5] = $for_calculate[4] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[5] = $for_calculate[5] + $for_calculate[4];
					}
				}
				if ($i == 6) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[5] - 1 < 0) {
							$for_calculate[6] = 0;
						} else {
							$for_calculate[6] = $for_calculate[5] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[6] = $for_calculate[6] + $for_calculate[5];
					}
				}
				if ($i == 7) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[6] - 1 < 0) {
							$for_calculate[7] = 0;
						} else {
							$for_calculate[7] = $for_calculate[6] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[7] = $for_calculate[7] + $for_calculate[6];
					}
				}
				if ($i == 8) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[7] - 1 < 0) {
							$for_calculate[8] = 0;
						} else {
							$for_calculate[8] = $for_calculate[7] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[8] = $for_calculate[8] + $for_calculate[7];
					}
				}
				if ($i == 9) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[8] - 1 < 0) {
							$for_calculate[9] = 0;
						} else {
							$for_calculate[9] = $for_calculate[8] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[9] = $for_calculate[9] + $for_calculate[8];
					}
				}
				if ($i == 10) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[9] - 1 < 0) {
							$for_calculate[10] = 0;
						} else {
							$for_calculate[10] = $for_calculate[9] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[10] = $for_calculate[10] + $for_calculate[9];
					}
				}
				if ($i == 11) {
					if ($for_calculate[$i] == 0) {

						if ($for_calculate[10] - 1 < 0) {
							$for_calculate[11] = 0;
						} else {
							$for_calculate[11] = $for_calculate[10] - 1;
						}

					} elseif ($for_calculate[$i] > 0) {
						$for_calculate[11] = $for_calculate[11] + $for_calculate[10];
					}
				}
		
				$i++;

			}


		
		
		
		$arraytograph = array_combine($montharray, $for_calculate);
		$arrayto_graph = array();
		foreach ($arraytograph as $key => $value) {

			$arrayto_graph[] = $arraytograph[$key];

		}
		$mymontharray = array();
		foreach ($montharray as $key => $value) {
			$mymontharray[] = $montharray[$key];
		}
			//var_dump($arrayto_graph);
			
			//var_dump($arrayto_graph2);
			//exit;
				
		$data['graphtype'] = json_encode($graphtype);
		$data['commodityname'] = $commodity[0];
		$data['arrayto_graph'] = json_encode($arrayto_graph);
		$data['arrayactual'] = json_encode($actualbasket);
		//$data['arrayto_graph2'] = json_encode($arrayto_graph2);
		//$data['arrayactual2'] = json_encode($actualbasket2);
		$data['montharray'] = json_encode($mymontharray);
		$this -> load -> view("supply_plan_v", $data);
	}

public function kemsa_data() {
	if ($this->input->post('as_of')){
		$as_of=$_POST['as_of'];		
	  	$date_asof=date('Y-m-d',strtotime($as_of));
	} else {
		 $date_asof=date('Y-m-d');
		 $year=date('Y');		
	   	 $month=date('n');
	}
		$split_date=explode('-', $date_asof);
		$year=$split_date[0];
		$month=$split_date[1];
		$day=$split_date[2];
		
			$year2=$year+2;
			$date_asof2=$year2.'-7-31';
		
	
		$graphtext= 'Between'.$date_asof2.'and'.$date_asof2;
		//get available fps at kemsa aggregated
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT SUM(  `fp_quantity` / fpcommodities.projected_monthly_c ) AS sohkemsa,  `fpcommodity_Id` 
FROM pipeline, fpcommodities
WHERE pipeline.`fpcommodity_Id` = fpcommodities.id
AND  `transaction_type` =  'SOHKEMSA'
AND MONTH(  `fp_date` ) =$month
AND YEAR(  `fp_date` ) =$year
GROUP BY fpcommodity_Id ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arrayfp = array();
		$arraypending = array();
		foreach ($result as $value) {

			$arrayfp[] = $value['fpcommodity_Id'];
			$arraypending[] = (double)$value['sohkemsa'];
		}
		
		if (count($arraypending)==0) {
			$arraypending=array(0,0);
			$arrayfp=array("2","4");
		} 
		
		$arraycombined = array_combine($arrayfp,$arraypending);
		
			
		$commodities = Fpcommodities::getAllfpcommodities();
		//$rowcount=count($commodities);
		$arrayfpname = array();
		//for ($i=1; $i <= $rowcount;) { 
			
		
		foreach ($commodities as $values) {

			$arrayfpname[$values -> id] = $values -> fp_name;

		}
		
		ksort($arrayfpname);
		$basketkemsa = array_replace($arrayfpname, $arraycombined);
		
		
		foreach ($basketkemsa as $key => $val) {
			if (is_string($val)) {
				$basketkemsa[$key] = 0;
			}
		}
		
		$array_finalkemsa = array();
		foreach ($basketkemsa as $key => $val) {

			$array_finalkemsa[] = $basketkemsa[$key];

		}
		foreach ($arrayfpname as $key => $val) {

			$array_finalfp[] = $arrayfpname[$key];

		}
		
		//query for second graph pending
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT SUM(  `fp_quantity` ) / fpcommodities.projected_monthly_c AS sohpending,  `fpcommodity_Id` 
FROM pipeline, fpcommodities
WHERE fpcommodities.id = pipeline.`fpcommodity_Id` 
AND (
 `transaction_type` =  'PENDINGKEMSA'
OR  `transaction_type` =  'DELAYED')
AND  `fp_date` 
BETWEEN  '$date_asof'
AND  '$date_asof2'
AND  `date_incountry` =  '0000-00-00'
AND  `date_receive` =  '0000-00-00'
GROUP BY fpcommodity_Id");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arrayfp1 = array();
		$arraypending1 = array();
		foreach ($result as $value) {

			$arrayfp1[] = $value['fpcommodity_Id'];
			$arraypending1[] = (double)$value['sohpending'];
		}

if (count($arraypending1)==0) {
			$arraypending1=array(0,0);
			$arrayfp1=array("2","4");
		} 
		
		 $arraycombine = array_combine($arrayfp1, $arraypending1);
		//var_dump( $arraycombine);
		//var_dump( $arraypending1);
//exit;
		$basketpend = array_replace($arrayfpname, $arraycombine);

		foreach ($basketpend as $key => $val) {
			if (is_string($val)) {
				$basketpend[$key] = 0;
			}

		}

		$array_finalpend = array();
		foreach ($basketpend as $key => $val) {

			$array_finalpend[] = $basketpend[$key];

		}
		
		$data['graphtext1'] = $date_asof;
		$data['graphtext2'] = $date_asof2;
		$data['array_finalkemsa'] = json_encode($array_finalkemsa);
		$data['array_finalpend'] = json_encode($array_finalpend);
		$data['arrayfpname'] = json_encode($array_finalfp);
		$this -> load -> view("ajax_view/kemsa_ajax_v", $data);

	}

public function psi_data() {
	if ($this->input->post('as_of_psi')){
		$as_of_psi=$_POST['as_of_psi'];		
	  	$date_asofpsi=date('Y-m-d',strtotime($as_of_psi));
	} else {
		 $date_asofpsi=date('Y-m-d');
		 $year=date('Y');		
	   	 $month=date('n');
	}
		$split_date=explode('-', $date_asofpsi);
		$year=$split_date[0];
		$month=$split_date[1];
		$day=$split_date[2];
		
			$year2=$year+2;
			$date_asof2=$year2.'-7-31';
			
				
		$graphtext= 'Between'.$date_asof2.'and'.$date_asof2;
		//get available fps at kemsa aggregated
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT SUM(  `fp_quantity` / fpcommodities.projected_monthly_c ) AS sohkemsa,  `fpcommodity_Id` 
FROM pipeline, fpcommodities
WHERE pipeline.`fpcommodity_Id` = fpcommodities.id
AND  `transaction_type` =  'SOHPSI'
AND MONTH(  `fp_date` ) =$month
AND YEAR(  `fp_date` ) =$year
GROUP BY fpcommodity_Id ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arrayfp = array();
		$arraypending = array();
		foreach ($result as $value) {

			$arrayfp[] = $value['fpcommodity_Id'];
			$arraypending[] = (double)$value['sohkemsa'];
		}
		
		if (count($arraypending)==0) {
			$arraypending=array(0,0);
			$arrayfp=array("2","4");
		} 
		
		$arraycombined = array_combine($arrayfp,$arraypending);
		
			
		$commodities = Fpcommodities::getAllfpcommodities();
		//$rowcount=count($commodities);
		$arrayfpname = array();
		//for ($i=1; $i <= $rowcount;) { 
			
		
		foreach ($commodities as $values) {

			$arrayfpname[$values -> id] = $values -> fp_name;

		}
		
		ksort($arrayfpname);
		$basketkemsa = array_replace($arrayfpname, $arraycombined);
		
		
		foreach ($basketkemsa as $key => $val) {
			if (is_string($val)) {
				$basketkemsa[$key] = 0;
			}
		}
		
		$array_finalkemsa = array();
		foreach ($basketkemsa as $key => $val) {

			$array_finalkemsa[] = $basketkemsa[$key];

		}
		foreach ($arrayfpname as $key => $val) {

			$array_finalfp[] = $arrayfpname[$key];

		}
		
		//query for second graph pending
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT SUM(  `fp_quantity` ) / fpcommodities.projected_monthly_c AS sohpending,  `fpcommodity_Id` 
FROM pipeline, fpcommodities
WHERE fpcommodities.id = pipeline.`fpcommodity_Id` 
AND  `transaction_type` =  'PENDINGPSI'
AND  `fp_date` 
BETWEEN  '$date_asofpsi'
AND  '$date_asof2'
AND  `date_incountry` =  '0000-00-00'
AND  `date_receive` =  '0000-00-00'
GROUP BY fpcommodity_Id");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arrayfp1 = array();
		$arraypending1 = array();
		foreach ($result as $value) {

			$arrayfp1[] = $value['fpcommodity_Id'];
			$arraypending1[] = (double)$value['sohpending'];
		}

if (count($arraypending1)==0) {
			$arraypending1=array(0,0);
			$arrayfp1=array("2","4");
		} 
		
		 $arraycombine = array_combine($arrayfp1, $arraypending1);
		//var_dump( $arraycombine);
		//var_dump( $arraypending1);
//exit;
		$basketpend = array_replace($arrayfpname, $arraycombine);

		foreach ($basketpend as $key => $val) {
			if (is_string($val)) {
				$basketpend[$key] = 0;
			}

		}

		$array_finalpend = array();
		foreach ($basketpend as $key => $val) {

			$array_finalpend[] = $basketpend[$key];

		}
		
		$data['graphtext1'] = $date_asofpsi;
		$data['graphtext2'] = $date_asof2;
		$data['array_finalpsi'] = json_encode($array_finalkemsa);
		$data['array_finalpend'] = json_encode($array_finalpend);
		$data['arrayfpname'] = json_encode($array_finalfp);
		$this -> load -> view("ajax_view/psi_ajax_v", $data);

	}

}
