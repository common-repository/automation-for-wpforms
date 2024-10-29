<?php

namespace RNAUTO\Processors\HTMLGenerator;



use RNAUTO\Adapters\Core\WPFormEntryRetriever;
use RNAUTO\Processors\HTMLGenerator\Context\HTMLContextBase;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\DocumentParser;

class HTMLGenerator
{
    /** @var WPFormEntryRetriever */
    public $Retriever;
    public $Options;
    /** @var DocumentParser */
    public $DocumentParser;

    /**
     * @param $formBuilder
     * @param $options
     * @param HTMLContextBase $context
     */
    public function __construct($retriever,$options,$context=null)
    {
        $this->Retriever=$retriever;
        require_once RNAUTO()->Loader->DIR.'vendor/autoload.php';
        $this->Options=$options;
        $this->DocumentParser=(new DocumentParser($retriever,$options,$context));
    }


    public function GetInline(){
        return str_replace("\n","" ,strval($this->DocumentParser->GetInline()));
    }


    public function GetHTML(){
        return str_replace("\n","" , strval($this->DocumentParser->GetHTML()));
    }




}