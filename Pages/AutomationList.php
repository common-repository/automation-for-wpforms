<?php

namespace RNAUTO\Pages;

use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\Integration\IntegrationURL;
use RNAUTO\Core\LibraryManager;
use RNAUTO\Core\PageBase;

class AutomationList extends PageBase
{

    public function Render()
    {

        if(isset($_GET['id']))
        {
            $automation=new AutomationBuilder($this->Loader);
            $automation->Render();
            return;
        }

        $libraryManager=new LibraryManager($this->Loader);
        $libraryManager->AddCore();
        $libraryManager->AddTabs();
        $libraryManager->AddCoreUI();
        $libraryManager->AddWPTable();
        $libraryManager->AddPreMadeDialog();


        $this->Loader->AddScript('pagelist','js/dist/RNAUTOAutomationList_bundle.js',$libraryManager->GetDependencyHooks());
        $this->Loader->AddStyle('pagelist','js/dist/RNAUTOAutomationList_bundle.css');

        $automationRepository=new AutomationRepository($this->Loader);
        $this->Loader->LocalizeScript('rnListVar','pagelist','automationList',array(
            'AutomationList'=>$automationRepository->AutomationList(30,0),
            'PluginUrl'=>$this->Loader->URL,
            'Count' => $automationRepository->AutomationCount(),
            'ajaxurl'=>IntegrationURL::AjaxURL(),
            'TemplateURL'=>IntegrationURL::PageURL('rnauto'),
            "IsPR"=>$this->Loader->IsPR(),
            'PurchaseURL'=>"https://formwiz.rednao.com/downloads/automation-for-wpforms/"
        ));

        echo '<div id="app"></div>';
    }
}