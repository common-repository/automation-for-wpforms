<?php

namespace RNAUTO\Core;

use RNAUTO\Adapters\Core\FormProcessorBase;
use RNAUTO\Ajax\BuilderAjax;
use RNAUTO\Ajax\ListAjax;
use RNAUTO\Ajax\TriggerAjax;
use RNAUTO\Ajax\WorkflowProcessor;
use RNAUTO\Api\AutomationApi;
use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\TwigManager\TwigManager;
use RNAUTO\HTMLParser\AutomationParser;
use RNAUTO\Pages\AutomationList;
use RNAUTO\Pages\WorkflowList;
use RNAUTO\Processors\EntryProcessor\EntryProcessorBase;
use RNAUTO\Processors\LinkProcessor\LinkProcessor;

class Loader extends PluginBase
{
    public $AUTOMATIONTABLE;
    public $WORKFLOWTABLE;
    public $WORKFLOWPROCESSION;
    public $AUTOMATIONLINK;
    /** @var FormProcessorBase */
    public $FormProcessor;
    /** @var EntryProcessorBase */
    public $EntryProcessor;
    public $FORMCONFIG;
    /** @var AutomationApi */
    public static $Api;
    public function __construct($prefix, $dbVersion, $fileVersion, $rootFilePath, $config = null)
    {
        global $wpdb;
        $this->AUTOMATIONTABLE=$wpdb->prefix.'rnautomation';
        $this->AUTOMATIONLINK=$wpdb->prefix.'rnautomation_link';
        $this->WORKFLOWTABLE=$wpdb->prefix.'rnautomation_workflow';
        $this->WORKFLOWPROCESSION=$wpdb->prefix.'rnautomation_workflow_proc';
        parent::__construct($prefix, $dbVersion, $fileVersion, $rootFilePath, $config);
        add_filter('allinoneforms_get_additional_actions',array($this,'GetAdditionalActions'),10,3);
        add_filter('allinoneforms_get_additional_action_sections',array($this,'GetAdditionalActionSections'),10,3);
        add_action( 'init', function (){
            load_plugin_textdomain( 'aio-automation', false, dirname( plugin_basename( dirname(__FILE__) ) ) . '/languages/' );
        } );

        add_shortcode('rnauto_process_link',array($this,'ProcessLink'));
        add_shortcode('rnauto_process_workflow',array($this,'ProcessWorkflow'));



        self::$Api=new AutomationApi($this);
        new BuilderAjax($this);
        new ListAjax($this);
        new EntryMonitor($this);
        new TriggerAjax($this);
        new WorkflowProcessor($this);
    }


    public function ProcessWorkflow(){
        return '1';
    }
    public function ProcessLink(){
        if(!isset($_GET['t']))
            return "Invalid link";
        $data=json_decode(base64_decode($_GET['t']));

        if(!isset($data->AutomationId)||!isset($data->EntryId))
            return 'Invalid link';

        $linkProcessor=new LinkProcessor();
        $result=$linkProcessor->ProcessLink($_GET['t']);
        echo $result->Output;
        die();
    }
    public function GetAdditionalActionSections($content,$formid,$entryid)
    {
        $workflows=RNAUTO()->Workflow()->GetEntryWorkFlows($entryid);

        foreach($workflows as $currentWorkflow)
        {
            $content.=$currentWorkflow->RenderStatusPanel();

        }

        return $content;

    }

    public function GetAdditionalActions($content,$formId,$entryId){
        global $wpdb;
        $automations=$wpdb->get_results($wpdb->prepare('select id Id,name Name from '.$this->AUTOMATIONTABLE.' where formid=%d and include_in_entry=1',$formId));


        foreach($automations as $currentAutomation)
        {

            $url=RNAUTO()->Trigger()->GenerateAutomationLink($currentAutomation->Id,$entryId);
            if($url!=null)
            {
                $content .= '<div class="actionItem">
                                <a target="_blank" href="' . esc_attr($url) . '">' . __("Aut: ", "aio-automation") . " " . $currentAutomation->Name . '</a>
                            </div>';
            }
        }

        return $content;
    }

    public function GetHtmlParser($parser,$data,$formBuilder,$parent)
    {
        if($data->type!='automation')
            return $parser;


        return new AutomationParser($formBuilder,$parent,$data);
    }

    public function LoadJSDesigner($dependencies)
    {
        $dependencies=[''];

        $autoRepository=new AutomationRepository($this);
        $dependencies[]=$this->AddScript('aut_designer','js/dist/RNAUTODesigner_bundle.js',$dependencies);
        $this->LocalizeScript('rnAutoDesignerVar','aut_designer','',[
            'AutomationList'=>$autoRepository->AutomationList()['Automations']
        ]);
        return $dependencies;
    }

    public function AutomationPage(){
        (new AutomationList($this))->Render();
    }

    public function WorkflowPage(){
        (new WorkflowList($this))->Render();
    }

    public function  IsPR(){
        return file_exists($this->DIR.'pr');
    }

    public function GetTwigManager($paths=[]){

        if($this->Twig==null)
        {
            $this->Twig=new TwigManager($this,$paths);
        }
        return $this->Twig;
    }

    public function CreateHooks()
    {
        // TODO: Implement CreateHooks() method.
    }

    public function MaybeCreateTables()
    {
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        $sql = "CREATE TABLE " . $this->AUTOMATIONTABLE . " (
                id INT AUTO_INCREMENT,
                include_in_entry TINYINT,
                status VARCHAR(100),
                name VARCHAR(200) NOT NULL,
                auto_trigger LONGTEXT,
                actions LONGTEXT,
                trigger_type VARCHAR(50),
                formid varchar(10),
                link_options LONGTEXT,
                PRIMARY KEY (id)
                ) COLLATE utf8_general_ci;";
        \dbDelta($sql);

        $sql = "CREATE TABLE " . $this->AUTOMATIONLINK . " (
                id BIGINT AUTO_INCREMENT,
                automation_id INT,
                entry_id BIGINT,
                options LONGTEXT,
                reference_id VARCHAR(100),
                expiration_date datetime,
                PRIMARY KEY (id),
                KEY entry_id (entry_id),
                KEY automation_id (automation_id),
                KEY expiration_date (expiration_date),
                KEY reference_id (reference_id)
                ) COLLATE utf8_general_ci;";
        \dbDelta($sql);


        $sql = "CREATE TABLE " . $this->WORKFLOWTABLE . " (
                id INT AUTO_INCREMENT,
                trigger_type VARCHAR(50),
                status VARCHAR(100),
                name VARCHAR(200) NOT NULL,
                node LONGTEXT,
                formid varchar(10),
                PRIMARY KEY (id)
                ) COLLATE utf8_general_ci;";
        \dbDelta($sql);

        $sql = "CREATE TABLE " . $this->WORKFLOWPROCESSION . " (
                id INT AUTO_INCREMENT,            
                entry_id BIGINT,
                workflow_id BIGINT,
                current_step BIGINT,
                data LONGTEXT,
                status VARCHAR(500),
                last_update datetime,
                PRIMARY KEY (id),        
                KEY workflowid (workflow_id),
                KEY entryid (entry_id)
                ) COLLATE utf8_general_ci;";
        \dbDelta($sql);



    }




}