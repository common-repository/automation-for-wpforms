<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core;

use Twig\Markup;

abstract class HTMLParserWithChildren extends HTMLParserBase
{

    /** @var HTMLParserBase[] */
    public $Children=[];

    public function __construct($retriever, $parent, $data)
    {
        parent::__construct($retriever, $parent, $data);
    }

    public function ParseContent()
    {
        if(!isset($this->Data->content)||!is_array($this->Data->content))
            return $this;

        foreach($this->Data->content as $currentChild)
        {
            $newChild=HTMLParserFactory::GetParser($this->Retriever,$this,$currentChild);

            if($newChild==null)
                return $this;

            $newChild=$newChild->ParseContent();

            if($newChild==null)
                continue;
            $this->Children[]=$newChild;
        }

        return $this;
    }

    public function RenderChildren(){
        $renderedChildren='';
        foreach($this->Children as $currentChild)
            if($currentChild instanceof Markup)
                $renderedChildren.=$currentChild;
            else
                $renderedChildren.=$currentChild->Render();
        return new Markup($renderedChildren,'UTF-8');
    }



}