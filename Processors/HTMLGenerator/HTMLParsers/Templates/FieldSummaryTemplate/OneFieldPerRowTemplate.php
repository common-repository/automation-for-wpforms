<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Templates\FieldSummaryTemplate;

use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use Twig\Markup;

class OneFieldPerRowTemplate extends HTMLParserBase
{
    /** @var EntryItemBase[] */
    public $Fields=[];
    public function ParseContent()
    {
        $fields=$this->Retriever->GetFields();
        foreach($fields as $currentField)
        {

            if($currentField->IsEmpty())
            {
                continue;
            }
             $this->Fields[]=$currentField;

        }


        return $this;
    }

    public function Render()
    {
        return $this->RenderTemplate($this->GetTemplateName(),$this);
    }


    protected function GetTemplateName()
    {
        return 'Processors/HTMLGenerator/HTMLParsers/Templates/FieldSummaryTemplate/OneFieldPerRowTemplate.twig';
    }


    public function RenderTemplate($templateName,$model)
    {
        $markup= new Markup(RNAUTO()->Loader->GetTwigManager()->Render($templateName,$model,['Context'=>$this->GetDocument()->Context]),"UTF-8");
        return $markup;
    }
}