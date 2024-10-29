<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class TriggerBaseOptionsDTO extends StoreBase{
	/** @var string */
	public $Type;
	/** @var ConditionBaseOptionsDTO */
	public $Condition;


	public function LoadDefaultValues(){
		$this->Condition=(new ConditionBaseOptionsDTO())->Merge();
		$this->Type='';
		$this->AddType("Condition","ConditionBaseOptionsDTO");
	}
}

