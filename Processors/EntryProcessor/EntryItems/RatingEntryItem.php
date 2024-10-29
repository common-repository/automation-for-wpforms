<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 3/22/2019
 * Time: 5:50 AM
 */

namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Utilities\Sanitizer;
use Twig\Markup;

class RatingEntryItem extends EntryItemBase
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
        $currentValue=Sanitizer::GetNumberValueFromPath($this->Value,['value']);
        $scale=Sanitizer::GetNumberValueFromPath($this->Value,['scale']);

        $imageUrl=RNAUTO()->Loader->URL.'images/star.png';
        $content='<div style="display: inline-flex;align-items: center;">';
        for($i=0;$i<$currentValue;$i++)
        {
            $content.='<img style="display:inline-block;height:15px;width:15px;" src="'.esc_attr($imageUrl).'"/> ';
        }

        $content.='('.esc_html($currentValue).'/'.esc_html($scale).')';
        $content.='</div>';


        return new Markup($content,'UTF-8');
    }


    public function GetType()
    {
        return 'number';
    }

    public function IsEmpty()
    {
        return floatval($this->Value['value'])=='0';
    }






}