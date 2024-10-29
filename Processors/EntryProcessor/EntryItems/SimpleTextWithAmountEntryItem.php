<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 3/22/2019
 * Time: 5:50 AM
 */

namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use rnpagebuilder\core\Integration\Processors\Entry\HTMLFormatters\BasicPHPFormatter;

class SimpleTextWithAmountEntryItem extends EntryItemBase
{
    public $Value;
    public $Amount;
    public function SetValue($value,$amount)
    {
        $this->Value=$value;
        $this->Amount=$amount;
        return $this;
    }
    public function GetText($pathId='')
    {
        return $this->Value;
    }


    public function GetType()
    {
        return 'textwithamount';
    }

    public function IsEmpty()
    {
        return $this->Value=='';
    }




}