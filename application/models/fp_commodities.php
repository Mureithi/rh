<?php
class Fp_commodities extends Doctrine_Record {

	public function setTableDefinition() {
				$this->hasColumn('fpcommodity_name', 'varchar', 5);
				$this->hasColumn('identifier', 'varchar', 5);
				
				
				
		
	}
	
	public function setUp() {
		$this->setTableName('fp_commodities');
		
		
		
	}

	public static function getAllcommodities()
	{
		$query = Doctrine_Query::create() -> select("*") -> from("Fp_commodities")->OrderBy("fpcommodity_name desc");
		$result = $query -> execute();
		return $result;
	}
}
