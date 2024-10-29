<?php 

namespace RNAUTO\DTO;

class CancelSubmissionActionOptionsDTO extends ActionBaseOptionsDTO{
	public $Message;
	/** @var string */
	public $ErrorLocation;
	/** @var String[] */
	public $Fields;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='cancel_submission';
		$this->Message=null;
		$this->ErrorLocation='Footer';
		$this->Fields=[];
		$this->AddType("Message","Object");
		$this->AddType("Fields","String");
	}
}

