<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class ActionBaseOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $Type;


	public function LoadDefaultValues(){
		$this->Type='';
		$this->Id=0;
	}
}

