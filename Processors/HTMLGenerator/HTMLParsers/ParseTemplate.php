<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers;

use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Templates\FieldSummaryTemplate\FieldSummaryTemplate;

class ParseTemplate extends HTMLParserBase
{
    public function ParseContent()
    {
        $options=json_decode($this->GetStringAttributeValue('Options'));
        if($options==false||!isset($options->Id))
            return null;

        switch ($options->Id)
        {
            case 'field_summary':
                return (new FieldSummaryTemplate($this->Retriever,$this->Parent,$this->Data))->ParseContent();
        }
        return null;
    }

    public function Render()
    {
        return 'a';
    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}