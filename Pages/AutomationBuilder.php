<?php

namespace RNAUTO\Pages;


use RNAUTO\Adapters\Core\FormProcessorBase;
use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\Integration\IntegrationURL;
use RNAUTO\Core\LibraryManager;
use RNAUTO\Core\PageBase;

class AutomationBuilder extends PageBase
{

    public function Render()
    {
        $libraryManager=new LibraryManager($this->Loader);
        $libraryManager->AddCore();
        $libraryManager->AddTabs();
        $libraryManager->AddCoreUI();
        $libraryManager->AddWPTable();
        $libraryManager->AddPreMadeDialog();
        $libraryManager->AddInputs();
        $libraryManager->AddTextEditor();
        $libraryManager->AddTooltip();

        wp_enqueue_media();
        /** @var FormProcessorBase $loader */
        $loader=$this->Loader;


        $this->Loader->AddScript('common','js/dist/RNAUTOCommonLibs_bundle.js',$libraryManager->GetDependencyHooks());
        $this->Loader->AddStyle('common','js/dist/RNAUTOCommonLibs_bundle.css');





        $this->Loader->AddScript('automationbuilder','js/dist/RNAUTOAutomationBuilder_bundle.js',['@common']);
        $this->Loader->AddStyle('automationbuilder','js/dist/RNAUTOAutomationBuilder_bundle.css');




        $options=null;
        if(isset($_GET['id']))
        {
            $id=intval($_GET['id']);
            $repository=new AutomationRepository($this->Loader);
            $options=$repository->GetAutomationById($id);
        }



        global $wp_roles;
        $rolesToReturn=array();

        foreach($wp_roles->roles as $key=>$role)
        {
            $rolesToReturn[]=["Id"=>$key,"Label"=>$role['name']];
        }


        $this->Loader->LocalizeScript('rnBuilderVar','common','builder',array(
            'Options'=>$options,
            'StatusList'=>[],
            'PluginUrl'=>$this->Loader->URL,
            'ajaxurl'=>IntegrationURL::AjaxURL(),
            "IsPR"=>$this->Loader->IsPR(),
            'PurchaseURL'=>"https://formwiz.rednao.com/downloads/automation-for-wpforms/",
            'FormList'=>$this->Loader->FormProcessor->SyncForms(),
            'BuilderURL'=>IntegrationURL::PageURL('rnauto'),
            'Roles' => $rolesToReturn

        ));

        echo '<div id="app"></div>';


    }
}