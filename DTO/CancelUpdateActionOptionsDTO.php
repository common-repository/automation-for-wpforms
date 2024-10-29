<?php 

namespace RNAUTO\DTO;

class CancelUpdateActionOptionsDTO extends ActionBaseOptionsDTO{
	public $Message;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='cancel_update';
		$this->Message=null;
		$this->AddType("Message","Object");
	}
}

