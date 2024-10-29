<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers;

use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use Twig\Markup;

class HorizontalRulerParser extends HTMLParserBase
{

    public function ParseContent()
    {
        return $this;
    }

    public function Render()
    {
        return new Markup('<hr/>','UTF-8');
    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}