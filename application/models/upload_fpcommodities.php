<?php
class Upload_fpcommodities extends Doctrine_Record {

	public function setTableDefinition() {
				$this->hasColumn('fpcommodity_name', 'varchar', 5);
				$this->hasColumn('identifier', 'varchar', 5);
				
				
				
		
	}
	
	public function setUp() {
		$this->setTableName('upload_fpcommodities');
		
		
		
	}

	public static function getAllcommodities()
	{
		$query = Doctrine_Query::create() -> select("*") -> from("Upload_fpcommodities")->OrderBy("fpcommodity_name desc");
		$result = $query -> execute();
		return $result;
	}
}
