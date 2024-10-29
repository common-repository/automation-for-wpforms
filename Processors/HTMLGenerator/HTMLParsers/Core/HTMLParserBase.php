<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core;


use RNAUTO\Processors\HTMLGenerator\HTMLParsers\DocumentParser;
use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Utilities\Sanitizer;
use Twig\Environment;
use Twig\Markup;

abstract class HTMLParserBase
{
    /** @var WPFormEntryRetriever */
    public $Retriever;
    /** @var HTMLParserBase */
    public $Parent;
    public $Data;

    public function __construct($retriever,$parent,$data)
    {
        $this->Retriever=$retriever;
        $this->Parent=$parent;
        $this->Data=$data;
    }

    /**
     * @return DocumentParser;
     */
    public function GetDocument(){
        if($this->Parent==null)
            return $this;

        return $this->Parent->GetDocument();
    }

    public function GetLoader(){
        return RNAUTO()->Loader;
    }

    /**
     * @return HTMLParserBase
     */
    public abstract function ParseContent();

    public function GetAttributeValue($attributeName,$defaultValue=null)
    {
        return Sanitizer::GetValueFromPath($this->Data,['attrs',$attributeName],$defaultValue);

    }

    public function GetStringAttributeValue($attributeName,$defaultValue='')
    {
        return Sanitizer::SanitizeString($this->GetAttributeValue($attributeName,$defaultValue));
    }

    public function GetNumericAttributeValue($attributeName,$defaultValue=0)
    {
        return Sanitizer::SanitizeNumber($this->GetAttributeValue($attributeName,$defaultValue));
    }


    protected abstract function GetTemplateName();

    public function Render(){
        return $this->RenderTemplate($this->GetTemplateName(),$this);
    }

    public function RenderTemplate($templateName,$model)
    {
        $markup= new Markup(RNAUTO()->Loader->GetTwigManager()->Render($templateName,$model),"UTF-8");
        return $markup;
    }

}