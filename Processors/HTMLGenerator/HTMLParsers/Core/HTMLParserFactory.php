<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core;

use RNAUTO\Processors\HTMLGenerator\HTMLParsers\ConditionParser;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\FieldParser;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\HorizontalRulerParser;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\ImageParser;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\ParagraphParser;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\ParseTemplate;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\TextParser;
use RNAUTO\Utilities\Sanitizer;


class HTMLParserFactory
{
    public static function GetParser($retriever, $parent, $data)
    {
        if(!isset($data->type))
            return null;
        switch ($data->type)
        {
            case 'paragraph':
                return new HTMLSimpleContainer($retriever,$parent,$data,'p');
            case 'text':
                return new TextParser($retriever,$parent,$data);
            case 'image':
                return new ImageParser($retriever,$parent,$data);
            case 'horizontal_rule':
                return new HorizontalRulerParser($retriever,$parent,$data);
            case 'heading':
                $level=Sanitizer::GetStringValueFromPath($data,['attrs','level'],'');
                if($level!='')
                    return new HTMLSimpleContainer($retriever,$parent,$data,'h'.$level);
                return null;
            case 'blockquote':
                return new HTMLSimpleContainer($retriever,$parent,$data,'blockquote');
            case 'bullet_list':
                return new HTMLSimpleContainer($retriever,$parent,$data,'ul');
            case 'ordered_list':
                return new HTMLSimpleContainer($retriever,$parent,$data,'ol');
            case 'list_item':
                return new HTMLSimpleContainer($retriever,$parent,$data,'li');
            case 'table':
                return new HTMLSimpleContainer($retriever,$parent,$data,'table');
            case 'table_row':
                return new HTMLSimpleContainer($retriever,$parent,$data,'tr');
            case 'table_cell':
                return new HTMLSimpleContainer($retriever,$parent,$data,'td');
            case 'field':
                return new FieldParser($retriever,$parent,$data);
            case 'template':
                return new ParseTemplate($retriever,$parent,$data);
            case 'condition':
                return new ConditionParser($retriever,$parent,$data);
            default:
                throw new \Exception('Unknown type '.$data->type);
        }
    }
}