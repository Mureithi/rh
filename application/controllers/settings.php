<?php
class Settings extends MY_Controller {

function __construct() {
	parent::__construct();
	$this -> load -> helper(array('form', 'url' ));
}

public function index() {
			
			$this -> settings_home();			}
			
			
public function settings_home() {

		
		$data['title'] = "Settings";
		$data['content_view'] = "settings_home_v";
		$data['banner_text'] = "Settings";
		$data['kemsa_psi'] = Pipeline::kemsa_psi();
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		
		$this -> load -> view("template", $data);
	}




public function supply_plan_s()
{
		
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['supplyplan'] = Pipeline::getall_supply_plan();
		$this -> load -> view("ajax_view/supplyplan_settings", $data);
			
}

public function fpcommodity_s()
{
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['funding'] = Funding_source::getAllfpfundingsources();
		$this -> load -> view("ajax_view/fp_settings", $data);
			
}

public function edit_transaction($trid) {
		
		$data['content_view'] = "ajax_view/editsettings_v";
		$data['title'] = "Edit";
		$data['banner_text'] = "Edit Supply Plan";
		$data['editdata'] = Pipeline::getAll_edit($trid);
		$data['fundingsource'] = Funding_source::getAllfpfundingsources();
		$this -> load -> view("template", $data);
		

	}

public function delete_transaction($trid) {
		
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute(" DELETE FROM  `drh`.`pipeline` WHERE  `pipeline`.`id` =$trid; ");
		$this->session->set_flashdata('system_error_message', "Record Deleted");
		redirect('settings');
		

	}
	public function update_transaction() {
		$trid=$_POST['trid'];
		$store=$_POST['storeid'];
		$FSource=$_POST['FSource'];		
	    $Quantityexp=$_POST['Quantityexp'];
		$Dateexp=$_POST['Dateexp'];
		$pending=$_POST['pending'];
		$Date_of=$_POST['Date_receive'];
		$status=$_POST['status'];	
		$datepend=date('y-m-d',strtotime($pending));
		$date=date('y-m-d',strtotime($Dateexp));
		$ddate=date('y-m-d',strtotime($Date_of));
		
		if ($store=='1') {
			if ($status==1) {
			$transaction='INCOUNTRY';
			
		}elseif ($status==2) {
			 $transaction='RECEIVED';
			
		}elseif ($status==3) {
			 $transaction='DELAYED';
			
		}elseif ($status==4) {
			 $transaction='CANCELED';
			
		}
		
		} elseif($store=='2') {
			if ($status==1) {
			$transaction='INCOUNTRYPSI';
			
		}elseif ($status==2) {
			 $transaction='RECEIVEDPSI';
			
		}elseif ($status==3) {
			 $transaction='DELAYEDPSI';
			
		}elseif ($status==4) {
			 $transaction='CANCELEDPSI';
			
		}
		}
		
				
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute(" UPDATE  `drh`.`pipeline` SET `transaction_type` = '$transaction', `funding_source` =  '$FSource', `fp_quantity` =  '$Quantityexp', `pending_as_of` =  '$datepend', `date_receive` = '$ddate', `fp_date` =  '$date' WHERE  `pipeline`.`id` =$trid; ");
		
			
		$this->session->set_flashdata('system_success_message', "Record Updated");
		redirect('settings');
		
		
		}

public function edit_fptransaction($fpid) {
		
		$data['content_view'] = "ajax_view/fpsettings_v";
		$data['title'] = "Edit";
		$data['banner_text'] = "Edit Supply Plan";
		$data['fpcommodity'] = Fpcommodities::getAllfpcommodities();
		$data['editdata'] = Fpcommodities::getAll_edit($fpid);
		$data['fundingsource'] = Funding_source::getAllfpfundingsources();
		$this -> load -> view("template", $data);
		

	}

public function update_fptransaction() {
		$fpcommodity=$_POST['fpcommodityid'];	
	    $unit=$_POST['unit'];	
		$description=$_POST['Description'];		
	    $KEMSA=$_POST['KEMSA'];
		$PSI=$_POST['PSI'];
		$Date_of=$_POST['Date_of'];
		$ddate=date('y-m-d',strtotime($Date_of));
		
			//exit;	
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute( " UPDATE  `drh`.`fpcommodities` SET  `Description` = '$description',
		`Unit`='$unit' ,`projected_monthly_c` = '$KEMSA', `projected_psi` = '$PSI' WHERE  `fpcommodities`.`id` ='$fpcommodity'; ");
		
		$this->session->set_flashdata('system_success_message', "You edited $description ");
		redirect('settings');

	}


public function delete_fptransaction($fpid) {
		
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute(" DELETE FROM  `drh`.`fpcommodities` WHERE  `fpcommodities`.`id` =$fpid; ");
		$this->session->set_flashdata('system_error_message', "Record Deleted");
		redirect('settings');
		

	}
public function soh_s()
{
		$data['soh'] = Pipeline::getall_soh();
		$this -> load -> view("ajax_view/soh_settings_v", $data);
			
}
public function pipeline_s()
{
		$data['pipeline'] = Pipeline::getall_pipeline();
		$this -> load -> view("ajax_view/pipeline_settings_v", $data);
			
}
public function edit_pipeline($fpid) {
		
		$data['content_view'] = "ajax_view/pipelinesettings_v";
		$data['title'] = "Edit";
		$data['banner_text'] = "Edit Pipeline";
		$data['soh'] = Pipeline::getid_pipeline($fpid);
		$this -> load -> view("template", $data);

	}

public function delete_pipeline($fpid) {
		
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute(" DELETE FROM  `drh`.`pipeline` WHERE  `pipeline`.`id` =$fpid; ");
		$this->session->set_flashdata('system_error_message', "Record Deleted");
		redirect('settings');
		

	}
public function edit_soh($fpid) {
		
		$data['content_view'] = "ajax_view/sohsettings_v";
		$data['title'] = "Edit";
		$data['banner_text'] = "Edit SOH";
		$data['soh'] = Pipeline::getid_soh($fpid);
		$this -> load -> view("template", $data);
		
	}

public function delete_soh($fpid) {
		
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute(" DELETE FROM  `drh`.`pipeline` WHERE  `pipeline`.`id` =$fpid; ");
		$this->session->set_flashdata('system_error_message', "Record Deleted");
		redirect('settings');
		

	}
public function update_soh() {
		$quantity=$_POST['Quantity'];
		$fp_name=$_POST['fp_name'];	
	    $trid=$_POST['trid'];	
		$Date_of=$_POST['Date_of'];
		$Store=$_POST['Store'];
		$ddate=date('y-m-d',strtotime($Date_of));
		
			if ($Store=='KEMSA') {
			$transaction='SOHKEMSA';
			
		}else {
			 $transaction='SOHPSI';
			
		}
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute( " UPDATE  `drh`.`pipeline` SET  `transaction_type` = '$transaction', `fp_quantity`='$quantity' ,`fp_date` = '$ddate' WHERE  `pipeline`.`id` ='$trid'; ");
		
		$this->session->set_flashdata('system_success_message', "You edited $fp_name ");
		redirect('settings');

	}
	
	public function update_pipeline() {
		$quantity=$_POST['Quantity'];
		$status=$_POST['status'];	
	    $trid=$_POST['trid'];	
		$Date_of=$_POST['Date_receive'];
		$fp_name=$_POST['fp_name'];	
		$ddate=date('y-m-d',strtotime($Date_of));
		
			if ($status==1) {
			$transaction='INCOUNTRY';
			
		}else {
			 $transaction='RECEIVED';
			
		}
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute( " UPDATE  `drh`.`pipeline` SET  `transaction_type` = '$transaction', `fp_quantity`='$quantity' ,`date_receive` = '$ddate' WHERE  `pipeline`.`id` ='$trid'; ");
		
		$this->session->set_flashdata('system_success_message', "You edited $fp_name ");
		redirect('settings');

	}
	
	public function add_fp()
{
		$this -> load -> view("ajax_view/new_fp");
			
}
public function add_commodity() {
		$commodity=$_POST['Commodity'];
		$description=$_POST['Description'];	
	    $unitsize=$_POST['unitsize'];	
		$pmckemsa=$_POST['pmckemsa'];
		$pmcpsi=$_POST['pmcpsi'];	
		$dateas_of=$_POST['dateas_of'];
		$ddate=date('y-m-d',strtotime($dateas_of));
		
			
		$mydata = array('fp_name' => $commodity, 'description'=> $description , 'unit'=>$unitsize,'projected_monthly_c'=>$pmckemsa
		,'projected_psi'=>$pmcpsi,'as_of'=>$ddate);
				
				$u = new Fpcommodities();

    			$u->fromArray($mydata);

    			$u->save();
		
		$this->session->set_flashdata('system_success_message', "$commodity was added to your list. ");
		redirect('settings');

	}

	public function new_source()
{
		$this -> load -> view("ajax_view/new_source");
			
}
public function add_source() {
		$source=$_POST['Source'];
		$procuring_a=$_POST['procuring_a'];	
	    $dateas_of=$_POST['dateas_of'];	
		
		$ddate=date('y-m-d',strtotime($dateas_of));
		
			
		$mydata = array('funding_source' => $source, 'procuring_a'=> $procuring_a , 'service_active'=>1 ,'date_asof'=>$ddate);
				
				$u = new Funding_source();

    			$u->fromArray($mydata);

    			$u->save();
		
		$this->session->set_flashdata('system_success_message', "$source was added as a Donor/Procuring Agency. ");
		redirect('settings');

	}
	}
	