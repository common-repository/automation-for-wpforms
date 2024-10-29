<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class EmailAddressDTO extends StoreBase{
	public $Type;
	/** @var string */
	public $Value;
	/** @var EmailMappingDTO[] */
	public $EmailMapping;


	public function LoadDefaultValues(){
		$this->Value='';
		$this->Type=EmailAddressEnumDTO::$Fixed;
		$this->EmailMapping=[];
		$this->AddType("EmailMapping","EmailMappingDTO");
	}
}

