<?php 

namespace RNAUTO\DTO;

class CancelDeleteActionOptionsDTO extends ActionBaseOptionsDTO{
	public $Message;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='cancel_delete';
		$this->Message=null;
		$this->AddType("Message","Object");
	}
}

