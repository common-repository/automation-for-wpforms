<?php /** @noinspection DuplicatedCode */


namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;

class TimeEntryItem extends EntryItemBase
{
    public $Unix;
    public $Value;


    public function GetText($pathId='')
    {
        return $this->Value;

    }

    public function SetUnix($value)
    {
        $this->Unix=$value;
        return $this;
    }
    public function SetValue($value)
    {
        $this->Value=$value;
        return $this;
    }

    public function GetType()
    {
        return 'time';
    }



    public function IsEmpty()
    {
        return $this->Unix==0;
    }
}