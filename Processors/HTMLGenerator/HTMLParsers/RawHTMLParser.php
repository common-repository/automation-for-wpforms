<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers;

use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;
use Twig\Markup;

class RawHTMLParser extends HTMLParserBase
{
    public $HTML;
    public function __construct($formBuilder, $parent, $data,$html)
    {
        parent::__construct($formBuilder, $parent, $data);
        $this->HTML=$html;

    }

    public function ParseContent()
    {
        return $this;
    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }

    public function Render()
    {
        if($this->HTML instanceof Markup)
            return $this->HTML;

        return new Markup($this->HTML,'UTF-8');
    }


}