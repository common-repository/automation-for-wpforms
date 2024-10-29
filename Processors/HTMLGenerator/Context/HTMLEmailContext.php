<?php

namespace RNAUTO\Processors\HTMLGenerator\Context;

class HTMLEmailContext extends HTMLContextBase
{
    public $InlinedImages=[];
    public function AddInlineImage($path)
    {
        if($path==null)
            return '';
        foreach($this->InlinedImages as $id=>$filePath)
        {
            if($path==$filePath)
                return $id;
        }

        $id=uniqid();
        $this->InlinedImages[$id]=$path;
        return $id;

    }
}