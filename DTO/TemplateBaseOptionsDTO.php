<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class TemplateBaseOptionsDTO extends StoreBase{
	/** @var string */
	public $Id;


	public function LoadDefaultValues(){
		$this->Id='';
	}
}

