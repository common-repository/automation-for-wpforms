<?php 

namespace RNAUTO\DTO;

class ChangeStatusActionOptionsDTO extends ActionBaseOptionsDTO{
	/** @var string */
	public $Status;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Status='completed';
		$this->Type='change_status';
	}
}

