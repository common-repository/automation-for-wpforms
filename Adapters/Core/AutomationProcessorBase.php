<?php

namespace RNAUTO\Adapters\Core;

use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Adapters\WPForms\WPFormsSubLoader;
use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Processors\TriggerProcessors\Core\TriggerProcessorBase;

class AutomationProcessorBase
{
    /** @var WPFormsSubLoader */
    public $loader;


    public function __construct($loader)
    {
        $this->loader=$loader;
    }

    /**
     * @param $triggerType
     * @param $retriever WPFormEntryRetriever
     * @return TriggerProcessorBase[]
     * @throws \Exception
     */
    public function GetTriggersByType($triggerType,$retriever)
    {
        $repository=new AutomationRepository($this->loader);
        return $repository->GetAutomationsForTrigger($triggerType,$retriever->Form->Id);
    }


    public function FormHasTrigger($formId,$actionType)
    {
        $repository=new AutomationRepository($this->loader);
        return $repository->FormHasTrigger($formId,$actionType);

    }
    public function ExecuteActionsByType($actionType,$retriever)
    {

        $triggers=$this->GetTriggersByType($actionType,$retriever);

        foreach($triggers as $currentTrigger)
        {
            if($currentTrigger->ShouldExecute($retriever))
            {
                $currentTrigger->Execute($retriever);
            }

        }
    }
}