<?php
class Facilities extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('facility_code', 'varchar',30);
		$this -> hasColumn('facility_name', 'varchar',30);
		$this -> hasColumn('district', 'varchar',30);
		$this->hasColumn('drawing_rights','text');
	}

	public function setUp() {
		$this -> setTableName('facilities');
		$this -> hasOne('facility_code as Code', array('local' => 'facility_code', 'foreign' => 'facilityCode'));
		$this -> hasOne('facility_code as Coder', array('local' => 'facility_code', 'foreign' => 'facility_code'));
		$this -> hasOne('facility_code as Codes', array('local' => 'facility_code', 'foreign' => 'facility'));
		$this -> hasOne('district as facility_district', array('local' => 'district', 'foreign' => 'id'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("districts");
		$drugs = $query -> execute();
		return $drugs;
	}
	public static function getFacilities($district){
		$query = Doctrine_Query::create() -> select("*") -> from("facilities")->where("district='$district'")->OrderBy("facility_name asc");
		
		$drugs = $query -> execute();
		return $drugs;
	}
	
	public static function get_d_facility($district){
		'SELECT unique facilities.facility_name, user.fname, user.lname, user.telephone
FROM facilities, user
WHERE facilities.district ='.$district.'
AND user.district ='.$district.'
AND user.facility = facilities.facility_code
AND user.usertype_id =2';
		
		$q = Doctrine_Manager::getInstance()->getCurrentConnection();
$result = $q->execute(" SELECT user.email, facilities.facility_code, facilities.facility_name, user.fname, user.lname, user.telephone
FROM facilities, user
WHERE facilities.district =  '$district'
AND user.district =  '$district'
AND user.facility = facilities.facility_code
AND user.status =  '1'
AND (
user.usertype_id =5
OR user.usertype_id =2
)
GROUP BY user.facility");

		return $result;
		
	}
	
	/*************************getting the facility name *******************/
	public static function get_facility_name($facility_code){
	$query=Doctrine_Query::create()->select('facility_name')->from('facilities')->where("facility_code='$facility_code'");
	$result=$query->execute();
	return $result[0];
	}
	
	/********************getting the facility owners  count*************/
	public static function get_owner_count() {
		$query = Doctrine_Query::create() -> select("COUNT(facility_code) as count , owner ") -> from("facilities")->groupby("owner")->ORDERBY ('count ASC' );
		$drugs = $query -> execute();
		return $drugs;
	}
	
}
