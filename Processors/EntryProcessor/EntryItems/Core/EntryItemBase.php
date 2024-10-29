<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 3/22/2019
 * Time: 5:49 AM
 */

namespace RNAUTO\Processors\EntryProcessor\EntryItems\Core;


use RNAUTO\Adapters\WPForms\Entry;
use RNAUTO\Settings\Forms\Fields\FieldSettingsBase;

abstract class EntryItemBase
{
    /** @var FieldSettingsBase */
    public $Field;
    /** @var Entry */
    public $Entry;
    public function __construct()
    {

    }


    public function Initialize($field)
    {
        $this->Field=$field;
        return $this;
    }

    public abstract function GetText($pathId='');



    public function GetNumber(){
        return \floatval($this->GetText());
    }


    public function GetHtml($pathId=''){
        return $this->GetText($pathId);
    }

    public function GetLabel(){
        return $this->Field->Label;
    }
    /**
     * @return string
     */
    public abstract function GetType();

    /**
     * @return Boolean
     */
    public abstract function IsEmpty();

    public function Contains($value)
    {
        if(!\is_array($value))
            $value=[$value];

        foreach($value as $currentValue)
            if($currentValue==$this->GetText())
                return true;
        return false;
    }

    public function GetValue()
    {
        return $this->GetText();
    }


}