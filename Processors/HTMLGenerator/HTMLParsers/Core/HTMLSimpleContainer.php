<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core;

class HTMLSimpleContainer extends HTMLParserWithChildren
{
    public $TagName;
    public function __construct($formBuilder, $parent, $data,$tagName)
    {
        parent::__construct($formBuilder, $parent, $data);
        $this->TagName=$tagName;
    }

    protected function GetTemplateName()
    {
        return 'Processors/HTMLGenerator/HTMLParsers/Core/HTMLSimpleContainer.twig';
    }
}