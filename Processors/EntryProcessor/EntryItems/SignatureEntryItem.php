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

class SignatureEntryItem extends EntryItemBase
{
    public $Value;
    public function SetValue($value)
    {
        $this->Value=$value;
        return $this;
    }


    protected function InternalGetObjectToSave()
    {
        return (object)array(
            'Value'=>$this->Value
        );
    }

    public function InitializeWithOptions($field,$options)
    {
        $this->Field=$field;
        if(isset($options->Value))
            $this->Value=$options->Value;
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
        return new Markup('<img src="'.esc_attr($this->Value).'"></a>','UTF-8');
    }


    public function GetType()
    {
        return 'signature';
    }

    public function IsEmpty()
    {
        return trim($this->Value)=='';
    }

    public function InternalGetDetails($base)
    {

        $base->Value=$this->Value;
        return [$base];

    }


}