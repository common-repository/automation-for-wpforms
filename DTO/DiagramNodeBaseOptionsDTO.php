<?php 

namespace RNAUTO\DTO;

use RNAUTO\DTO\core\StoreBase;

class DiagramNodeBaseOptionsDTO extends StoreBase{
	/** @var Numeric */
	public $Id;
	/** @var string */
	public $Title;
	/** @var string */
	public $Type;
	public $Children;
	/** @var ConditionBaseOptionsDTO */
	public $Condition;


	public function LoadDefaultValues(){
		$this->Id=0;
		$this->Title='';
		$this->Type='';
		$this->Children=[];
		$this->Condition=(new ConditionBaseOptionsDTO())->Merge();
		$this->AddType("Children","Object");
		$this->AddType("Condition","ConditionBaseOptionsDTO");
	}
	public function GetValueFromLoader($property,$value){
		switch($property){
			case "Children":
				return \RNAUTO\DTO\core\Factories\DiagramNodeFactory::GetDiagramNodeList($value);
			default:
				return parent::GetValueFromLoader($property, $value);
		}
	}
}

