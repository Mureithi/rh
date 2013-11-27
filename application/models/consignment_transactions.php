<?php
class Consignment_transactions extends Doctrine_Record {

	public function setTableDefinition() {
				$this->hasColumn('consignment_id', 'integer', 12);
				$this->hasColumn('status', 'varchar', 10);
				$this->hasColumn('quantity', 'integer', 12);
				$this->hasColumn('tr_date', 'date');
				$this->hasColumn('delivery_diff', 'integer', 12);
				$this->hasColumn('user_id', 'integer', 12);
		
	}
	
	public function setUp() {
		$this->setTableName('consignment_transactions');
		
		
		
	}

	public static function getAll()
	{
		$query = Doctrine_Query::create() -> select("*") -> from("Consignment_transactions")->OrderBy("tr_date desc");
		$result = $query -> execute();
		return $result;
	}
}
