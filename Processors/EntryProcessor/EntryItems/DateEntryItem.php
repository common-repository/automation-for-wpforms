<?php /** @noinspection DuplicatedCode */


namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;

class DateEntryItem extends EntryItemBase
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

    public function GetHtml($style = 'standard')
    {
        // TODO: Implement GetHtml() method.
    }

    public function GetType()
    {
        return 'date';
    }

    public function IsEmpty()
    {
        return $this->Unix==0;
    }
}