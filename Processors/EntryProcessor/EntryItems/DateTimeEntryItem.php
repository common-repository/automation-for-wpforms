<?php /** @noinspection DuplicatedCode */


namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;

class DateTimeEntryItem extends EntryItemBase
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
        return 'datetime';
    }

    public function InternalGetDetails($base)
    {

        if($this->Unix==0)
            return array();

        $base->NumericValue=$this->Unix;
        $base->DateValue=date('c',$this->Unix);
        $base->Value=$this->Value;

        return [$base];
    }


    public function IsEmpty()
    {
        return $this->Unix==0;
    }
}