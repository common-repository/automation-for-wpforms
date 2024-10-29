<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class IconOptionsDTO extends StoreBase{
	/** @var string */
	public $ImageType;
	public $Ref;


	public function LoadDefaultValues(){
		$this->ImageType='none';
		$this->Ref=null;
		$this->AddType("Ref","Object");
	}
}

