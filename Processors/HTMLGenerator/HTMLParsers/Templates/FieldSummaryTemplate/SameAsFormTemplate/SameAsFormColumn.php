<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Templates\FieldSummaryTemplate\SameAsFormTemplate;

use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;

class SameAsFormColumn extends HTMLParserBase
{
    /** @var  FBColumn */
    public $Column;
    public function __construct($twig, $formBuilder, $parent, $data,$column)
    {
        parent::__construct($twig, $formBuilder, $parent, $data);
        $this->Column=$column;
    }


    public function ParseContent()
    {
        // TODO: Implement ParseContent() method.
    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}