<?php

namespace RNAUTO\Ajax;

use RNAUTO\Core\DB\WorkflowRepository;

class WorkflowProcessor extends AjaxBase
{

    function GetDefaultNonce()
    {

    }

    protected function RegisterHooks()
    {
        $this->RegisterPublic('ProcessWorkflow', 'ProcessWorkflow','',false);
    }

    public function ProcessWorkflow(){
        $string=$this->GetRequired('String');
        $data=json_decode(base64_decode($string));

        if(count($data)!=2)
            $this->SendErrorMessage('Invalid link, please refresh the screen and try again');


        if(wp_verify_nonce($data[1],$data[0])===false)
            $this->SendErrorMessage('Invalid nonce, please refresh the screen and try again');

        $data=json_decode($data[0]);



        $repository=new WorkflowRepository($this->Loader);
        $workflow=$repository->GetWorkflowByIdAndEntryId($data->WorkflowId,$data->EntryId);

        if($workflow==null)
            $this->SendErrorMessage('Invalid workflow');

        try{
            $workflow->ProcessLink($data);
        }catch (\Exception $e)
        {
            $this->SendErrorMessage($e->getMessage());
        }

        $workflow=$repository->GetWorkflowByIdAndEntryId($data->WorkflowId,$data->EntryId);

        $this->SendSuccessMessage(["Panel"=>$workflow->RenderStatusPanel()]);


    }


}