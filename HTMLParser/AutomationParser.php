<?php

namespace RNAUTO\HTMLParser;


use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;

class AutomationParser extends HTMLParserBase
{

    public $AutomationId;
    public $LinkText;
    public $LinkTarget;
    public function ParseContent()
    {
        $this->AutomationId=$this->GetAttributeValue('id');
        $this->LinkText=$this->GetAttributeValue('linkText');
        $this->LinkTarget=$this->GetAttributeValue('linkTarget');
        // TODO: Implement ParseContent() method.
        return $this;
    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }

    public function Render()
    {
        $href='#';
        if(!$this->FormBuilder->IsTest)
            $href=RNAUTO()->Trigger()->GenerateAutomationLink($this->AutomationId,$this->FormBuilder->Entry->EntryId,10);

        return '<a href="'.esc_attr($href).'">'.esc_html($this->LinkText).'</a>';

    }


}