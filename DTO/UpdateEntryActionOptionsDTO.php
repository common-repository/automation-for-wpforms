<?php 

namespace RNAUTO\DTO;

class UpdateEntryActionOptionsDTO extends ActionBaseOptionsDTO{
	/** @var EditEntryItemDTO[] */
	public $FieldsToEdit;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->FieldsToEdit=[];
		$this->Type='update_entry';
		$this->AddType("FieldsToEdit","EditEntryItemDTO");
	}
}

