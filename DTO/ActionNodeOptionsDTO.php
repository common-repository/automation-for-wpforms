<?php 

namespace RNAUTO\DTO;

class ActionNodeOptionsDTO extends DiagramNodeBaseOptionsDTO{
	public $ActionOptions;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='Action';
		$this->ActionOptions=null;
		$this->AddType("ActionOptions","Object");
	}
}

