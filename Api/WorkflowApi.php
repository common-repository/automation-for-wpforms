<?php

namespace RNAUTO\Api;

use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Core\DB\WorkflowRepository;
use RNAUTO\pr\Workflow\WorkflowManager;

class WorkflowApi
{
    /**
     * @param $triggerType
     * @param $retriever WPFormEntryRetriever
     * @return void
     */
    public function ExecuteWorkflowByType($triggerType,$retriever)
    {
        $workflows=$this->GetWorkflowByType($triggerType,$retriever->GetFormId(),$retriever->GetEntryId());
        foreach($workflows as $currentWorkflow)
        {
            $currentWorkflow->SetEntryRetriever($retriever);
            $currentWorkflow->MaybeInitiate($retriever);
        }


    }

    /**
     * @param $triggerType
     * @param $formId
     * @return WorkflowManager[]
     */
    public function GetWorkflowByType($triggerType,$formId,$entryId)
    {
        $repository=new WorkflowRepository(RNAUTO()->Loader);
        return $repository->GetWorkflowForTrigger($triggerType,$formId,$entryId);

    }

    /**
     * @param $entryid
     * @return WorkflowManager[]
     */
    public function GetEntryWorkFlows($entryid)
    {
        $repository=new WorkflowRepository(RNAUTO()->Loader);
        return $repository->GetEntryWorkflows($entryid);
    }

}