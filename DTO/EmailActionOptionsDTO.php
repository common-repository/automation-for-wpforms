<?php 

namespace RNAUTO\DTO;

class EmailActionOptionsDTO extends ActionBaseOptionsDTO{
	public $Email;
	/** @var EmailAddressDTO[] */
	public $To;
	/** @var EmailAddressDTO[] */
	public $ReplyTo;
	/** @var EmailAddressDTO[] */
	public $CC;
	/** @var EmailAddressDTO[] */
	public $BCC;
	public $Subject;
	/** @var string */
	public $FromName;
	/** @var string */
	public $FromEmailAddress;


	public function LoadDefaultValues(){
		parent::LoadDefaultValues();
		$this->Type='send_email';
		$this->To=[];
		$this->ReplyTo=[];
		$this->CC=[];
		$this->BCC=[];
		$this->Subject=null;
		$this->FromName='';
		$this->FromEmailAddress='';
		$this->Email=null;
		$this->AddType("Email","Object");
		$this->AddType("To","EmailAddressDTO");
		$this->AddType("ReplyTo","EmailAddressDTO");
		$this->AddType("CC","EmailAddressDTO");
		$this->AddType("BCC","EmailAddressDTO");
		$this->AddType("Subject","Object");
	}
}

