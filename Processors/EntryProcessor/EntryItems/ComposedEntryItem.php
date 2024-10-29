<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 3/22/2019
 * Time: 5:50 AM
 */

namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Settings\Forms\Fields\ComposedFieldSettings;
use RNAUTO\Utilities\Sanitizer;
use Twig\Markup;

class ComposedEntryItem extends EntryItemBase
{
    public $Value;
    /** @var ComposedFieldSettings */
    public $Field;
    public $FormattedValue='';
    public function SetValue($value)
    {
        $this->Value=$value;
        return $this;
    }

    public function SetFormattedValue($value)
    {
        $this->FormattedValue=$value;
        return $this;
    }

    public function InitializeWithString($field,$stringValue)
    {
        $this->Field=null;
        $this->Value=$stringValue;

    }

    public function GetHtml($pathId='')
    {
        return new Markup(nl2br($this->GetText($pathId)),'UTF-8');
    }


    public function GetText($pathId='')
    {
        $text='';
        if($pathId==''||$pathId=='Value')
        {
            if($this->FormattedValue!='')
                return $this->FormattedValue;

            foreach ($this->Field->Rows as $currentRow)
            {
                foreach ($currentRow->Items as $currentItem)
                    $text = $this->AddItem($currentItem, $this->Value, $text);

            }
        }else{
            foreach ($this->Field->Rows as $currentRow)
            {
                foreach ($currentRow->Items as $currentItem)
                    if($currentItem->Id==$pathId)
                        $text=Sanitizer::GetStringValueFromPath($this->Value,$currentItem->Path);


            }
        }

        return $text;
    }


    private function AddItem($currentItem, $value,$text) {
        foreach($currentItem->Path as $currentPath )
        {
            if(is_object($value))
            {
                if (!isset($value->$currentPath))
                {
                    $value = '';
                    break;
                }
                $value=$value->$currentPath;
            }else
            {
                if (!isset($value[$currentPath]))
                {
                    $value = '';
                    break;
                }
                $value=$value[$currentPath];
            }
        }

        if(\is_object($value)||\is_array($value))
            $value='';
        $value=\strval($value);

        if($value=='')
            return $text;

        if($text!='')
        {
            if($currentItem->AddCommaBefore)
                $text.="\n";
            else
                $text.=' ';
        }

        $text.=$value;
        return $text;

    }

    public function GetItemValue($itemId)
    {
        $value=$this->Value;
        foreach($this->Field->Rows as $currentRow)
            foreach($currentRow->Items as $currentItem)
            {
                if($currentItem->Id==$itemId)
                {
                    foreach($currentItem->Path as $currentPath )
                    {

                        if(is_array($value))
                        {
                            if(isset($value[$currentPath]))
                                $value=$value[$currentPath];
                            else
                                return null;
                        }else{
                            if(isset($value->{$currentPath}))
                                $value=$value->{$currentPath};
                            else
                                return null;
                        }

                    }

                    return $value;
                }

            }

        return null;
    }


    public function GetType()
    {
        return 'composed';
    }

    public function IsEmpty()
    {
        foreach($this->Field->Rows as $currentRow)
            foreach($currentRow->Items as $currentItem)
            {
                $value = $this->GetItemValue($currentItem->Id);

                if ($value != null && trim($value) != '')
                    return false;
            }

        return true;
    }
}