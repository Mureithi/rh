<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		
		$this->load->helper(array('form','url'));
		$this->load->library('form_validation');
	}
public function change_password(){
	$this -> load -> view("ajax_view/change_password");
}
	public function index() {
		$data = array();
		$data['title'] = "Login";
		$this -> load -> view("login_v", $data);
	}

	public function login() {
		$data = array();
		$data['title'] = "Login";
		$this -> load -> view("login_v", $data);
	}
	public function logout(){
		$data = array();
		$this->session->sess_destroy();
		$data['title'] = "Login";
		
		
		$this -> load -> view("login_v", $data);
	}

public function submit() {
		$username=$_POST['username'];
		$password=$_POST['password'];
		if ($this->_submit_validate() === FALSE) {
			$this->index();
			return;
			
		}
		
		$reply=User::login($username, $password);
		$n=$reply->toArray();
		//echo($n['username']);

		$myvalue=$n['usertype_id'];
		$namer=$n['fname'];
		$id_d=$n['id'];
		$inames=$n['lname'];
		$disto=$n['district'];
		$faci=$n['facility'];
		$phone=$n['telephone'];
	    $user_id=$n['id'];
		if($faci>0){
		$myobj = Doctrine::getTable('facilities')->findOneByfacility_code($faci);
        $facility_name=$myobj->facility_name ;	
		$drawing_rights=$myobj->drawing_rights;
		}
        
		if($disto>0){
		$myobj = Doctrine::getTable('districts')->find($disto);
        $dist=$myobj->district;	
		}
		$moh="MOH Official";
		$moh_user="MOH User";
		$kemsa="KEMSA Representative";
		
		
       if ($myvalue ==1) {
       		$session_data = array('full_name' =>$moh ,'user_id'=>$user_id,'user_indicator'=>"Super_admin",'names'=>$namer,'inames'=>$inames,'identity'=>$id_d,'news'=>$faci,'district1'=>$disto);	
		} else if($myvalue==4){
			$session_data = array('full_name' =>$moh_user ,'user_id'=>$user_id,'user_indicator'=>"moh_user",'names'=>$namer,'inames'=>$inames,'identity'=>$id_d,'news'=>$faci,'district1'=>$disto);
		}else if($myvalue==5){
			$session_data = array('full_name' =>$facility_name ,'user_id'=>$user_id,'user_indicator'=>"fac_user",'names'=>$namer,'inames'=>$inames,'identity'=>$id_d,'news'=>$faci,'district1'=>$disto, 'drawing_rights'=>$drawing_rights);
		}else if($myvalue ==3){
			$session_data = array('user_db_id'=>$user_id,'full_name' =>$dist ,'user_id'=>$user_id,'user_indicator'=>"district",'names'=>$namer,'inames'=>$inames,'identity'=>$id_d,'news'=>$faci, 'district'=>$n['district'],'district1'=>$disto);
		}else if($myvalue ==6){
			$session_data = array('full_name' =>$kemsa,'user_id'=>$user_id,'user_indicator'=>"kemsa",'names'=>$namer,'inames'=>$inames,'identity'=>$id_d,'news'=>$faci,'district1'=>$disto);
		}	
		else if($myvalue ==2)  {
			$session_data = array('user_db_id'=>$user_id,'full_name' =>$facility_name,'user_id'=>$user_id,'user_indicator'=>"facility",'names'=>$namer,'inames'=>$inames,'identity'=>$id_d,'news'=>$faci,'district1'=>$disto,'drawing_rights'=>$drawing_rights);
		}					
		$this -> session -> set_userdata($session_data);
		
		$u1=new Log();
		$action='Logged In';
		$u1->user_id=$this -> session -> userdata('identity');
		$u1->action=$action;
		$u1->save();
		
		redirect("home_controller");
	
        
   
}

	private function _submit_validate() {

		$this->form_validation->set_rules('username', 'Username',
			'trim|required|callback_authenticate');

		$this->form_validation->set_rules('password', 'Password',
			'trim|required');

		$this->form_validation->set_message('authenticate','Invalid login. Please try again.');

		return $this->form_validation->run();

	}

	public function authenticate() {

		// get User object by username
		if ($u = Doctrine::getTable('User')->findOneByUsername($this->input->post('username'))) {

			// this mutates (encrypts) the input password
			$u_input = new User();
			$u_input->password = $this->input->post('password');

			// password match (comparing encrypted passwords)
			if ($u->password == $u_input->password) {
				unset($u_input);
				return TRUE;
			}
			unset($u_input);
		}

		return FALSE;
	}
	
	
