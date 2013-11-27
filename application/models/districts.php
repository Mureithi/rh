<?php
class Districts extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('district', 'varchar',30);
		$this -> hasColumn('county', 'varchar',30);	
	}

	public function setUp() {
		$this -> setTableName('districts');
		$this -> hasOne('counties as district_county', array('local' => 'county', 'foreign' => 'id'));
		$this -> hasMany('facilities as facility_district', array('local' => 'id', 'foreign' => 'district'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("districts");
		$drugs = $query -> execute();
		return $drugs;
	}
	public static function getDistrict($county){
		$query = Doctrine_Query::create() -> select("*") -> from("districts")->where("county='$county'");
		$drugs = $query -> execute();
		return $drugs;
	}
}
