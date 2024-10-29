<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers;



use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\ParserUtilities;
use RNAUTO\Utilities\Sanitizer;

class FieldParser extends HTMLParserBase
{
    public $Id;
    public $Options;

    public function ParseContent()
    {
        $this->Id=$this->GetAttributeValue('id');
        $this->Options=$this->GetAttributeValue('options');



        return ParserUtilities::MaybeApplyMarks($this);
    }

    public function Render()
    {
        $fieldId=Sanitizer::GetStringValueFromPath($this->Data,['attrs','id']);
        $path=Sanitizer::GetStringValueFromPath($this->Data,['attrs','path']);
        $field=$this->Retriever->GetFieldById($fieldId,$path);
        if($this->Retriever->IsTest){
            if($field==null)
                return "[Unknown Field]";
            else
                return "[".$field->GetLabel().']';
        }

        if($field==null)
            return '';

        return $field->GetHtml($path);

    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}