<?php 

namespace RNAUTO\DTO;

class AddNoteActionOptionsDTO extends ActionBaseOptionsDTO{
	public $Note;
	/** @var string */
	public $NoteType;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='add_note';
		$this->Note=null;
		$this->NoteType='note';
		$this->AddType("Note","Object");
	}
}

