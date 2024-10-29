<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class LinkOptionsDTO extends StoreBase{
	/** @var Boolean */
	public $RequireConfirmation;
	/** @var Boolean */
	public $IncludeOnEntriesScreen;
	public $ConfirmationMessage;
	public $SuccessMessage;
	public $ErrorMessage;


	public function LoadDefaultValues(){
		$this->RequireConfirmation=false;
		$this->ConfirmationMessage=null;
		$this->SuccessMessage=null;
		$this->ErrorMessage=null;
		$this->IncludeOnEntriesScreen=false;
		$this->AddType("ConfirmationMessage","Object");
		$this->AddType("SuccessMessage","Object");
		$this->AddType("ErrorMessage","Object");
	}
}

