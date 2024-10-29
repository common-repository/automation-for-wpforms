<?php

namespace RNAUTO\Core\DB;

use RNAUTO\Core\DB\Core\RepositoryBase;
use RNAUTO\Core\Exception\FriendlyException;
use RNAUTO\DTO\AutomationBuilderOptionsDTO;
use RNAUTO\DTO\Core\Factories\ActionFactory;
use RNAUTO\DTO\Core\Factories\TriggerFactory;
use RNAUTO\Processors\ActionProcessor\Core\ActionProcessorBase;
use RNAUTO\Processors\ActionProcessor\Core\ActionProcessorFactory;
use RNAUTO\Processors\TriggerProcessors\Core\TriggerProcessorBase;
use RNAUTO\Processors\TriggerProcessors\Core\TriggerProcessorFactory;

class AutomationRepository extends RepositoryBase
{
    public function AutomationList($length=30,$pageIndex=0,$searchTerm=''){
        $length=intval($length);
        $pageIndex=intval($pageIndex);

        $where='';
        global $wpdb;
        if($searchTerm!='')
            $where='where id='.$wpdb->prepare('%s',$searchTerm).' or name like "%'.$wpdb->esc_like($searchTerm).'%"';

        $result= $this->DBManager->GetResults('select id Id,name Name,formid FormId,trigger_type TriggerType from '.$this->Loader->AUTOMATIONTABLE .' '.$where.'   limit '.($length*$pageIndex).', '.$length);
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
            $currentPage->TriggerType=$currentItem->TriggerType;
        }


        $forms=[];

        return array(
            'Automations'=>$pages,
            'Forms'=>$forms
        );
    }

    public function AutomationCount($searchTerm=''){
        $where='';
        global $wpdb;
        if($searchTerm!='')
            $where='where id='.$wpdb->prepare('%s',$searchTerm).' or name like "%'.$wpdb->esc_like($searchTerm).'%"';
        return $this->DBManager->GetVar('select count(*) from '.$this->Loader->AUTOMATIONTABLE.' '.$where);
    }

    /**
     * @param $automation AutomationBuilderOptionsDTO
     * @return void
     */
    public function Save($automation)
    {
        global $wpdb;
        $settings=$automation;
        $conditions=$automation->Trigger->Condition;
        if(count($conditions->ConditionGroups)==0)
            $conditions=$automation->Trigger->Condition=null;

        if($automation->Id==0)
        {
            if($this->DBManager->GetVar('select count(*) from '.$this->Loader->AUTOMATIONTABLE." where name = '".$automation->Name."'")==0)
            {
                $this->DBManager->Insert($this->Loader->AUTOMATIONTABLE,[
                        'id'=>$automation->Id,
                        'name'=>$automation->Name,
                        'trigger_type'=>$automation->Trigger->Type,
                        'formid'=>$automation->FormId,
                        'auto_trigger'=>json_encode($automation->Trigger),
                        'actions'=>json_encode($automation->Actions),
                        'link_options'=>json_encode($automation->LinkOptions),
                        'status'=>$automation->Status,
                        'include_in_entry'=>$automation->LinkOptions->IncludeOnEntriesScreen?"1":'0'
                    ]
                );
                $automation->Id=$wpdb->insert_id;
            }else
                throw new FriendlyException('The name is already in use');
        }else{
            if($this->DBManager->GetVar('select count(*) from '.$this->Loader->AUTOMATIONTABLE." where name = '".$automation->Name."' and id<>%d",$automation->Id)==0)
            {
                $this->DBManager->Update($this->Loader->AUTOMATIONTABLE,[
                    'name'=>$automation->Name,
                    'trigger_type'=>$automation->Trigger->Type,
                    'formid'=>$automation->FormId,
                    'auto_trigger'=>json_encode($automation->Trigger),
                    'actions'=>json_encode($automation->Actions),
                    'link_options'=>json_encode($automation->LinkOptions),
                    'status'=>$automation->Status,
                    'include_in_entry'=>$automation->LinkOptions->IncludeOnEntriesScreen?"1":'0'
                ],['id'=>$automation->Id]
                );
            }else
                throw new FriendlyException('The name is already in u se');
        }
    }

    public function GetAutomationById($automationId)
    {
        $data=$this->DBManager->GetResult('select id Id, name Name,auto_trigger AutoTrigger,actions Actions,status Status,formid FormId,link_options LinkOptions from '.$this->Loader->AUTOMATIONTABLE.' where id=%d',$automationId);
        if($data==null)
            return null;
        $data->Trigger=json_decode($data->AutoTrigger);
        $data->Actions = json_decode($data->Actions);
        $data->LinkOptions = json_decode($data->LinkOptions);
        unset($data->AutoTrigger);
        $automation=(new AutomationBuilderOptionsDTO())->Merge($data);

        return $automation;
    }

    public function Delete($id)
    {
        return $this->DBManager->Delete($this->Loader->AUTOMATIONTABLE,[
            'id'=>$id
        ]);
    }

    /**
     * @param $actionType
     * @param $formId
     * @return TriggerProcessorBase[]
     * @throws \Exception
     */
    public function GetAutomationsForTrigger($actionType, $formId)
    {
        $processors=[];
        $result= $this->DBManager->GetResults('select id Id,auto_trigger AutoTrigger from '.$this->Loader->AUTOMATIONTABLE.' where formid=%d and trigger_type=%s and status="active"',$formId,$actionType);
        foreach($result as $currentTrigger)
        {
            $triggerOptions=TriggerFactory::GetTrigger(json_decode($currentTrigger->AutoTrigger));
            $processors[]=TriggerProcessorFactory::GetTriggerProcessor($this->Loader,$currentTrigger->Id,$triggerOptions);
        }

        return $processors;
    }

    /**
     * @param $automationId
     * @return ActionProcessorBase[]
     * @throws \Exception
     */
    public function GetActionsByAutomationId($automationId)
    {
        $items= $this->DBManager->GetResults('select actions Actions from '.$this->Loader->AUTOMATIONTABLE.' where id=%d',$automationId);

        $actions=[];
         foreach($items as $currentItem)
        {
            $actionOptions=json_decode($currentItem->Actions);
            foreach($actionOptions as $currentAction)
            {
                $actions[]=ActionProcessorFactory::GetActionProcessor($automationId,ActionFactory::GetAction($currentAction));
            }
        }

         return $actions;
    }

    public function FormHasTrigger($formId, $triggerType)
    {
        return $this->DBManager->GetVar('select 1 from '.$this->Loader->AUTOMATIONTABLE.' where status="active" and formid=%d and trigger_type=%s limit 1',$formId,$triggerType);
    }

}