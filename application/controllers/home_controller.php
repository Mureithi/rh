<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Home_Controller extends MY_Controller {
	function __construct() {
		parent::__construct();
		$this -> load -> helper(array('form', 'url'));
	}

	public function index() {

		$this -> home();
	}

	public function home() {

		$data['title'] = "System Home";
		$access_level = $this -> session -> userdata('user_indicator');
		$facility_c=$this -> session -> userdata('news');
		$data['name_facility']=User::getUsers($facility_c);
		$data['commodity'] = Upload_fpcommodities::getAllcommodities();
		$data['county'] = Counties::getAll();
		if($access_level == "user"){
			
				
			$data['content_view'] = "user_home";
			 
		}
		else if($access_level == "Super_admin"){
			
				
		$data['title'] = "System Home";
		$access_level = $this -> session -> userdata('user_indicator');
		$facility_c=$this -> session -> userdata('news');
		$data['name_facility']=User::getUsers($facility_c);
		$data['commodity'] = Upload_fpcommodities::getAllcommodities();
		$data['county'] = Counties::getAll();
		$data['content_view'] = "admin_home";


		}
			
		$data['banner_text'] = "System Home";
		$data['link'] = "home";
		$this -> load -> view("template", $data);

	}
	
	

}
