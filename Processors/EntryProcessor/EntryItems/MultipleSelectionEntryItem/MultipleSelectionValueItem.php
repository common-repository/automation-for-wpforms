<?php


namespace RNAUTO\Processors\EntryProcessor\EntryItems\MultipleSelectionEntryItem;


class MultipleSelectionValueItem{
    public $Value='';
    public $Amount=0;
    public $RawAmount=0;

    public function InitializeWithValues($value,$amount,$rawAmount=0)
    {
        $this->Value=$value;
        $this->Amount=$amount;
        $this->RawAmount=$rawAmount;
        return $this;

    }

}