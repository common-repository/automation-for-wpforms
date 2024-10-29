<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers;


use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Processors\HTMLGenerator\Context\HTMLContextBase;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserWithChildren;

class DocumentParser extends HTMLParserWithChildren
{

    /** @var WPFormEntryRetriever */
    public $Retriever;
    /** @var HTMLContextBase */
    public $Context;

    public function __construct($retriever, $data,$context)
    {
        parent::__construct($retriever, null, $data);
        $this->Context=$context;
        $this->Retriever=$retriever;
    }


    public function GetInline(){
        $this->ParseContent();
        return $this->Render();
    }
    public function GetHTML(){
        $this->ParseContent();
        return $this->RenderTemplate('Processors/HTMLGenerator/HTMLParsers/DocumentParser.HTML.twig',$this);
    }

    protected function GetTemplateName()
    {
        return 'Processors/HTMLGenerator/HTMLParsers/DocumentParser.Inline.twig';
    }
}