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

class LikertScaleEntryItem extends EntryItemBase
{
    public $Value=[];


    public function AddValue($rowValue,$columnValue)
    {
        if(!isset($this->Value[$rowValue]))
            $this->Value[$rowValue]=[];
        $this->Value[$rowValue][]=$columnValue;
    }


    protected function InternalGetObjectToSave()
    {
        return (object)array(
            'Value'=>$this->Value
        );
    }


    public function InitializeWithString($field,$stringValue)
    {
        $this->Field=null;
        $this->Value=$stringValue;

    }

    public function GetText($pathId='')
    {
        $text='';
        foreach($this->Value as $key=>$value)
        {
            if($text!='')
                $text.="\n";
            $text.=$key.":\n".implode(",",$value);
        }

        return $text;
    }

    public function GetHtml($pathId = '')
    {
        return new Markup(nl2br($this->GetText($pathId)),'UTF-8');
    }


    public function GetType()
    {
        return 'number';
    }

    public function IsEmpty()
    {
        return count($this->Value)==0;
    }




}