<?php


namespace RNAUTO\Processors\EntryProcessor\EntryItems;

use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;

;

class CurrencyEntryItem extends EntryItemBase
{
    public $Value;
    public $Amount;
    public $AmountRaw;
    public function SetValue($value)
    {
        $this->Value=$value;
        return $this;
    }



    public function SetAmount($amount)
    {
        $this->Amount=$amount;
        return $this;
    }

    public function SetAmountRaw($amountRaw)
    {
        $this->AmountRaw=$amountRaw;
        return $this;
    }

    public function InitializeWithString($field,$stringValue)
    {
        $this->Field=null;
        $this->Value=$stringValue;

    }

    public function GetHtml($style='standard')
    {
        return html_entity_decode($this->GetText());
    }


    public function GetText($pathId='')
    {
        return $this->Value;
    }

    public function GetType()
    {
        return 'currency';
    }

    public function IsEmpty()
    {
        return trim($this->Value)=='';
    }

}

