<?php


namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use Twig\Markup;

class HTMLEntryItem extends EntryItemBase
{
    public $HTML;

    public function GetText($pathId='')
    {
        return $this->HTML;

    }

    public function SetHTML($value)
    {
        $this->HTML=$value;
        return $this;
    }


    public function GetHtml($style = 'standard')
    {
        return new Markup($this->HTML,'UTF-8');
    }

    public function GetType()
    {
        return 'html';
    }

    public function IsEmpty()
    {
        return $this->HTML=='';
    }



}