<?php
class Consignment_details extends Doctrine_Record {

	public function setTableDefinition() {
				$this->hasColumn('commodity_id', 'integer', 10);
				$this->hasColumn('procuring_agency_id', 'integer', 10);
				$this->hasColumn('financier_id', 'integer', 10);
				$this->hasColumn('qty_expected', 'integer', 12);
				$this->hasColumn('date_expected', 'date');
				$this->hasColumn('status', 'varchar', 20);
				$this->hasColumn('user_id', 'integer', 12);
						
				
		
	}
	
	public function setUp() {
		$this->setTableName('consignment_details');
		
		
		
	}

	public static function getAllConsignment_details()
	{
		$query = Doctrine_Query::create() -> select("*") -> from("Consignment_details")->OrderBy("commodity_id desc");
		$result = $query -> execute();
		return $result;
	}
}
