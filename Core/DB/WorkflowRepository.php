<?php

namespace RNAUTO\Core\DB;

use RNAUTO\Core\DB\Core\RepositoryBase;
use RNAUTO\Core\Exception\FriendlyException;
use RNAUTO\DTO\WorkFlowBuilderOptionsDTO;
use RNAUTO\pr\Workflow\WorkflowManager;

class WorkflowRepository extends RepositoryBase
{
    public function WorkflowList($length=30,$pageIndex=0,$searchTerm=''){
        $length=intval($length);
        $pageIndex=intval($pageIndex);

        $where='';
        global $wpdb;
        if($searchTerm!='')
            $where='where id='.$wpdb->prepare('%s',$searchTerm).' or name like "%'.$wpdb->esc_like($searchTerm).'%"';

        $result= $this->DBManager->GetResults('select id Id,name Name,formid FormId from '.$this->Loader->WORKFLOWTABLE .' '.$where.'   limit '.($length*$pageIndex).', '.$length);
        $pages=array();
        $formsToQuery=[];
        global $wpdb;
        foreach($result as $currentItem)
        {
            $currentPage=new \stdClass();
            $pages[]=$currentPage;
            $currentPage->Name=$currentItem->Name;
            $currentPage->Id=$currentItem->Id;
            $currentPage->FormId=$currentItem->FormId;
        }


        $forms=[];

        foreach($this->Loader->FormProcessor->ListForms() as $currentForm)
        {
            $forms[]=[
                'Id'=>$currentForm['Id'],
                'Name'=>$currentForm["Name"]
            ];
        }

        return array(
            'Workflows'=>$pages,
            'Forms'=>$forms
        );
    }

    public function WorkflowCount($searchTerm=''){
        $where='';
        global $wpdb;
        if($searchTerm!='')
            $where='where id='.$wpdb->prepare('%s',$searchTerm).' or name like "%'.$wpdb->esc_like($searchTerm).'%"';
        return $this->DBManager->GetVar('select count(*) from '.$this->Loader->WORKFLOWTABLE.' '.$where);
    }

    /**
     * @param $automation WorkFlowBuilderOptionsDTO
     * @return void
     */
    public function Save($automation)
    {
        global $wpdb;
        $settings=$automation;

        if($automation->Name=='')
            throw new FriendlyException('Workflow name is required');
        if($automation->Id==0)
        {
            if($this->DBManager->GetVar('select count(*) from '.$this->Loader->WORKFLOWTABLE." where name = '".$automation->Name."'")==0)
            {
                $this->DBManager->Insert($this->Loader->WORKFLOWTABLE,[
                        'id'=>$automation->Id,
                        'name'=>$automation->Name,
                        'trigger_type'=>$automation->TriggerType,
                        'formid'=>$automation->FormId,
                        'node'=>json_encode($automation->Node),
                        'status'=>$automation->Status
                    ]
                );
                $automation->Id=$wpdb->insert_id;
            }else
                throw new FriendlyException('The name is already in use');
        }else{
            if($this->DBManager->GetVar('select count(*) from '.$this->Loader->AUTOMATIONTABLE." where name = '".$automation->Name."' and id<>%d",$automation->Id)==0)
            {
                $this->DBManager->Update($this->Loader->WORKFLOWTABLE,[
                    'name'=>$automation->Name,
                    'trigger_type'=>$automation->TriggerType,
                    'formid'=>$automation->FormId,
                    'node'=>json_encode($automation->Node),
                    'status'=>$automation->Status
                ],['id'=>$automation->Id]
                );
            }else
                throw new FriendlyException('The name is already in u se');
        }
    }

    public function GetWorkflowById($automationId)
    {
        $data=$this->DBManager->GetResult('select id Id, name Name,status Status,formid FormId,node Node,trigger_type TriggerType from '.$this->Loader->WORKFLOWTABLE.' where id=%d',$automationId);
        if($data==null)
            return null;
        $data->Node=json_decode($data->Node);
        $workflow=(new WorkFlowBuilderOptionsDTO())->Merge($data);

        return $workflow;
    }

    public function Delete($id)
    {
        return $this->DBManager->Delete($this->Loader->WORKFLOWTABLE,[
            'id'=>$id
        ]);
    }

    public function GetWorkflowForTrigger($triggerType, $formId,$entryId)
    {
        $workflows=[];
        $result= $this->DBManager->GetResults('select id Id,name Name,node Node,formid FormId,status Status from '.$this->Loader->WORKFLOWTABLE.' where formid=%d and trigger_type=%s and status="active"',$formId,$triggerType);
        foreach($result as $currentWorkflow)
        {
            $workflows[]=new WorkflowManager($currentWorkflow->Id,$currentWorkflow->Name,'',$entryId,json_decode($currentWorkflow->Node));
        }

        return $workflows;


    }

    public function GetEntryWorkflows($entryId)
    {
        $workflows=[];
        $result= $this->DBManager->GetResults('select wf.id Id,name Name,node Node, current_step CurrentStep,proc.status Status,last_update LastUpdate,data Data from '.$this->Loader->WORKFLOWPROCESSION.' proc  join '.$this->Loader->WORKFLOWTABLE.' wf on wf.id=proc.workflow_id where entry_id=%d',$entryId);
        $retriever=null;
        if(count($result)>0)
            $retriever=$this->Loader->EntryProcessor->CreateRetrieverByEntryId($entryId);
        if($retriever==null)
            return [];
        foreach($result as $currentWorkflow)
        {
            $workflow=new WorkflowManager($currentWorkflow->Id,$currentWorkflow->Name,$currentWorkflow->Status,$entryId,json_decode($currentWorkflow->Node),$currentWorkflow->CurrentStep,$currentWorkflow->LastUpdate,json_decode($currentWorkflow->Data));
            $workflow->SetEntryRetriever($retriever);
            $workflows[]=$workflow;
        }

        return $workflows;
    }

    public function GetWorkflowByIdAndEntryId($workflowId, $entryId)
    {
        $result= $this->DBManager->GetResults('select wf.id Id,name Name,node Node, current_step CurrentStep,proc.status Status,last_update LastUpdate,data Data from '.$this->Loader->WORKFLOWPROCESSION.' proc  join '.$this->Loader->WORKFLOWTABLE.' wf on wf.id=proc.workflow_id where entry_id=%d and proc.workflow_id=%d',$entryId,$workflowId);

        if(count($result)<=0)
            return null;


        $currentWorkflow=$result[0];
        return new WorkflowManager($currentWorkflow->Id,$currentWorkflow->Name,$currentWorkflow->Status,$entryId,json_decode($currentWorkflow->Node),$currentWorkflow->CurrentStep,$currentWorkflow->LastUpdate,json_decode($currentWorkflow->Data));

    }


}