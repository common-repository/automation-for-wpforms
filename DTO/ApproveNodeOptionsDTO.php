<?php 

namespace RNAUTO\DTO;

class ApproveNodeOptionsDTO extends DiagramNodeBaseOptionsDTO{
	public $AssignTo;
	/** @var string */
	public $ApprovalType;
	/** @var Boolean */
	public $DisplayInstructions;
	public $HeaderInstructions;
	/** @var Numeric */
	public $WorkflowStepAfterAccept;
	/** @var Numeric */
	public $WorkflowStepAfterReject;
	/** @var EmailItemDTO */
	public $AssignEmail;
	/** @var EmailItemDTO */
	public $ApproveEmail;
	/** @var EmailItemDTO */
	public $RejectEmail;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='approve';
		$this->Title='Approve';
		$this->AssignTo=[];
		$this->ApprovalType='one';
		$this->DisplayInstructions=false;
		$this->HeaderInstructions=null;
		$this->WorkflowStepAfterAccept=0;
		$this->WorkflowStepAfterReject=0;
		$this->AssignEmail=(new EmailItemDTO())->Merge();
		$this->ApproveEmail=(new EmailItemDTO())->Merge();
		$this->RejectEmail=(new EmailItemDTO())->Merge();
		$this->AddType("AssignTo","Object");
		$this->AddType("HeaderInstructions","Object");
	}
}

