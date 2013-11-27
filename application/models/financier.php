<?php
class Financier extends Doctrine_Record {

	public function setTableDefinition() {
				$this->hasColumn('financier_name', 'varchar', 20);
				
	}
	
	public function setUp() {
		$this->setTableName('financier');
		
		
		
	}

	public static function getAllfinanciers()
	{
		$query = Doctrine_Query::create() -> select("*") -> from("Financier")->OrderBy("id desc");
		$result = $query -> execute();
		return $result;
	}
}
