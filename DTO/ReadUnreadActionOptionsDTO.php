<?php 

namespace RNAUTO\DTO;

class ReadUnreadActionOptionsDTO extends ActionBaseOptionsDTO{
	/** @var string */
	public $ChangeTo;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='read_unread';
		$this->ChangeTo='read';
	}
}

