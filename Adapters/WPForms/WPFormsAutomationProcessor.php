<?php

namespace RNAUTO\Adapters\WPForms;

use RNAUTO\Adapters\Core\AutomationProcessorBase;
use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Processors\TriggerProcessors\Core\TriggerProcessorBase;

class WPFormsAutomationProcessor extends AutomationProcessorBase
{

    public function __construct($loader)
    {
        parent::__construct($loader);
        add_action('wpforms_process_complete',array($this,'FormSubmitted'),10,4);
        add_action('wpforms_pro_admin_entries_edit_submit_completed',array($this,'EditEntry'),100,4);
        add_action('wpforms_pre_delete_entries',array($this,'DeleteEntry'));

    }



    public function FormSubmitted( $fields, $entry, $form_data, $entry_id ) {
        $retriever=$this->loader->EntryProcessor->CreateRetriever(wpforms()->entry->get($entry_id),$form_data);
        $this->ExecuteActionsByType('form_submitted',$retriever);
        if($this->loader->IsPR())
            RNAUTO()->Workflow()->ExecuteWorkflowByType('form_submitted',$retriever);

    }

    public function DeleteEntry($entryId)
    {
        $entry=$entry=wpforms()->entry->get($entryId);
        if($entry==null)
            return;
        $formData=wpforms()->form->get($entry->form_id);
        if($formData==null)
            return;

        $form=json_decode($formData->post_content,true);

        $retriever=$this->loader->EntryProcessor->CreateRetriever($entry,$form);
        $this->ExecuteActionsByType('entry_deleted',$retriever);
/*
        $processors=$triggers=$this->GetTriggersByType('entry_deleted',$retriever);
        $processorsToExecute=[];
        foreach($processors as $currentProcessor)
            if($currentProcessor->ShouldExecute($retriever))
                $processorsToExecute[]=$currentProcessor;

        if(count($processorsToExecute)>0)
        {
            $callback=null;
            $callback=function () use($processorsToExecute,$retriever,$callback){
                foreach($processorsToExecute as $currentProcessor)
                {
                    $currentProcessor->Execute($retriever);
                }
                remove_action('wpforms_post_delete_entries',$callback);

            };
            add_action('wpforms_post_delete_entries',$callback);
        }*/
    }

    public function EditEntry($formData,$response,$uploadedfields,$entry){
        $newEntry=wpforms()->entry->get($entry->entry_id);
        $retriever=$this->loader->EntryProcessor->CreateRetriever($newEntry,$formData,$entry);
        $this->ExecuteActionsByType('entry_updated',$retriever);
        if($this->loader->IsPR())
            RNAUTO()->Workflow()->ExecuteWorkflowByType('entry_updated',$retriever);
    }


}