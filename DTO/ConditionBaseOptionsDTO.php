<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class ConditionBaseOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	public $Type;
	/** @var ConditionGroupOptionsDTO[] */
	public $ConditionGroups;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Type=ConditionTypeEnumDTO::$Filter;
		$this->ConditionGroups=[];
		$this->AddType("ConditionGroups","ConditionGroupOptionsDTO");
	}
}

