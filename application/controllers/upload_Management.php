<?php

class Upload_Management extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> library('PHPExcel');
		ini_set("max_execution_time", "1000000");
		ini_set("upload_max_filesize", "500000000");
		ini_set("memory_limit",'2048M');
	}

	public function index() {
		$data['error'] = '';
		$data['title'] = "Upload CSV";
		$data['banner_text'] = "Data Upload";
		$data['link'] = "upload";
		//$data['facilities'] = Facilities::getFacilities();
		$data['content_view'] = "upload_v";
		//$this -> load -> view("facility_home_v", $data);
		$this -> load -> view("template", $data);
	}
	
	public function upload_csv()
	{
		
		$file_element_name = 'file';
		$config['upload_path'] = './uploads/';
      $config['allowed_types'] = 'csv';
      $config['max_size']  = '1000000000';
      $config['encrypt_name'] = FALSE;
	  
	   $this->load->library('upload', $config);
 
      if (!$this->upload->do_upload($file_element_name))
      {
         echo "error";
      }
      else
      {
      	$table = "drh_fpc_by_facilitytemp";
		$target_table="drh_fpc_by_facility";
		
			$format_table = "(Period_ID,Organisation_unit_ID,Period_UID,Organisation_unit_UID,Period,Organisation_unit,Period_code,Organisation_unit_code,Period_description,Organisation_unit_description,Reporting_month,Organisation_unit_parameter,Organisation_unit_is_parent,FP_Injections,Pills_Microlut,Pills_Microgynon,IUCD_insertion,IUCD_Removals,Implants_insertion,Implants_Removal,Sterilization_BTL,Steriliz_Vasectomy,NFP,All_others_FP,Clints_condom) SET id=NULL";
			
			//Data sanitization
			$next_sql = "update `$table` SET Period=STR_TO_DATE(Period,'%M-%Y');insert into `$target_table`(`Period_ID`,`Organisation_unit_ID`,`Period_UID`,`Organisation_unit_UID`,`Period`,`Organisation_unit`,`Period_code`,`Organisation_unit_code`,`Period_description`,`Reporting_month`,`Organisation_unit_description`,`Organisation_unit_parameter`,`Organisation_unit_is_parent`,`FP_Injections`,`Pills_Microlut`,`Pills_Microgynon`,`IUCD_insertion`,`IUCD_Removals`,`Implants_insertion`,`Implants_Removal`,`Sterilization_BTL`,`Steriliz_Vasectomy`,`NFP`,`All_others_FP`,`Clints_condom`)select    `Period_ID` ,  `Organisation_unit_ID` ,  `Period_UID` ,  `Organisation_unit_UID` ,  `Period` ,  `Organisation_unit` ,  `Period_code` ,  `Organisation_unit_code` ,  `Period_description` ,  `Reporting_month` ,  `Organisation_unit_description` ,  `Organisation_unit_parameter` ,  `Organisation_unit_is_parent` ,  `FP_Injections` ,  `Pills_Microlut` ,  `Pills_Microgynon` ,  `IUCD_insertion` ,  `IUCD_Removals` , `Implants_insertion` ,  `Implants_Removal` ,  `Sterilization_BTL` ,  `Steriliz_Vasectomy` ,  `NFP` ,  `All_others_FP` ,  `Clints_condom` from `$table`; truncate `$table`;";
			//$next_sql .= "insert into `$target_table`(`Period_ID`,`Organisation_unit_ID`,`Period_UID`,`Organisation_unit_UID`,`Period`,`Organisation_unit`,`Period_code`,`Organisation_unit_code`,`Period_description`,`Reporting_month`,`Organisation_unit_description`,`Organisation_unit_parameter`,`Organisation_unit_is_parent`,`FP_Injections`,`Pills_Microlut`,`Pills_Microgynon`,`IUCD_insertion`,`IUCD_Removals`,`Implants_insertion`,`Implants_Removal`,`Sterilization_BTL`,`Steriliz_Vasectomy`,`NFP`,`All_others_FP`,`Clints_condom`)select  `Period_ID`,`Organisation_unit_ID`,`Organisation_unit_UID`,`Period`,`Organisation_unit`,`Period_code`,`Organisation_unit_code`,`Period_description`,`Organisation_unit_description`,`Organisation_unit_is_parent`,`FP_Injections`,`Pills_Microlut`,`Pills_Microgynon`,`IUCD_insertion`,`IUCD_Removals`,`Implants_insertion`,`Implants_Removal`,`Sterilization_BTL`,`Steriliz_Vasectomy`,`NFP`,`All_others_FP`,`Clints_condom` from `$table`; truncate `$table`;";

			//$next_sql .= "TRUNCATE `$table`;";
			
			
			$data = array('upload_data' => $this -> upload -> data());
			foreach ($data as $thedata) {

			}
			$thedata['full_path'];
			$csv_file = str_replace("\\", "\\\\", realpath($thedata['full_path']));
			$str = realpath($_SERVER['MYSQL_HOME']) . "\mysql";
			$mysql_bin = str_replace("\\", "\\\\", $str);
			//echo $mysql_bin;
			$sql = "load data concurrent infile '$csv_file' INTO TABLE $table FIELDS TERMINATED BY ',' ENCLOSED BY '\"\"' LINES TERMINATED BY '\\r\\n'   IGNORE 1 LINES $format_table;" . $next_sql;
			$mysql_con = "$mysql_bin -u root  -h localhost drh_final --local-infile=1  -e \"$sql\"";

			//Code to execute in command line
			exec($mysql_con);
			unlink($csv_file);
			
			$this->session->set_flashdata('system_success_message', "Upload Successful!");
			redirect("/");
      	//echo $mysql_con;
		
      }
	}

	public function do_upload() {
		$config['upload_path'] = '././uploads/';
		$config['allowed_types'] = 'csv';
		$config['max_size'] = '1000000000';
		//$upload_type = $_POST['upload_type'];

		$this -> load -> library('upload', $config);
		$this -> load -> library('PHPExcel');
		$facility_code = $this -> session -> userdata('facility');
		if (!$this -> upload -> do_upload()) {
			$data['error'] = $this -> upload -> display_errors();
			$this -> session -> set_userdata('upload_counter', '1');
			redirect("upload_management/index");
		} else {
			//$test_type = $_POST['test_type'];
			//$facility = $_POST["facility"];

			$table = "patient_temp";

			$format_table = "(ArtID,Firstname,Surname,Sex,Age,Pregnant,DateTherapyStarted,WeightOnStart,ClientSupportedBy,OtherDeaseConditions,ADRorSideEffects,ReasonsforChanges,OtherDrugs,TypeOfService,DaysToNextAppointment,DateOfNextAppointment,CurrentStatus,CurrentRegimen,RegimenStarted,Address,CurrentWeight,startBSA,currentBSA,ischild,isadult,StartHeight,CurrentHeight,Naive,NonNaive,SourceofClient,Cotrimoxazole,TB,NoCotrimoxazole,NoTB,DateStartedonART,DateChangedStatus,NcurrentAge,OPIPNO,LastName,DateofBirth,PlaceofBirth,PatientCellphone,AlternateContact,PatientSmoke,PatientDrinkAlcohol,PatientDontSmoke,PatientDontDrinkAlcohol,InactiveDays,TransferFrom,facility_id)SET id=NULL,facility_id=121";
			//Data sanitization
			$next_sql = "update `$table` SET DateofBirth=STR_TO_DATE(DateofBirth,'%m/%d/%Y') WHERE DateofBirth like '%/%';";
			$next_sql .= "update `$table` SET DateTherapyStarted=STR_TO_DATE(DateTherapyStarted,'%m/%d/%Y') WHERE DateTherapyStarted like '%/%';";
			$next_sql .= "update `$table` SET DateofBirth=DATE_SUB( DateTherapyStarted, INTERVAL Age YEAR ) WHERE DateofBirth='';";
			$next_sql .= "update `$table` set Sex = '1' where Sex like '%Ma%';";
			$next_sql .= "update `$table` set Sex = '2' where Sex like '%F%';";
			$next_sql .= "update `$table` set Pregnant = '0' where Pregnant like '%FA%';";
			$next_sql .= "update `$table` set Pregnant = '1' where Pregnant like '%TR%';";
			$next_sql .= "update `$table` set TB = '0' where TB like '%FA%';";
			$next_sql .= "update `$table` set TB = '1' where TB like '%TR%';";
			$next_sql .= "update `$table` set PatientSmoke = '0' where PatientSmoke like '%FA%';";
			$next_sql .= "update `$table` set PatientSmoke = '1' where PatientSmoke like '%TR%';";
			$next_sql .= "update `$table` set PatientDrinkAlcohol = '0' where PatientDrinkAlcohol like '%FA%';";
			$next_sql .= "update `$table` set PatientDrinkAlcohol = '1' where PatientDrinkAlcohol like '%TR%';";
			//$next_sql .= "update `$table` set DateofBirth =  STR_TO_DATE(DateofBirth,'%m/%d/%Y') where DateofBirth like '%/%';";
			$next_sql .= "update `$table` set DateChangedStatus = STR_TO_DATE(DateChangedStatus,'%m/%d/%Y') where DateChangedStatus like '%/%';";
			//$next_sql .= "update `$table` set DateTherapyStarted = STR_TO_DATE(DateTherapyStarted,'%m/%d/%Y') where DateTherapyStarted like '%/%';";
			$next_sql .= "update `$table` set DateStartedonART = STR_TO_DATE(DateStartedonART,'%m/%d/%Y') where DateStartedonART like '%/%';";
			$next_sql .= "update `$table` set DateofNextAppointment =  STR_TO_DATE(DateofNextAppointment,'%m/%d/%Y') where DateofNextAppointment like '%/%';";
			$next_sql .= "update `$table` p, regimen r set RegimenStarted=r.id where RegimenStarted = r.regimen_code;";
			$next_sql .= "update `$table` p, regimen r set CurrentRegimen=r.id where CurrentRegimen= r.regimen_code;";
			$next_sql .= "update `$table` p, regimen r set RegimenStarted=r.merged_to,p.start_regimen_merged_from=r.id where r.merged_to !='' and p.RegimenStarted = r.regimen_code;";
			$next_sql .= "update `$table` p, regimen r set CurrentRegimen=r.merged_to,p.current_regimen_merged_from=r.id where r.merged_to !='' and p.CurrentRegimen= r.regimen_code;";

			//Transfer from temporary table to permanent table
			$next_sql .= "insert into `$target_table`(patient_number_ccc, first_name, last_name, other_name, dob, pob, gender, pregnant,start_weight,start_height,start_bsa,weight,height,sa,phone, physical, alternate, other_illnesses, other_drugs, adr, tb, smoke, alcohol, date_enrolled, source, supported_by, facility_code, service, start_regimen,current_status, migration_id,status_change_date,start_regimen_date,current_regimen,nextappointment,transfer_from,start_regimen_merged_from,current_regimen_merged_from)select ArtID, Firstname,Surname, LastName,DateofBirth , PlaceofBirth, Sex, Pregnant, WeightOnStart, StartHeight, startBSA,CurrentWeight,CurrentHeight,currentBSA,PatientCellphone, Address, AlternateContact, OtherDeaseConditions, OtherDrugs, ADRorSideEffects, TB, PatientSmoke, PatientDrinkAlcohol, DateTherapyStarted, SourceofClient, ClientSupportedBy, facility_id, TypeOfService, RegimenStarted, CurrentStatus, facility_id,DateChangedStatus,DateStartedonART,CurrentRegimen,DateofNextAppointment,TransferFrom,start_regimen_merged_from,current_regimen_merged_from from `$table`;";
			$next_sql .= "insert into `$appointment_table`(patient, appointment, facility) select ArtID, DateofNextAppointment,facility_id from `$table`;";
			$next_sql .= "truncate `$table`;";

			//Updating all transaction timestamps
			$next_sql .= "update `$target_table` set timestamp=id where timestamp=''; ";

			$data = array('upload_data' => $this -> upload -> data());
			foreach ($data as $thedata) {

			}
			$thedata['full_path'];
			$csv_file = str_replace("\\", "\\\\", realpath($thedata['full_path']));
			$str = realpath($_SERVER['MYSQL_HOME']) . "\mysql";
			$mysql_bin = str_replace("\\", "\\\\", $str);
			$sql = "load data concurrent infile '$csv_file' INTO TABLE $table FIELDS TERMINATED BY ',' ENCLOSED BY '\"\"' LINES TERMINATED BY '\\r\\n'  IGNORE 1 LINES $format_table;" . $next_sql;
			$mysql_con = "$mysql_bin -u root  -h localhost adt --local-infile=1  -e \"$sql\"";

			//Code to execute in command line
			exec($mysql_con);
			unlink($csv_file);
			$this -> session -> set_userdata('upload_counter', '2');
			redirect("upload_management/index");

		}
	}

	public function import() {
		//if ($_POST['btn_save']) {

		//$pipeline = $_POST['pipeline_name'];
		//$upload_period = $_POST['upload_date'];
		//$report_type = $_POST['test_type'];
		//$period = explode('-', $upload_period);
		//$year = $period[1];
		//$month = date('m', strtotime($period[0]));
		//$comments = "";
		//$facility_name = "";

		//echo $_FILES['file']['tmp_name'];
		if ($_FILES['file']['tmp_name']) {
			$objPHPExcel = PHPExcel_IOFactory::load(@$_FILES['file']['tmp_name']);

			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$worksheetTitle = $worksheet -> getTitle();
				$highestRow = $worksheet -> getHighestRow();
				// e.g. 10
				$highestColumn = $worksheet -> getHighestColumn();
				// e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = $highestColumn;
				//echo "<br>The worksheet ".$worksheetTitle." has ";
				// echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
				// echo ' and ' . $highestRow . ' row.';
				//echo '<br>Data: <table border="1"><tr>';
				$rowTypes = array();
				$implodedStoreRow = array();
				$arraymain = array();
				for ($row = 2; $row <= $highestRow; ++$row) {
					// echo '<tr>';
					for ($col = 1; $col <= $highestColumnIndex; ++$col) {
						$cell = $worksheet -> getCellByColumnAndRow($col, $row);
						$val = $cell -> getValue();
						$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
						//echo $dataType;exit;
						/*if ($dataType=="n" && $val=="") {
						 //if ($dataType=="n") {
						 $val='0';
						 }else if($dataType=="s" && $val==""){
						 //}else if($dataType=="s"){
						 $val="n/a";
						 }else if($dataType=="null"){*/
						if ($dataType == "null") {
							$val = null;
						}

						$storerow[] = $val;

						// $rowTypes[]=$dataType;

						// echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
					}
					// echo '</tr>';
					//$imploded_row = implode(",", $storerow);
					//$implodedStoreRow[]=$imploded_row;
					
					$counter = 1;
					$str="";
					foreach ($storerow as $store) {
						if ($counter < sizeof($storerow)) {
							if(is_string($store)){
							$str.="'".$store."',";	
							}else{
							$str.=$store.",";		
							}
							

						} else if ($counter > (sizeof($storerow) - 1)) {
                            if(is_string($store)){
							$str.="'".$store."'";	
							}else{
							$str.=$store."";		
							}
							
						}
						$counter++;

					}
                   // echo $str;
					$arraymain[] = $str;
					//exit ;
					//$storerow=array();

					//echo "<br/>";

					//exit;
				}

				//echo '</table>';

				/**/
				foreach ($arraymain as $key => $value) {
					var_dump($value);
					exit;
					//do insert here
					$insertcsvdata = Doctrine_Manager::getInstance() -> getCurrentConnection();
					$insertcsvdata -> execute("INSERT INTO `drh`.`drh_fpc_by_facility` (`id`, `Period_ID`, `Organisation_unit_ID`, 
				`Period_UID`, `Organisation_unit_UID`, `Period`, `Organisation_unit`, `Period_code`, `Organisation_unit_code`, 
				`Period_description`, `Organisation_unit_description`, `Reporting_month`, `Organisation_unit_parameter`, 
				`Organisation_unit_is_parent`, `FP_Injections`, `Pills_Microlut`, `Pills_Microgynon`, `IUCD_insertion`, 
				`IUCD_Removals`, `Implants_insertion`, `Implants_Removal`, `Sterilization_BTL`, `Steriliz_Vasectomy`, 
				`NFP`, `All_others_FP`, `Clints_condom`) VALUES ($value); ");
				}
				//var_dump($arraymain);
			}

		}

		//die();
		/*
		 foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
		 $highestRow = $worksheet -> getHighestRow();
		 $highestColumn = $worksheet -> getHighestColumn();
		 $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
		 $arr = $objPHPExcel -> getActiveSheet() -> toArray(null, true, true, true);
		 for ($row = 1; $row <= $highestRow; ++$row) {
		 $facility_cell = $worksheet -> getCellByColumnAndRow(1, $row);
		 $facility_name = $facility_cell -> getValue();
		 for ($col = 1; $col < $highestColumnIndex ; ++$col) {
		 $cell = $worksheet -> getCellByColumnAndRow($col, $row);

		 /*if ($val == null) {
		 $val = 0;
		 }
		 //echo $facility_name . "---" . $comments . "---" . $regimen_desc_cell . "---" . $regimen_code_cell . "---" . $prev_regimen_code_cell . "---" . $month . "---" . $year . "----" . $val . "---" . $pipeline . "<br/>";
		 $drh_report = new Drh_fpc_by_facility();
		 $drh_report -> period_id = $period_id;
		 $drh_report -> organization_unit_id = $organization_unit_id;
		 $drh_report -> period_uid = $period_uid;
		 $drh_report -> organisation_unit_uid = $organisation_unit_uid;
		 $drh_report -> period = $period;
		 $drh_report -> organisation_unit_code = $organisation_unit_code;
		 $drh_report -> period_code = $period_code;
		 $drh_report -> organisation_unit_code = $organisation_unit_code;
		 $drh_report -> period_description = $period_description;
		 $drh_report -> organization_unit_description = $organization_unit_description;
		 $drh_report -> reporting_month = $reporting_month;
		 $drh_report -> organization_unit_parameter = $organization_unit_parameter;
		 $drh_report -> organization_unit_is_parent = organization_unit_is_parent;
		 $drh_report -> fp_injections = $fp_injections;
		 $drh_report -> pills_microlut = $pills_microlut;
		 $drh_report -> Pills_Microgynon = $Pills_Microgynon;
		 $drh_report -> IUCD_insertion = $IUCD_insertion;
		 $drh_report -> IUCD_Removals = $IUCD_Removals;
		 $drh_report -> Implants_insertion = $Implants_insertion;
		 $drh_report -> Implants_Removal = $Implants_Removal;
		 $drh_report -> Sterilization_BTL = $Sterilization_BTL;
		 $drh_report -> Steriliz_Vasectomy = $Steriliz_Vasectomy;
		 $drh_report -> NFP = $NFP;
		 $drh_report -> All_others_FP = $All_others_FP;
		 $drh_report -> Clints_condom = $Clints_condom;
		 $drh_report -> save();
		 }
		 echo $arr['B'][$row]."<br/>";
		 }
		 }*/

		//$this -> session -> set_userdata('upload_counter', '2');
		//redirect("pipeline_management/index");

		//$this -> session -> set_userdata('upload_counter', '1');
		//redirect("pipeline_management/index");

		//}//end of

	}

	public function readcsv() {

		if ($_FILES['file']['tmp_name']) {
			//$handle = fopen($_FILES['file']['tmp_name'], "r");

			//var_dump($handle);
			$this -> load -> library('csvreader');

			$filePath = $_FILES['file']['tmp_name'];

			$data = $this -> csvreader -> parse_file($filePath);
			$csvfinalarray = array();
			foreach ($data as $key => $value) {
				$csvarray = array();
				//$csvdata=implode(",",$value);
				foreach ($value as $key => $val) {

					if ($val == "" || $val == " " || $val = null) {
						$val = '"0"';
					}
					$csvarray[] = $val;

					//do insert here
					//$insertcsvdata = Doctrine_Manager::getInstance()->getCurrentConnection();
					//$insertcsvdata->execute("INSERT INTO `drh`.`drh_fpc_by_facility` (`id`, `Period_ID`, `Organisation_unit_ID`, `Period_UID`, `Organisation_unit_UID`, `Period`, `Organisation_unit`, `Period_code`, `Organisation_unit_code`, `Period_description`, `Organisation_unit_description`, `Reporting_month`, `Organisation_unit_parameter`, `Organisation_unit_is_parent`, `FP_Injections`, `Pills_Microlut`, `Pills_Microgynon`, `IUCD_insertion`, `IUCD_Removals`, `Implants_insertion`, `Implants_Removal`, `Sterilization_BTL`, `Steriliz_Vasectomy`, `NFP`, `All_others_FP`, `Clints_condom`)
					//VALUES ($csvdata); ");

					//echo $csvdata;

				}
				//var_dump($csvarray);

				//echo implode(",",$csvarray);
				$csv_data = implode(",", $csvarray);
				$csvfinalarray[] = $csv_data;

				echo $csv_data;

				echo "</br";

			}

			// var_dump($csvfinalarray);
			foreach ($csvfinalarray as $key => $lastvalue) {

				//	$final= substr($lastvalue, 0, -1);

				// $insertcsvdata = Doctrine_Manager::getInstance()->getCurrentConnection();
				//$insertcsvdata->execute("`)
				//VALUES ($lastvalue); ");

			}
			//var_dump($csvarray);
			// echo implode(",",$csvarray);
			// echo "</br";
			//$this->load->view('csv_view', $data);

		}

	}




}
?>