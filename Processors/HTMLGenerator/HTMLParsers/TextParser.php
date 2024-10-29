<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers;

use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLSimpleContainer;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\ParserUtilities;

class TextParser extends HTMLParserBase
{
    public $Text;
    public function ParseContent()
    {

        $this->Text=$this->Data->text;
        return ParserUtilities::MaybeApplyMarks($this);
    }

    public function Render()
    {
        return esc_html($this->Text);
    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}