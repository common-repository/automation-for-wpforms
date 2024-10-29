<?php

namespace RNAUTO\Processors\ActionProcessor\Core;

class ActionResult
{
    /** @var boolean */
    public $Continue;
    public $Data;

    public $Status;
    public function __construct($continue=true,$data=null,$status='')
    {
        $this->Continue=$continue;
        $this->Data=$data;
        $this->Status=$status;
    }


    public static function Create($continue=true,$data=null,$status='')
    {
        return new ActionResult($continue,$data,$status);
    }
}