<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class AutomationBuilderOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $Name;
	/** @var string */
	public $FormId;
	/** @var string */
	public $Status;
	/** @var TriggerBaseOptionsDTO */
	public $Trigger;
	/** @var ActionBaseOptionsDTO[] */
	public $Actions;
	/** @var LinkOptionsDTO */
	public $LinkOptions;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Name='';
		$this->FormId='';
		$this->Status='disabled';
		$this->Trigger=(new TriggerBaseOptionsDTO())->Merge();
		$this->Actions=[];
		$this->LinkOptions=(new LinkOptionsDTO())->Merge();
		$this->AddType("Trigger","TriggerBaseOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Actions":
				return \RNAUTO\DTO\core\Factories\ActionFactory::GetActionArray($value);
			case "Trigger":
				return \RNAUTO\DTO\core\Factories\TriggerFactory::GetTrigger($value);
		}
	}
}

