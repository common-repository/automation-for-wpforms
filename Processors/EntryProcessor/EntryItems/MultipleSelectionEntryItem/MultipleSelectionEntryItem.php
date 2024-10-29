<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 3/22/2019
 * Time: 5:56 AM
 */

namespace RNAUTO\Processors\EntryProcessor\EntryItems\MultipleSelectionEntryItem;



use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Settings\Forms\Fields\MultipleOptionsFieldSettings;
use Twig\Markup;

class MultipleSelectionEntryItem extends EntryItemBase
{
    public $Values=[];
    /** @var MultipleSelectionValueItem[] */
    public $Items=[];




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

    public function GetOptionLabel($value='')
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

    public function AddItem($value,$amount=null)
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

    public function GetHtml($pathId = '')
    {
        return new Markup(nl2br($this->GetText($pathId)),'UTF-8');
    }


    public function GetType()
    {
        return 'multiple';
    }

    public function IsEmpty()
    {
        return count($this->Items)==0;
    }

    public function GetValue()
    {
        return $this->Values;
    }
}
