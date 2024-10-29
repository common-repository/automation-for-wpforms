<?php

namespace RNAUTO\Processors\TriggerProcessors\Core;

use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\Loader;
use RNAUTO\DTO\TriggerBaseOptionsDTO;
use RNAUTO\pr\Processors\ConditionProcessor\ConditionProcessor;
use RNAUTO\Processors\ActionProcessor\Core\ActionProcessorBase;

abstract class TriggerProcessorBase
{
    /**
     * @var TriggerBaseOptionsDTO
     */
    public $Options;
    public $AutomationId;
    /** @var Loader */
    public $Loader;
    /**
     * @param $automationId
     * @param $triggerOptions TriggerBaseOptionsDTO
     */

    /** @var ActionProcessorBase[] */
    public $Actions;
    public function __construct($loader,$automationId,$triggerOptions)
    {
        $this->loader=$loader;
        $this->AutomationId=$automationId;
        $this->Options=$triggerOptions;
    }

    /**
     * @param $formBuilder WPFormEntryRetriever
     * @return bool
     */
    public function ShouldExecute($retriever)
    {
        if($this->Options->Condition==null||count($this->Options->Condition->ConditionGroups)==0)
            return true;

        $condition=new ConditionProcessor();
        return $condition->ShouldProcess($this->loader,$retriever,$this->Options->Condition);
    }

    /**
     * @param $formBuiler WPFormEntryRetriever
     * @return void
     */
    public function Execute($formBuiler)
    {
        $this->MaybeLoadActions();
        foreach($this->Actions as $currentAction)
            $currentAction->Execute($formBuiler);
    }

    private function MaybeLoadActions()
    {
        if($this->Actions==null)
        {
            $repository = new AutomationRepository(RNAUTO()->Loader);
            $this->Actions = $repository->GetActionsByAutomationId($this->AutomationId);
        }


    }


}