public function forgotpassword() {
		$data['title'] = "Register Users";
		$data['content_view'] = "moh/signup_v";
		$data['banner_text'] = "Register";
		//$data['r_name']='';
		$data['level_l'] = Access_level::getAll();
		$data['counties'] = Counties::getAll();
		
		$this -> load -> view("template", $data);
	}
	
	public function sign_up() {
		$data['title'] = "Register Users";
		$data['content_view'] = "moh/registeruser_moh";
		$data['banner_text'] = "Register";
		//$data['r_name']='';
		$data['level_l'] = Access_level::getAll();
		$data['counties'] = Counties::getAll();
		
		$this -> load -> view("template", $data);
	}
	
	//users list
	public function users_facility(){
		$facility=$this -> session -> userdata('news');
		$id=$this -> session -> userdata('user_db_id');
		$data['title'] = "View Users";
		$data['content_view'] = "users_facility_v";
		$data['banner_text'] = "Facility Users";
		$data['result'] = User::getAll2($facility,$id);
		$data['quick_link'] = "users_facility_v";
		$data['counties'] = Counties::getAll();
		$this -> load -> view("template", $data);
	
	}
	public function users_district(){
		$district=$this -> session -> userdata('district1');
		$id=$this -> session -> userdata('user_db_id');
		$data['title'] = "View Users";
		$data['content_view'] = "district/users_district_v";
		$data['banner_text'] = "District Users";
		$data['result'] = User::getAll5($district, $id);
		$data['counties'] = Counties::getAll();
		$this -> load -> view("template", $data);
	}
	

	public function base_params($data) {
		$this -> load -> view("template", $data);
	}
	
	public function moh_deactive(){
		$status=0;		
		$use_id=$this->uri->segment(3);
		$state=Doctrine::getTable('user')->findOneById($use_id);
		$state->status=$status;
		$state->save();
		
		$data['banner_text'] = "All Users";
		$data['title'] = "View Users";
		$data['content_view'] = "users_moh_v";
		$data['result'] = User::getAll();
		$data['counties'] = Counties::getAll();
		$this -> load -> view("template", $data);
	}
	public function moh_active(){
		$status=1;		
		$use_id=$this->uri->segment(3);
		$state=Doctrine::getTable('user')->findOneById($use_id);
		$state->status=$status;
		$state->save();
		
		$data['banner_text'] = "All Users";
		$data['title'] = "View Users";
		$data['content_view'] = "users_moh_v";
		$data['result'] = User::getAll();
		$data['counties'] = Counties::getAll();
		$this -> load -> view("template", $data);
	}
	
	//validates usernames
	public function username(){
		//$username=$_POST['username'];
		//for ajax
		$desc=$_POST['username'];
		$describe=user::getUsername($desc);
		$list="";
		foreach ($describe as $describe) {
			$list.=$describe->username;
		}
		echo $list;
	}
	public function user_reset(){
		$id=$this->uri->segment(3);
		$password='hcmp2012';
		
		$pass1=Doctrine::getTable('user')->findOneById($id);
		$name=$pass1->fname;
		$lname=$pass1->lname;
		$email=$pass1->email;
		$pass=Doctrine::getTable('user')->findOneById($id);
		//echo $pass->password
		$pass->password=$password;
		$pass->save();
		
		$fromm='hcmpkenya@gmail.com';
		$messages='Hallo '.$name .', Your password has been reset Please use '.$password.'. Please login and change. 
		
		Thank you';
	
  		$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'ssl://smtp.googlemail.com',
  'smtp_port' => 465,
  'smtp_user' => 'hcmpkenya@gmail.com', // change it to yours
  'smtp_pass' => 'healthkenya', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
); 
		
        //$this->email->initialize($config);
		$this->load->library('email', $config);
 
  		$this->email->set_newline("\r\n");
  		$this->email->from($fromm,'Health Commodities Management Platform'); // change it to yours
  		$this->email->to($email); // change it to yours
  		
  		$this->email->subject('Password Reset:'.$name.' '.$lname);
 		$this->email->message($messages);
 
  if($this->email->send())
 {

 }
 else
{
 show_error($this->email->print_debugger());
}
		$this->session->sess_destroy();
		$data = array();
		$data['title'] = "System Login";
		
		$this -> load -> view("login_v", $data);
	}
	public function edit_user(){
		$use_id=$this->uri->segment(3);
		//echo $use_id;
		
		$data['title'] = "Reset Details";
		$data['content_view'] = "detail_reset_v";
		$data['banner_text'] = "Reset Details";
		$data['users_det']=User::getAllUser($use_id);
		$data['level_l'] = Access_level::getAll1();
		$data['counties'] = Counties::getAll();
		$data['link'] = "details_reset_v";
		$this -> load -> view("template", $data);
	}
	public function edit_facility(){
		$use_id=$_POST['user_id'];
		//echo $use_id;
		/*$myobj = Doctrine::getTable('user')->findOneById($use_id);
    	$disto=$myobj->district;
		$faci=$myobj->facility;
		$type=$myobj->usertype_id;
		$data['counties'] = Counties::getAll3($type);
		echo $faci;*/
		$fname=$_POST['fname'];
		$lname=$_POST['lname'];
		$tell=$_POST['tell'];
		$email=$_POST['email'];
		$username=$_POST['username'];
		$type=$_POST['type'];

		//$use_id=$_POST['user_id'];
		$state=Doctrine::getTable('user')->findOneById($use_id);
		$state->fname=$fname;
		$state->lname=$lname;
		$state->telephone=$tell;
		$state->email=$email;
		$state->username=$username;
		$state->usertype_id=$type;
		
		$state->save();
		
		$facility=$this -> session -> userdata('news');
		$id=$this -> session -> userdata('user_db_id');
		$data['title'] = "View Users";
		$data['content_view'] = "users_facility_v";
		$data['banner_text'] = "Facility Users";
		$data['result'] = User::getAll2($facility,$id);
		$data['quick_link'] = "users_facility_v";
		$data['counties'] = Counties::getAll();
		$this -> load -> view("template", $data);
	}

}
