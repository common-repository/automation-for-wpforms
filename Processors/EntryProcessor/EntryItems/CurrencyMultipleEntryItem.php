<?php

namespace RNAUTO\Processors\EntryProcessor\EntryItems;

use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Processors\EntryProcessor\EntryItems\MultipleSelectionEntryItem\MultipleSelectionEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\MultipleSelectionEntryItem\MultipleSelectionValueItem;
use Twig\Markup;

class CurrencyMultipleEntryItem extends EntryItemBase
{
    public $Values=[];
    /** @var MultipleSelectionValueItem[] */
    public $Items=[];
    public $Amount='';
    public $AmountRaw='';

    public function SetAmount($amount)
    {
        $this->Amount=$amount;
        return $this;
    }

    public function SetAmountRaw($amount)
    {
        $this->AmountRaw=$amount;
        return $this;
    }



    public function SetValue($value,$amount=0)
    {
        $this->Values=[];
        if(\is_array($value))
        {
            $this->Values =[];
            foreach($value as $currentValue)
            {

                $currentValue=$this->GetOptionLabel($currentValue);
                $this->Values[]=$currentValue;
                $this->Items[]=(new MultipleSelectionValueItem())->InitializeWithValues($currentValue,$amount);
            }
        }
        else
        {
            if($value=='')
                return $this;

            $value=$this->GetOptionLabel($value);
            $this->Values[] = $value;
            $this->Items[] = (new MultipleSelectionValueItem())->InitializeWithValues($value, $amount);
        }

        return $this;
    }

    public function GetOptionLabel($value)
    {
        if(isset($this->Field->Items))
        {
            foreach($this->Field->Items as $item)
            {
                if($item->Value==$value)
                    return $item->Label;
            }
        }

        return $value;

    }

    public function AddItem($value,$amount)
    {
        $value=$this->GetOptionLabel($value);
        $this->Items[]=(new MultipleSelectionValueItem())->InitializeWithValues($value,$amount);
        if($this->Values==null)
            $this->Values=[];
        $this->Values[]=$value;

    }
    public function GetAmount(){
        if(count($this->Items)==0)
            return 0;
        return $this->Items[0]->Amount;
    }

    public function Contains($value)
    {
        if(!\is_array($value))
            $value=[$value];

        foreach($value as $currentValue)
            if( \in_array($currentValue,$this->Values))
                return true;
        return false;
    }


    public function GetText($pathId='')
    {
        return \implode("\n",$this->Values);

    }

    public function GetHtml($style='standard')
    {
        return new Markup(nl2br(html_entity_decode($this->GetText())),"UTF-8");
    }

    public function GetType()
    {
        return 'curmultiple';
    }

    public function IsEmpty()
    {
        return count($this->Items)==0;
    }

}