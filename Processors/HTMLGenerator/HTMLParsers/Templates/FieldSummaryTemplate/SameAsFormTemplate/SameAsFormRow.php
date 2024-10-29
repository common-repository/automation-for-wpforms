<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Templates\FieldSummaryTemplate\SameAsFormTemplate;


use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserBase;

class SameAsFormRow extends HTMLParserBase
{
    /** @var FBRow */
    public $Row;
    /** @var FBColumn */
    public $Columns=[];
    public function __construct($twig, $formBuilder, $parent, $data,$row)
    {
        parent::__construct($twig, $formBuilder, $parent, $data);
        $this->Row=$row;
    }


    public function ParseContent()
    {
       foreach($this->Row->Columns as $currentColumn)
       {
            if($currentColumn->Field->IsUsed())
                $this->Columns[]=$currentColumn;
       }

       if(count($this->Columns)==0)
           return null;

       return $this;
    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}