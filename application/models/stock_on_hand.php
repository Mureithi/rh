<?php
class Stock_on_hand extends Doctrine_Record {

	public function setTableDefinition() {
				$this->hasColumn('store_id', 'integer', 10);
				$this->hasColumn('commodity_id', 'integer', 10);
				$this->hasColumn('quantity_on_hand', 'integer', 12);
				$this->hasColumn('date_as_of', 'date');
				$this->hasColumn('user_id', 'integer', 10);
				
		
	}
	
	public function setUp() {
		$this->setTableName('stock_on_hand');
				
	}

	public static function getAllstock()
	{
		$query = Doctrine_Query::create() -> select("*") -> from("Stock_on_hand")->OrderBy("commodity_id desc");
		$result = $query -> execute();
		return $result;
	}
}
