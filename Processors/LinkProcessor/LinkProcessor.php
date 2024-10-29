<?php

namespace RNAUTO\Processors\LinkProcessor;


use RNAUTO\DTO\AutomationBuilderOptionsDTO;
use RNAUTO\Processors\HTMLGenerator\HTMLGenerator;
use RNAUTO\Utilities\PageUtilities;

class LinkProcessor
{
    public $Options;
    public $Output;
    /** @var \RNAUTO\Core\Loader  */
    public $Loader;
    /** @var FormBuilder */
    public $Form;
    /** @var AutomationBuilderOptionsDTO */
    public $Automation;

    public function __construct()
    {
        $this->Loader=RNAUTO()->Loader;
    }


    public function ProcessLink($data)
    {

        $this->Options=json_decode(base64_decode($_GET['t']));

        $this->Automation=RNAUTO()->Trigger()->GetAutomationById($this->Options->AutomationId);

        $this->Form=wpforms()->entry->get($this->Options->EntryId,'form');


        if($this->Automation==null)
            return $this->GenerateErrorMessage('Automation not found');

        if($this->Form==null)
            return $this->GenerateErrorMessage('Form not found');

        $result=$this->IsValid();
        if($result!==true)
            return $result;

        if($this->Automation->LinkOptions->RequireConfirmation&&!isset($_GET['sc']))
        {
            return $this->GenerateConfirmationPage();
        }

        $result=RNAUTO()->Trigger()->ExecuteAutomation($this->Options->AutomationId,$this->Options->EntryId,$this->Options->O);


        if($result==false)
        {
            $htmlGenerator=new HTMLGenerator($this->Form,$this->Automation->LinkOptions->ErrorMessage);
            return $this->GenerateErrorMessage($htmlGenerator->GetInline());
        }
        else
        {
            $htmlGenerator=new HTMLGenerator($this->Form,$this->Automation->LinkOptions->SuccessMessage);
            return $this->GenerateSuccessMessage($htmlGenerator->GetInline());
        }


    }

    private function IsValid()
    {
        $data=$this->Options;
        if(isset($data->Nonce))
        {
            if(!wp_verify_nonce($data->Nonce,'execute_automation_'.$data->AutomationId.'_'.$data->EntryId.'_'.$data->O))
                return $this->GenerateErrorMessage('Invalid link');

            $automation=RNAUTO()->Trigger()->GetAutomationById($data->AutomationId);
            $form=$this->Loader->EntryProcessor->GetFormId($data->EntryId);


            if($automation==null)
                return $this->GenerateErrorMessage('Invalid link, automation was not found');

            if($form==null)
                return $this->GenerateErrorMessage('Invalid link, form was not found');

        }else if(isset($data->Ref)){
            global $wpdb;
            $result=$wpdb->get_row($wpdb->prepare('select entry_id EntryId,automation_id AutomationId from '.$this->Loader->AUTOMATIONLINK.' where reference_id=%s',$data->Ref));
            if($result==null)
                return $this->GenerateErrorMessage('Invalid link');

            if($result->AutomationId!=$data->AutomationId&&$result->EntryId!=$data->EntryId)
                return $this->GenerateErrorMessage('Invalid link');
        }

        return true;

    }

    private function GenerateErrorMessage($content)
    {

        return (Object)[
          "Success"=>false,
          "Output"=>'<html>
        <div style="font-family: Verdana">
        <div style="width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;flex-direction: column">
                    <img style="width:256px " src="'.$this->Loader->URL.'images/error.svg"/>
        '.$content.'
        </div>
        </div>
        </html>'
        ];
    }

    private function GenerateSuccessMessage($content)
    {
        return (Object)[
            "Success"=>true,
            "Output"=>'<html>
        <div style="font-family: Verdana">
        <div style="width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;flex-direction: column">
            <img style="width:256px " src="'.$this->Loader->URL.'images/success.svg"/>
             '.$content.'
        </div>
        </div>
        </html>'
        ];
    }

    private function GenerateConfirmationPage()
    {
        $params['action']='RNAUTO_process_link';
        $params['t']=$_GET['t'];
        $params['sc']=1;

        $yesLink=get_permalink(PageUtilities::GetProcessLinkURL());
        if(strpos($yesLink,'?')===false)
            $yesLink.='?';
        else
            $yesLink.='&';
        $yesLink.=  http_build_query($params);

        $htmlGenerator=new HTMLGenerator($this->Form,$this->Automation->LinkOptions->ConfirmationMessage);
        $content=$htmlGenerator->GetInline();


        return (Object)[
            "Success"=>true,
            "Output"=>'<html>
        <div style="font-family: Verdana">
           <link rel="stylesheet" type="text/css" href="'.$this->Loader->URL.'Processors/LinkProcessor/Confirm.css">
            <div style="width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;flex-direction: column">
                <img style="width:256px " src="' . $this->Loader->URL . 'images/question.svg"/>
                 ' . $content . '
                <div style="margin-top: 15px">
                    <a href="#" data-url="'.$yesLink.'" style="text-decoration: none;text-align: center;display:inline-block;min-width: 50px" class="successLink btn btn-success btn-round-1">'.__("Execute",'aio-automation').'</a>                                              
                </div>                           
            </div>                         
             <script >           
               var link=document.querySelector(\'.successLink\');
                link.addEventListener("click",function(e){
                    
                    window.location.href=e.currentTarget.getAttribute("data-url");
                    e.currentTarget.removeAttr("data-url")
                    e.currentTarget.setAttribute("disabled","disabled");
                });
            </script>              
        </div>
        </html>'
        ];
    }

}