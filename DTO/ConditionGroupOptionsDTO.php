<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class ConditionGroupOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var ConditionLineOptionsDTO[] */
	public $ConditionLines;


	public function LoadDefaultValues(){
		$this->ConditionLines=[];
		$this->Id=0;
		$this->AddType("ConditionLines","ConditionLineOptionsDTO");
	}
}

