<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Statistics_controller extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> library('PHPExcel');
		ini_set("max_execution_time", "1000000");
		//ini_set("upload_max_filesize", "500000000");
		ini_set("memory_limit", '2048M');
	}

	public function index() {

		$this -> test();
	}

	public function test() {
		$data['title'] = "Stock";
		$data['banner_text'] = "menu";
		$data['commodity'] = Fp_commodities::getAllcommodities();
		$data['content_view'] = "data_analysis_v";
		$this -> load -> view("template", $data);
	}

	public function get_default() {

		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT FP_Injections as commodity,counties.county FROM  `county_summary`,counties where county_summary.county=counties.id ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arraycounties = array();
		$arraytotals = array();
		foreach ($result as $value) {

			$arraycounties[] = $value['county'];

			$arraytotals[] = (int)$value['commodity'];

		}

		$arraycounties = json_encode($arraycounties);
		$arraytotals = json_encode($arraytotals);
		$session_data = array('commodity' => 'FP_Injections');
		$this -> session -> set_userdata($session_data);

		$data['arrayName'] = $arraycounties;
		$data['arrayData'] = $arraytotals;
		$data['banner_text'] = "charts";

		$this -> load -> view("plotchart_V", $data);

	}

	public function get_commodity_analyse() {

		$commodity = $_POST['getcommodity'];
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT $commodity as commodity,counties.county FROM  `county_summary`,counties where county_summary.county=counties.id ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arraycounties = array();
		$arraytotals = array();
		foreach ($result as $value) {

			$arraycounties[] = $value['county'];

			$arraytotals[] = (int)$value['commodity'];

		}

		$arraycounties = json_encode($arraycounties);
		$arraytotals = json_encode($arraytotals);
		$session_data = array('commodity' => $commodity);
		$this -> session -> set_userdata($session_data);

		$data['arrayName'] = $arraycounties;
		$data['arrayData'] = $arraytotals;
		//$data['content_view'] = "plotchart_V";
		$data['banner_text'] = "charts";

		$this -> load -> view("plotchart_V", $data);

	}

	public function chartby_district() {
		$data['title'] = "by_district";
		$data['banner_text'] = "menu";
		$data['county'] = Counties::getAll();
		$data['content_view'] = "analyseby_district_v";
		//$this -> load -> view("data_analysis_v", $data);
		$this -> load -> view("template", $data);
	}

	public function forecast() {

		//$commodity = $_POST['getcommodity'];
		$month = date("m");
		$year = date("Y");

		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT  `county` ,  `district` ,  `facility_name` ,  `myYEAR` ,  `myMONTH` , SUM(  `FP_injections` ) AS FP_injections, SUM(  `Pills_Microlut` ) AS Pills_Microlut, SUM(  `Pills_Microgynon` ) AS Pills_Microgynon, SUM(  `IUCD_insertion` ) AS IUCD_insertion, SUM(  `IUCD_Removals` ) AS IUCD_Removals, SUM(  `Implants_insertion` ) AS Implants_insertion, SUM(  `Implants_Removal` ) AS Implants_Removal, SUM(  `Sterilization_BTL` ) AS Sterilization_BTL, SUM(  `Steriliz_Vasectomy` ) AS Steriliz_Vasectomy, SUM(  `NFP` ) AS NFP, SUM(  `All_others_FP` ) AS All_others_FP, SUM(  `Clints_condom` ) AS Clints_condom FROM  `intermediate_districtforecast` WHERE  `myYEAR` =  $year AND  `myMONTH` BETWEEN ( $month -2 ) AND $month GROUP BY  `countyid` ORDER BY  `intermediate_districtforecast`.`myYEAR` DESC ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);

		$data['result'] = $result; ;
		$data['title'] = "tabular data";
		$data['banner_text'] = "tabular data";
		$data['content_view'] = "district_tabular_v";
		$this -> load -> view("template", $data);

	}

	public function forecastby_district() {

		$month = date("m");
		$year = date("Y");

		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT  `county` ,  `district` ,  `facility_name` ,  `myYEAR` ,  `myMONTH` , SUM(  `FP_injections` ) AS FP_injections, SUM(  `Pills_Microlut` ) AS Pills_Microlut, SUM(  `Pills_Microgynon` ) AS Pills_Microgynon, SUM(  `IUCD_insertion` ) AS IUCD_insertion, SUM(  `IUCD_Removals` ) AS IUCD_Removals, SUM(  `Implants_insertion` ) AS Implants_insertion, SUM(  `Implants_Removal` ) AS Implants_Removal, SUM(  `Sterilization_BTL` ) AS Sterilization_BTL, SUM(  `Steriliz_Vasectomy` ) AS Steriliz_Vasectomy, SUM(  `NFP` ) AS NFP, SUM(  `All_others_FP` ) AS All_others_FP, SUM(  `Clints_condom` ) AS Clints_condom FROM  `intermediate_districtforecast` WHERE  `myYEAR` =  $year AND  `myMONTH` BETWEEN ( $month -2 ) AND $month GROUP BY  `countyid` ORDER BY  `intermediate_districtforecast`.`myYEAR` DESC ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);

		$data['result'] = $result;
		$data['title'] = "tabular data";
		$data['banner_text'] = "tabular data";
		$data['content_view'] = "district_tabular_v";
		$this -> load -> view("template", $data);

	}
	public function forecastedit_county_vd() {

		$month = date("m");
		$year = date("Y");
		$county=1;

		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT  `county` ,  `district` ,  `facility_name` ,  `myYEAR` ,  `myMONTH` , SUM(  `FP_injections` ) AS FP_injections, SUM(  `Pills_Microlut` ) AS Pills_Microlut, SUM(  `Pills_Microgynon` ) AS Pills_Microgynon, SUM(  `IUCD_insertion` ) AS IUCD_insertion, SUM(  `IUCD_Removals` ) AS IUCD_Removals, SUM(  `Implants_insertion` ) AS Implants_insertion, SUM(  `Implants_Removal` ) AS Implants_Removal, SUM(  `Sterilization_BTL` ) AS Sterilization_BTL, SUM(  `Steriliz_Vasectomy` ) AS Steriliz_Vasectomy, SUM(  `NFP` ) AS NFP, SUM(  `All_others_FP` ) AS All_others_FP, SUM(  `Clints_condom` ) AS Clints_condom FROM  `intermediate_districtforecast` WHERE  `myYEAR` =  $year AND  `myMONTH` BETWEEN ( $month -2 ) AND $month GROUP BY  `countyid` AND `county` =$county ORDER BY  `intermediate_districtforecast`.`myYEAR` DESC ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$data['title'] = "by_district";
		$data['banner_text'] = "menu";
		$data['county'] = Counties::getAll();
		$data['result'] = $result;
		$data['content_view'] = "forecast_edit_v";
		$this -> load -> view("template" , $data);

			}

			public function forecastedit_county_v() {

			//$month = date("m");
			//$year = date("Y");
			$county=$_POST['countyforecast'];

			$con = Doctrine_Manager::getInstance() -> connection();
			$st = $con -> execute("SELECT  `county` , SUM(  `FP_injections` ) AS FP_injections, SUM(  `Pills_Microlut` ) AS Pills_Microlut, SUM(  `Pills_Microgynon` ) AS Pills_Microgynon, SUM(  `IUCD_insertion` ) AS IUCD_insertion, SUM(  `IUCD_Removals` ) AS IUCD_Removals, SUM(  `Implants_insertion` ) AS Implants_insertion, SUM(  `Implants_Removal` ) AS Implants_Removal, SUM(  `Sterilization_BTL` ) AS Sterilization_BTL, SUM(  `Steriliz_Vasectomy` ) AS Steriliz_Vasectomy, SUM(  `NFP` ) AS NFP, SUM( `All_others_FP` ) AS All_others_FP, SUM(  `Clints_condom` ) AS Clints_condom
			FROM  `intermediate_districtforecast` WHERE  `countyid` =$county AND  `myYEAR` =2012 ");
			$result = $st -> fetchAll(PDO::FETCH_ASSOC);
			$data['title'] = "by_district";
			$data['banner_text'] = "menu";
			$data['county'] = Counties::getAll();
			$data['result'] = $result;
			$this -> load -> view("forecast_edit_v", $data);

			}

			public function get_default_perdistrict() {

			$con = Doctrine_Manager::getInstance() -> connection();
			$st = $con -> execute(
		" SELECT  `district` ,  `FP_injections` ,  `Pills_Microlut` ,  `Pills_Microgynon` ,  `IUCD_insertion` ,  `IUCD_Removals` ,  `Implants_insertion` ,  `Implants_Removal` ,  `Sterilization_BTL` ,  `Steriliz_Vasectomy` ,  `NFP` , `All_others_FP` ,  `Clints_condom` FROM  `summary_district` WHERE county =1");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arraydistricts = array();
		$arrayseries1 = array();
		$arrayseries2 = array();
		$arrayseries3 = array();
		$arrayseries4 = array();
		$arrayseries5 = array();
		$arrayseries6 = array();
		$arrayseries7 = array();
		$arrayseries8 = array();
		$arrayseries9 = array();
		$arrayseries10 = array();
		$arrayseries11 = array();
		$arrayseries12 = array();
		foreach ($result as $value) {

			$arraydistricts[] = $value['district'];
			$arrayseries1[] = (int)$value['FP_injections'];
			$arrayseries2[] = (int)$value['Pills_Microlut'];
			$arrayseries3[] = (int)$value['Pills_Microgynon'];
			$arrayseries4[] = (int)$value['IUCD_insertion'];
			$arrayseries5[] = (int)$value['IUCD_Removals'];
			$arrayseries6[] = (int)$value['Implants_insertion'];
			$arrayseries7[] = (int)$value['Implants_Removal'];
			$arrayseries8[] = (int)$value['Sterilization_BTL'];
			$arrayseries9[] = (int)$value['Steriliz_Vasectomy'];
			$arrayseries10[] = (int)$value['NFP'];
			$arrayseries11[] = (int)$value['All_others_FP'];
			$arrayseries12[] = (int)$value['Clints_condom'];

		}
		$arraydistricts = json_encode($arraydistricts);
		$arrayseries1 = json_encode($arrayseries1);
		$arrayseries2 = json_encode($arrayseries2);
		$arrayseries3 = json_encode($arrayseries3);
		$arrayseries4 = json_encode($arrayseries4);
		$arrayseries5 = json_encode($arrayseries5);
		$arrayseries6 = json_encode($arrayseries6);
		$arrayseries7 = json_encode($arrayseries7);
		$arrayseries8 = json_encode($arrayseries8);
		$arrayseries9 = json_encode($arrayseries9);
		$arrayseries10 = json_encode($arrayseries10);
		$arrayseries11 = json_encode($arrayseries11);
		$arrayseries12 = json_encode($arrayseries12);

		$data['arrayN'] = $arraydistricts;
		$data['arrayseries1'] = $arrayseries1;
		$data['arrayseries2'] = $arrayseries2;
		$data['arrayseries3'] = $arrayseries3;
		$data['arrayseries4'] = $arrayseries4;
		$data['arrayseries5'] = $arrayseries5;
		$data['arrayseries6'] = $arrayseries6;
		$data['arrayseries7'] = $arrayseries7;
		$data['arrayseries8'] = $arrayseries8;
		$data['arrayseries9'] = $arrayseries9;
		$data['arrayseries10'] = $arrayseries10;
		$data['arrayseries11'] = $arrayseries11;
		$data['arrayseries12'] = $arrayseries12;
		$data['banner_text'] = "charts";

		$this -> load -> view("chartby_district_v", $data);

	}

	public function get_commodity_perdistrict() {

		$county = $_POST['county'];
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute(" SELECT  `district` ,  `FP_injections` ,  `Pills_Microlut` ,  `Pills_Microgynon` ,  `IUCD_insertion` ,  `IUCD_Removals` ,  `Implants_insertion` ,  `Implants_Removal` ,  `Sterilization_BTL` ,  `Steriliz_Vasectomy` ,  `NFP` , `All_others_FP` ,  `Clints_condom` FROM  `summary_district` WHERE county =$county");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		$arraydistricts = array();
		$arrayseries1 = array();
		$arrayseries2 = array();
		$arrayseries3 = array();
		$arrayseries4 = array();
		$arrayseries5 = array();
		$arrayseries6 = array();
		$arrayseries7 = array();
		$arrayseries8 = array();
		$arrayseries9 = array();
		$arrayseries10 = array();
		$arrayseries11 = array();
		$arrayseries12 = array();
		foreach ($result as $value) {

			$arraydistricts[] = $value['district'];
			$arrayseries1[] = (int)$value['FP_injections'];
			$arrayseries2[] = (int)$value['Pills_Microlut'];
			$arrayseries3[] = (int)$value['Pills_Microgynon'];
			$arrayseries4[] = (int)$value['IUCD_insertion'];
			$arrayseries5[] = (int)$value['IUCD_Removals'];
			$arrayseries6[] = (int)$value['Implants_insertion'];
			$arrayseries7[] = (int)$value['Implants_Removal'];
			$arrayseries8[] = (int)$value['Sterilization_BTL'];
			$arrayseries9[] = (int)$value['Steriliz_Vasectomy'];
			$arrayseries10[] = (int)$value['NFP'];
			$arrayseries11[] = (int)$value['All_others_FP'];
			$arrayseries12[] = (int)$value['Clints_condom'];

		}
		$arraydistricts = json_encode($arraydistricts);
		$arrayseries1 = json_encode($arrayseries1);
		$arrayseries2 = json_encode($arrayseries2);
		$arrayseries3 = json_encode($arrayseries3);
		$arrayseries4 = json_encode($arrayseries4);
		$arrayseries5 = json_encode($arrayseries5);
		$arrayseries6 = json_encode($arrayseries6);
		$arrayseries7 = json_encode($arrayseries7);
		$arrayseries8 = json_encode($arrayseries8);
		$arrayseries9 = json_encode($arrayseries9);
		$arrayseries10 = json_encode($arrayseries10);
		$arrayseries11 = json_encode($arrayseries11);
		$arrayseries12 = json_encode($arrayseries12);

		$data['arrayN'] = $arraydistricts;
		$data['arrayseries1'] = $arrayseries1;
		$data['arrayseries2'] = $arrayseries2;
		$data['arrayseries3'] = $arrayseries3;
		$data['arrayseries4'] = $arrayseries4;
		$data['arrayseries5'] = $arrayseries5;
		$data['arrayseries6'] = $arrayseries6;
		$data['arrayseries7'] = $arrayseries7;
		$data['arrayseries8'] = $arrayseries8;
		$data['arrayseries9'] = $arrayseries9;
		$data['arrayseries10'] = $arrayseries10;
		$data['arrayseries11'] = $arrayseries11;
		$data['arrayseries12'] = $arrayseries12;
		$data['banner_text'] = "charts";

		$this -> load -> view("chartby_district_v", $data);

	}

	public function drilldown_district() {

		//$commodity = $_POST['getcommodity'];
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT `county`, `district` ,SUM( `FP_injections` ) AS FP_injections, SUM(  `Pills_Microlut` ) AS Pills_Microlut, SUM(  `Pills_Microgynon` ) AS Pills_Microgynon, SUM(  `IUCD_insertion` ) AS IUCD_insertion, SUM( `IUCD_Removals` ) AS IUCD_Removals, SUM(  `Implants_insertion` ) AS Implants_insertion, SUM(  `Implants_Removal` ) AS Implants_Removal, SUM(  `Sterilization_BTL` ) AS Sterilization_BTL, SUM( `Steriliz_Vasectomy` ) AS Steriliz_Vasectomy, SUM(  `NFP` ) AS NFP, SUM(  `All_others_FP` ) AS All_others_FP, SUM(  `Clints_condom` ) AS Clints_condom FROM  `intermediate_districtforecast` GROUP BY  `districtid`  ");

		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		//$result4 = $st4 -> fetchAll(PDO::FETCH_ASSOC);

		$arraycounties = array();
		$arraydistricts = array();
		$arrayseries1 = array();
		$arrayseries2 = array();
		$arrayseries3 = array();
		$arrayseries4 = array();
		$arrayseries5 = array();
		$arrayseries6 = array();
		$arrayseries7 = array();
		$arrayseries8 = array();
		$arrayseries9 = array();
		$arrayseries10 = array();
		$arrayseries11 = array();
		$arrayseries12 = array();
		$array = array();
		foreach ($result as $value) {

			$arraycounties[] = $value['county'];
			$arraydistricts[] = $value['district'];
			$arrayseries1[] = (int)$value['FP_injections'];
			$arrayseries2[] = (int)$value['Pills_Microlut'];
			$arrayseries3[] = (int)$value['Pills_Microgynon'];
			$arrayseries4[] = (int)$value['IUCD_insertion'];
			$arrayseries5[] = (int)$value['IUCD_Removals'];
			$arrayseries6[] = (int)$value['Implants_insertion'];
			$arrayseries7[] = (int)$value['Implants_Removal'];
			$arrayseries8[] = (int)$value['Sterilization_BTL'];
			$arrayseries9[] = (int)$value['Steriliz_Vasectomy'];
			$arrayseries10[] = (int)$value['NFP'];
			$arrayseries11[] = (int)$value['All_others_FP'];
			$arrayseries12[] = (int)$value['Clints_condom'];

			$arraytotals[] = (int)$value['commodity'];

		}
		//echo json_encode($arraycounties);

		$data['banner_text'] = "chart";
		$data['content_view'] = "drilldown_v";
		$this -> load -> view("template", $data);

	}

	public function nationalpie() {

		$year = date("Y");
		$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT SUM(  `FP_injections` ) AS FP_injections, SUM(  `Pills_Microlut` ) AS Pills_Microlut, SUM(  `Pills_Microgynon` ) AS Pills_Microgynon, SUM(  `IUCD_insertion` ) AS IUCD_insertion, SUM(  `IUCD_Removals` ) AS IUCD_Removals, SUM(  `Implants_insertion` ) AS Implants_insertion, SUM(  `Implants_Removal` ) AS Implants_Removal, SUM(  `Sterilization_BTL` ) AS Sterilization_BTL, SUM(  `Steriliz_Vasectomy` ) AS Steriliz_Vasectomy, SUM(  `NFP` ) AS NFP, SUM(  `All_others_FP` ) AS All_others_FP, SUM(  `Clints_condom` ) AS Clints_condom FROM  `mainsummary` WHERE  `Period_UID` LIKE '%$year%' ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);

		foreach ($result as $value) {

			//$arraycommodity[] = $value['FP_injections'];
			$arraycommodity1 = array('FP injections', ((int)$value['FP_injections']) / 4);
			$arraycommodity2 = array('Pills Microlut', ((int)$value['Pills_Microlut']) / 12);
			$arraycommodity3 = array('Pills Microgynon', ((int)$value['Pills_Microgynon']) / 12);
			$arraycommodity4 = array('IUCD insertion', (int)$value['IUCD_insertion']);
			$arraycommodity5 = array('IUCD Removals', (int)$value['IUCD_Removals']);
			$arraycommodity6 = array('Implants insertion', (int)$value['Implants_insertion']);
			$arraycommodity7 = array('Implants Removal', (int)$value['Implants_Removal']);
			$arraycommodity8 = array('Sterilization BTL', (int)$value['Sterilization_BTL']);
			$arraycommodity9 = array('Sterilize Vasectomy', (int)$value['Steriliz_Vasectomy']);
			$arraycommodity10 = array('NFP', (int)$value['NFP']);
			$arraycommodity11 = array('Others FP', (int)$value['All_others_FP']);
			$arraycommodity12 = array('Clints condom', ((int)$value['Clints_condom']) / 120);

		}

		$arraycommodity1 = json_encode($arraycommodity1);
		$arraycommodity2 = json_encode($arraycommodity2);
		$arraycommodity3 = json_encode($arraycommodity3);
		$arraycommodity4 = json_encode($arraycommodity4);
		$arraycommodity5 = json_encode($arraycommodity5);
		$arraycommodity6 = json_encode($arraycommodity6);
		$arraycommodity7 = json_encode($arraycommodity7);
		$arraycommodity8 = json_encode($arraycommodity8);
		$arraycommodity9 = json_encode($arraycommodity9);
		$arraycommodity10 = json_encode($arraycommodity10);
		$arraycommodity11 = json_encode($arraycommodity11);
		$arraycommodity12 = json_encode($arraycommodity12);
		/*echo $arraycommodity1;
		 echo $arraycommodity2;
		 echo $arraycommodity3;
		 echo $arraycommodity4;
		 echo $arraycommodity5;
		 echo $arraycommodity6;
		 echo $arraycommodity7;
		 echo $arraycommodity8;
		 echo $arraycommodity9;
		 echo $arraycommodity10;
		 echo $arraycommodity11;
		 echo $arraycommodity12;*/

		$data['arraycommodity1'] = $arraycommodity1;
		$data['arraycommodity2'] = $arraycommodity2;
		$data['arraycommodity3'] = $arraycommodity3;
		$data['arraycommodity4'] = $arraycommodity4;
		$data['arraycommodity5'] = $arraycommodity5;
		$data['arraycommodity6'] = $arraycommodity6;
		$data['arraycommodity7'] = $arraycommodity7;
		$data['arraycommodity8'] = $arraycommodity8;
		$data['arraycommodity9'] = $arraycommodity9;
		$data['arraycommodity10'] = $arraycommodity10;
		$data['arraycommodity11'] = $arraycommodity11;
		$data['arraycommodity12'] = $arraycommodity12;

		//$data['banner_text'] = "charts";
		//$data['content_view'] = "pieNational_v";
		$this -> load -> view("pieNational_v", $data);

		//$this -> load -> view("pieNational_v", $data);

	}

public function trend_analysis()
{
	$county = $_POST['countytrend'];
	$thedate = $_POST['year_from'];
	$commodity = $_POST['getcommoditytrend'];
	
			$con = Doctrine_Manager::getInstance() -> connection();
		$st = $con -> execute("SELECT  `county` ,  `myMONTH` , SUM(  `Pills_Microgynon` ) AS commodity
FROM  `intermediate_districtforecast` 
WHERE  `countyid` =$county
AND  `myYEAR` =$thedate
GROUP BY  `myMONTH` 
ORDER BY  `myMONTH` ASC ");
		$result = $st -> fetchAll(PDO::FETCH_ASSOC);
		
		$arrayseries1 = array();
		
		//var_dump($result);
		foreach ($result as $value ) {
		
			$arrayseries1[] = (int)$value['commodity'];
			
		}
		
			$arrayseries = json_encode($arrayseries1);
			$data['myarray'] = $arrayseries;
			$this -> load -> view("trend_analyse_v", $data);
		}

public function pipeline_analysis()

{
			
			$data['title'] = "by_district";
		$data['banner_text'] = "menu";
		$data['county'] = Counties::getAll();
		$data['content_view'] = "pipelinestacked_v";
		$this -> load -> view("template", $data);
}

		}
	