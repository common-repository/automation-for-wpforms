<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class WorkFlowBuilderOptionsDTO extends StoreBase{
	/** @var string */
	public $Name;
	/** @var string */
	public $FormId;
	/** @var string */
	public $Status;
	/** @var RootNodeOptionsDTO */
	public $Node;
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $TriggerType;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->TriggerType='form_submitted';
		$this->Name='';
		$this->FormId='';
		$this->Status='disabled';
		$this->Node=(new RootNodeOptionsDTO())->Merge();
	}
}

