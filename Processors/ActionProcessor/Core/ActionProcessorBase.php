<?php

namespace RNAUTO\Processors\ActionProcessor\Core;

use RNAUTO\DTO\ActionBaseOptionsDTO;

abstract class ActionProcessorBase
{
    public $AutomationId;
    /** @var ActionBaseOptionsDTO */
    public $Options;
    public function __construct($automationId,$actionOptions)
    {
        $this->AutomationId=$automationId;
        $this->Options=$actionOptions;
    }

    /**
     * @param $formBuilder FormBuilder
     * @return ActionResult
     */
    public abstract function Execute($formBuilder);

    public function GenerateActionResult($continue=true,$data=null,$status='')
    {
        return new ActionResult($continue,$data,$status);
    }

}