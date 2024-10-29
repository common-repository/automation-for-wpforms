<?php

namespace RNAUTO\Api;

use RNAUTO\Core\Loader;

class AutomationApi
{
    /** @var Loader */
    public $Loader;
    /** @var TriggerApi */
    private $trigger;
    /** @var WorkflowApi */
    private $workflow;
    public function __construct($loader)
    {
        $this->Loader=$loader;
    }

    public function Trigger(){
        if($this->trigger==null)
            $this->trigger=new TriggerApi($this->Loader);
        return $this->trigger;
    }

    public function Workflow(){
        if($this->workflow==null)
            $this->workflow=new WorkflowApi($this->Loader);
        return $this->workflow;
    }

    public function EntryProcessor()
    {
        return $this->Loader->EntryProcessor;
    }
}