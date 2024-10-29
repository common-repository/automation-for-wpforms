<?php

namespace RNAUTO\Adapters\WPForms;

use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Settings\Forms\FormSettings;
use RNAUTO\Utilities\Sanitizer;

class WPFormEntryRetriever
{
    /** @var FormSettings */
    public $Form;
    /** @var Entry */
    public $Entry;
    /** @var WPFormsSubLoader */
    public $Loader;
    public $IsTest=false;
    /** @var Entry */
    public $OldEntry;


    public function __construct($loader,$form,$entry,$oldEntry=null)
    {
        $this->Loader=$loader;
        $this->Form=$form;
        $this->Entry=$this->Loader->EntryProcessor->SerializeEntry($entry,$this->Form);
        if($oldEntry!=null)
            $this->OldEntry=$this->Loader->EntryProcessor->SerializeEntry($oldEntry,$this->Form);
    }

    /**
     * @param $field
     * @return EntryItemBase
     */
    public function GetFieldById($field)
    {
        foreach($this->Entry->Fields as $currentEntry)
            if($currentEntry->Field->Id==$field)
            {
                return $currentEntry;
            }

        return null;
    }

    public function GetFieldStringValue($fieldId,$pathId='')
    {
        $field=$this->GetFieldById($fieldId);
        if($field==null)
            return '';

        return $field->GetText($pathId);

    }

    public function GetFieldHtmlValue($id,$pathId)
    {
        $field=$this->GetFieldById($id);
        if($field==null)
            return '';

        return $field->GetHtml($pathId);
    }

    public function GetFields()
    {
        return $this->Entry->Fields;
    }

    public function GetEntryId()
    {
        return $this->Entry->EntryId;
    }
    public function GetFormId()
    {
        if($this->IsTest)
            return 0;

        return $this->Form->Id;
    }

    public function RefreshEntryData()
    {
        $entry=wpforms()->entry->get($this->Entry->EntryId);
        $this->Entry=$this->Loader->EntryProcessor->SerializeEntry($entry,$this->Form);

    }

    public function GetUserId()
    {
        return $this->Entry->UserId;
    }

    public function GetUserRoles()
    {
        return $this->Entry->GetUserRoles();
    }

    public function GetValueById($fieldid)
    {
        $field=$this->GetFieldById($fieldid);
        if($field==null)
            return null;

        return $field->GetValue();
    }
}