<?php

namespace RNAUTO\Processors\SingleLineGenerator;

use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Utilities\ObjectSanitizer;

class SingleLineGenerator
{
    /** @var WPFormEntryRetriever */
    public $Retriever;
    public $Options;
    public function __construct($retriever)
    {
        $this->Retriever=$retriever;
        require_once RNAUTO()->Loader->DIR.'vendor/autoload.php';
    }

    public function GetText($content){
        if($content==null)
            return '';

        if(is_string($content))
            return $content;

        $content=ObjectSanitizer::Sanitize($content,["content"=>[(object)[
            "content"=>(object)[
                "type"=>''
            ]
        ]]]);



        $text='';
        foreach($content->content as $currentItem)
        {
            switch ($currentItem->type)
            {
                case 'text':
                    $text.=$currentItem->text;
                    break;
                case 'field':
                    $obj=ObjectSanitizer::Sanitize($currentItem,(object)['attrs'=>(object)["Type"=>'',"Value"=>""]]);
                    if($obj->attrs->Type=='Field')
                    {
                        $fieldId=$obj->attrs->Value;
                        $fieldPath='';
                        if(strpos($fieldId,'_'))
                        {
                            $fields=explode('_',$fieldId);
                            if(count($fields)!=2)
                                break;
                            $fieldId=$fields[0];
                            $fieldPath=$fields[1];
                        }
                        $text.=$this->Retriever->GetFieldStringValue($fieldId,$fieldPath);
                    }

            }
        }

        return $text;
    }

}