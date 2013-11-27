<?php
class Store extends Doctrine_Record {

	public function setTableDefinition() {
				$this->hasColumn('store_name', 'varchar', 5);
				
		
	}
	
	public function setUp() {
		$this->setTableName('store');
		
		
		
	}

	public static function getAllstores()
	{
		$query = Doctrine_Query::create() -> select("*") -> from("Store")->OrderBy("id desc");
		$result = $query -> execute();
		return $result;
	}
}
