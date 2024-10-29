<?php

namespace RNAUTO\Pages;

use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\DB\WorkflowRepository;
use RNAUTO\Core\Integration\IntegrationURL;
use RNAUTO\Core\LibraryManager;
use RNAUTO\Core\PageBase;

class WorkflowList extends PageBase
{

    public function Render()
    {

        if(isset($_GET['id']))
        {
            $automation=new WorkflowBuilder($this->Loader);
            $automation->Render();
            return;
        }

        if(!$this->Loader->IsPR())
        {
            ?>
                <div>
                    <div style="margin:20px;background-color: white;border-radius: 10px;border:1px solid #ccc;display: flex;padding: 20px;align-items: center">
                        <img style="align-self: flex-start" src="<?php echo $this->Loader->URL.'images/icons128.png'?>"/>
                        <div style="padding-left: 10px">
                            <h1 style="margin: 0;padding: 0;">Sorry workflows are only available in the full version</h1>
                            <p>With workflows you can create full systems that are executed depending on the users actions </p>
                            <div>
                                <img style="border:1px solid #ccc;width: 100%" src="<?php echo $this->Loader->URL.'images/workflow.png'?>"/>
                                <a href="https://formwiz.rednao.com/downloads/automation-for-wpforms/" class="button button-primary">Get the full version</a>
                            </div>

                        </div>
                    </div>

                </div>
            <?php
            return;
        }

        $libraryManager=new LibraryManager($this->Loader);
        $libraryManager->AddCore();
        $libraryManager->AddTabs();
        $libraryManager->AddCoreUI();
        $libraryManager->AddWPTable();
        $libraryManager->AddPreMadeDialog();


        $this->Loader->AddScript('pagelist','js/dist/RNAUTOWorkflowList_bundle.js',$libraryManager->GetDependencyHooks());
        $this->Loader->AddStyle('pagelist','js/dist/RNAUTOWorkflowList_bundle.css');

        $workflowRepository=new WorkflowRepository($this->Loader);
        $this->Loader->LocalizeScript('rnWorkflowListVar','pagelist','automationList',array(
            'WorkflowList'=>$workflowRepository->WorkflowList(30,0),
            'PluginUrl'=>$this->Loader->URL,
            'Count' => $workflowRepository->WorkflowCount(),
            'ajaxurl'=>IntegrationURL::AjaxURL(),
            'TemplateURL'=>IntegrationURL::PageURL('rnauto-workflow'),
            "IsPR"=>1,
            'PurchaseURL'=>"https://formwiz.rednao.com/downloads/automation-for-wpforms/"
        ));

        echo '<div id="app"></div>';
    }
}