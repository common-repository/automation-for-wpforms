<?php

namespace RNAUTO\Adapters\WPForms;

use RNAUTO\Core\Loader;
use RNAUTO\pr\Adapters\WPForms\WPFormsAutomationProcessorPr;
use RNAUTO\pr\Processors\WorkFlowProcessor\WorkflowProcessor;

class WPFormsSubLoader extends Loader
{
    /** @var WPFormProcessor */

    public $AutomationProcessor;
    public $WorkflowProcessor;
    public $AutomationProcessorPr;
    public function __construct($dbVersion, $fileVersion, $rootFilePath, $config = null)
    {
        parent::__construct('RNAUTO', $dbVersion, $fileVersion, $rootFilePath, $config);
        $this->FormProcessor=new WPFormProcessor($this);
        $this->AutomationProcessor=new WPFormsAutomationProcessor($this);
        $this->EntryProcessor=new WPFormsEntryProcessor($this);

        $this->AddMenu('Automation for WPForms','rnauto','administrator','','RNAUTO\Pages\AutomationList');
        if($this->IsPR())
        {
            $this->AddMenu('Workflow', 'rnauto-workflow', 'administrator', '', 'RNAUTO\Pages\WorkflowList');
            $this->WorkflowProcessor=new WorkflowProcessor($this);
            $this->AutomationProcessorPr=new WPFormsAutomationProcessorPr($this);
        }
        else
            $this->AddMenu('Workflow (Full Version Only)','rnauto-workflow','administrator','','RNAUTO\Pages\WorkflowList');
    }


    public function GetMenuTitle()
    {
        return 'Automation WF';
    }

    public function GetPurchaseURL()
    {
        return 'http://www.google.com';
    }
}