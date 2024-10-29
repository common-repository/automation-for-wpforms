<?php 

namespace RNAUTO\DTO;

class StarUnstarActionOptionsDTO extends ActionBaseOptionsDTO{
	/** @var string */
	public $ChangeTo;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='star_unstar';
		$this->ChangeTo='star';
	}
}

