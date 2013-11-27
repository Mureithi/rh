<?php
class Drh_fpc_by_facility extends Doctrine_Record {
	public function setTableDefinition() {
		$this->hasColumn('period_id', 'integer', 6);
		$this->hasColumn('organization_unit_id', 'integer', 6);
		$this->hasColumn('period_uid', 'integer', 6);
		$this->hasColumn('organisation_unit_uid', 'varchar', 25);
		$this->hasColumn('period', 'varchar', 10);
		$this->hasColumn('organisation_unit_code', 'integer', 10);
		$this->hasColumn('period_code', 'integer', 6);
		$this->hasColumn('organisation_unit_code', 'integer', 10);
		$this->hasColumn('period_description', 'varchar', 50);
		$this->hasColumn('organization_unit_description', 'varchar', 100);
		$this->hasColumn('reporting_month', 'varchar', 10);
		$this->hasColumn('organization_unit_parameter', 'varchar', 25);
		$this->hasColumn('organization_unit_is_parent', 'varchar', 5);
		$this->hasColumn('fp_injections', 'int', 5);
		$this->hasColumn('pills_microlut', 'int', 5);
		$this->hasColumn('Pills_Microgynon', 'int', 5);
		$this->hasColumn('IUCD_insertion', 'int', 5);
		$this->hasColumn('IUCD_Removals', 'int', 5);
		$this->hasColumn('Implants_insertion', 'int', 5);
		$this->hasColumn('Implants_Removal', 'int', 5);
		$this->hasColumn('Sterilization_BTL', 'int', 5);
		$this->hasColumn('Steriliz_Vasectomy', 'int', 5);
		$this->hasColumn('NFP', 'int', 5);
		$this->hasColumn('All_others_FP', 'int', 5);
		$this->hasColumn('Clints_condom', 'int', 5);
		
			
	}

	public function setUp() {
		$this -> setTableName('drh_fpc_by_facility');
		
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("Drh_fpc_by_facility")-> OrderBy("");
		$dataset = $query -> execute();
		return $dataset;
	}

}
