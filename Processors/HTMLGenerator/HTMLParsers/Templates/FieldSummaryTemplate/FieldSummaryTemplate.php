<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Templates\FieldSummaryTemplate;



use RNAUTO\DTO\FieldSummaryTemplateOptionsDTO;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\RawHTMLParser;

class FieldSummaryTemplate extends HTMLParserBase
{
    /** @var FieldSummaryTemplateOptionsDTO */
    public $Options;
    public function ParseContent()
    {
        $options=json_decode($this->GetStringAttributeValue('Options'));
        if($options==false||!isset($options->Id))
            return null;

        return (new OneFieldPerRowTemplate($this->Retriever,$this->Parent,$options))->ParseContent();


        return null;
    }

    public function Render()
    {

        return '1'; // TODO: Change the autogenerated stub
    }


    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}