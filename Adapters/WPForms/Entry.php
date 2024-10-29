<?php

namespace RNAUTO\Adapters\WPForms;

use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use function RNAUTO\Adapters\Core\wpforms;

abstract class Entry
{
    /** @var EntryItemBase[] */
    public $Fields;
    public $EntryId;
    public $CreationDate;
    public $OriginalEntry;
    public $UserId=null;
    public function __construct()
    {
        $this->Fields=[];
    }

    public function AddField($field)
    {
        $field->Entry=$this;
        $this->Fields[]=$field;
    }

    public function SetUserId($userId)
    {
        $this->UserId=$userId;
    }
    public function SetEntryId($entryId)
    {
        $this->EntryId=$entryId;
    }

    public function SetCreationDate($creationDate)
    {
        $this->CreationDate=$creationDate;
    }

    public function SetOriginalEntry($entry)
    {
        $this->OriginalEntry=$entry;
    }

    public abstract function UpdateStatus($status);

    public abstract function SaveUpdate($retriever);

    public abstract function UpdateField($retriever,$field,$value);
    public abstract function AddNote($userId,$content,$type);

    public function GetUserRoles()
    {
        if($this->UserId==null||$this->UserId=='0')
            return [];

        $user_info = get_userdata($this->UserId);
        if ($user_info) {
            return $user_info->roles;
        }

        return [];




    }

}