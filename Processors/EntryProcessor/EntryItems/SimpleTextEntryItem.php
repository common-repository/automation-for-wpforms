<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 3/22/2019
 * Time: 5:50 AM
 */

namespace RNAUTO\Processors\EntryProcessor\EntryItems;



use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use Twig\Markup;

class SimpleTextEntryItem extends EntryItemBase
{
    public $Value;
    public function SetValue($value)
    {
        $this->Value=$value;
        return $this;
    }

    public function InitializeWithString($field,$stringValue)
    {
        $this->Field=null;
        $this->Value=$stringValue;

    }


    public function GetText($pathId='')
    {
        return $this->Value;
    }

    public function GetHtml($pathId = '')
    {
        return new Markup(nl2br($this->GetText($pathId)),'UTF-8');
    }


    public function GetType()
    {
        return 'text';
    }

    public function IsEmpty()
    {
        return trim($this->Value)=='';
    }




}