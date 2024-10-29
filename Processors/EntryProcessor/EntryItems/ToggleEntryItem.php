<?php


namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;

class ToggleEntryItem extends EntryItemBase
{
    public  $IsChecked=null;


    public function SetIsChecked($checked)
    {
        $this->IsChecked=$checked;
        return $this;
    }


    public function GetText($pathId='')
    {
        if($this->IsChecked)
            return 'True';
        return 'False';
    }

    public function GetType()
    {
        return 'toggle';
    }

    public function IsEmpty()
    {
        return $this->IsChecked===null;
    }
}