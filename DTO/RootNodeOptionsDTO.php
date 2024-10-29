<?php 

namespace RNAUTO\DTO;

class RootNodeOptionsDTO extends DiagramNodeBaseOptionsDTO{


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='Root';
	}
}

