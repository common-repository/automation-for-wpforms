<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class EditEntryItemDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $FieldId;
	public $Value;
	/** @var string */
	public $ValueType;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->FieldId='';
		$this->Value=null;
		$this->ValueType='';
		$this->AddType("Value","Object");
	}
}

