<?php

namespace RNAUTO\Core;

use RNAUTO\Core\Managers\EntrySaver\FormEntrySaver;

class EntryMonitor
{
    /** @var Loader */
    public $loader;
    public function __construct($loader)
    {
        $this->loader=$loader;

    }

    /**
     * @param $entry FormEntrySaver
     * @return void
     */
    public function AfterSubmit($entry)
    {
        RNAUTO()->Trigger()->ExecuteTriggerByType('form_submitted',$entry->FormBuilder);
        RNAUTO()->Workflow()->ExecuteWorkflowByType('form_submitted',$entry->FormBuilder);
    }

    public function EntryUpdated($entry,$originalEntry)
    {
        remove_action('allinoneforms_after_editing_entry',array($this,'EntryUpdated'),10,2);
        RNAUTO()->Trigger()->ExecuteTriggerByType('entry_updated',$entry->FormBuilder);

        RNAUTO()->Workflow()->ExecuteWorkflowByType('entry_updated',$entry->FormBuilder);
        add_action('allinoneforms_after_editing_entry',array($this,'EntryUpdated'),10,2);
    }

    public function BeforeDeleteEntry($entryId)
    {

    }
}