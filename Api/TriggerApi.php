<?php

namespace RNAUTO\Api;

use RNAUTO\Core\Managers\FormManager\FormBuilder;
use RNAUTO\Core\DB\AutomationLinkRepository;
use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\Managers\LogManager\LogManager;
use RNAUTO\Processors\ActionProcessor\Core\ActionProcessorFactory;
use RNAUTO\Processors\TriggerProcessors\Core\TriggerProcessorBase;
use RNAUTO\Utilities\PageUtilities;

class TriggerApi
{
    /**
     * @param $triggerType
     * @param $formBuilder FormBuilder
     * @return TriggerProcessorBase[]
     * @throws \Exception
     */
    public function GetTriggerByType($triggerType,$formId)
    {
        $repository=new AutomationRepository(RNAUTO()->Loader);
        return $repository->GetAutomationsForTrigger($triggerType,$formId);

    }

    /**
     * @param $triggerType
     * @param $formBuilder FormBuilder
     * @return void
     * @throws \Exception
     */
    public function ExecuteTriggerByType($triggerType,$formBuilder)
    {
        $triggers=$this->GetTriggerByType($triggerType,$formBuilder->Options->Id);
        foreach($triggers as $currentTrigger)
        {
            if($currentTrigger->ShouldExecute($formBuilder))
                $currentTrigger->Execute($formBuilder);
        }
    }

    public function ExecuteAutomation($automationId, $entryId,$additionalOptions)
    {
        $repository=new AutomationRepository(RNAUTO()->Loader);
        $automation=$repository->GetAutomationById($automationId);
        if($automation==null)
        {
            LogManager::LogError('Automation '.$automationId.' not found could not execute automation');
            return false;
        }

        foreach($automation->Actions as $currentAction)
        {
            $processor=ActionProcessorFactory::GetActionProcessor($automationId,$currentAction);
            if($processor==null)
            {
                LogManager::LogError('Action processor '.$currentAction->Type.' not found could not execute automation');
                return false;
            }

            $processor->Execute($form);
        }

        return true;
    }

    public function GetAutomationById($automationId)
    {
        $repository=new AutomationRepository(RNAUTO()->Loader);
        return $repository->GetAutomationById($automationId);
    }

    public function List(){
        $repository=new AutomationRepository(RNAUTO()->Loader);
        return $repository->AutomationList()['Automations'];
    }


    /**
     * @param $automationId
     * @param $entryId
     * @param $duration int duration in days use -1 for not saving in the database and use wp nonces instead
     * @return string
     */
    public function GenerateAutomationLink($automationId,$entryId,$duration=-1,$additionalOptions='')
    {
        global $wpdb;
        $data=$wpdb->get_row($wpdb->prepare('select id Id, formid FormId from '.RNAUTO()->Loader->AUTOMATIONTABLE.' where id=%s',$automationId));
        if($data==null)
            return '';



        $formId=RNAUTO()->EntryProcessor()->GetFormId($entryId);
        if($formId==null)
            return '';


        $data=[
            "AutomationId"=>$automationId,
            "EntryId"=>$entryId,
            'O'=>$additionalOptions
        ];

        if($duration==-1)
        {
            $nonce=wp_create_nonce('execute_automation_'.$automationId.'_'.$entryId.'_'.$additionalOptions);
            $data['Nonce']=$nonce;
        }else{
            $id=bin2hex(openssl_random_pseudo_bytes(14));
            $id.=\uniqid();

            if(!is_numeric($duration))
                return '';

            $date=date('c', strtotime('+'.$duration.' days'));


            $automationLinkRepository=new AutomationLinkRepository(RNAUTO()->Loader);
            $automationLinkRepository->CreateAutomationLink($automationId,$entryId,$id,$additionalOptions,$date);
            $data['Ref']=$id;


        }

        $params['action']='RNAUTO_process_link';
        $params['t']=base64_encode(json_encode($data));

        $url=get_permalink(PageUtilities::GetProcessLinkURL());
        if(strpos($url,'?')===false)
            $url.='?';
        else
            $url.='&';
        $url.=  http_build_query($params);
        return $url;

    }
}

