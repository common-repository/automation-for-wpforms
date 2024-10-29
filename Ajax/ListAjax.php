<?php

namespace RNAUTO\Ajax;


use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\DB\Core\DBManager;
use RNAUTO\Core\DB\WorkflowRepository;

class ListAjax extends AjaxBase
{

    function GetDefaultNonce()
    {
        return 'automationList';
    }

    protected function RegisterHooks()
    {
        $this->RegisterPrivate('delete','Delete');
        $this->RegisterPrivate('delete_workflow','DeleteWorkflow');
        $this->RegisterPrivate('list_automations','ListAutomations');
        $this->RegisterPrivate('list_workflows','ListWorkflows');
    }

    public function Delete(){
        $id=$this->GetRequired('Id');
        $repository=new AutomationRepository($this->Loader);
        $repository->Delete($id);
        $this->SendSuccessMessage(true);

    }

    public function DeleteWorkflow(){
        $id=$this->GetRequired('Id');
        $repository=new WorkflowRepository($this->Loader);
        $repository->Delete($id);
        $this->SendSuccessMessage(true);

    }

    public function ListAutomations($sortBy=null,$pageSize=null,$index=null,$direction=null,$search=null)
    {
        if($sortBy===null)
            $sortBy=$this->GetRequired('SortBy');

        if($pageSize===null)
            $pageSize=$this->GetRequired('PageSize');

        if($index===null)
            $index=$this->GetRequired('Index');

        if($direction===null)
            $direction=$this->GetRequired('Direction');

        if($search==null)
            $search=$this->GetOptional('Search','');

        if($direction!='asc')
            $direction='desc';


        $db=new DBManager();
        $searchFilter='';
        if($search!='')
        {
            $searchFilter=' where (name like "%%'.$db->EscapeLike($search).'%%")';
        }


        $automationTable=$this->Loader->AUTOMATIONTABLE;
        $result=$db->GetResults("select id Id,name Name 
                                    from {$automationTable} template 
                                    ".$searchFilter."
                                    order by name ".$direction."
                                    limit %d,%d",$index*$pageSize,$pageSize);

        $count=$db->GetVar("select count(*) Count
                                    from {$automationTable} template
                                    ".$searchFilter);



        return $this->SendSuccessMessage(['Result'=>$result,'Count'=>$count]);


    }

    public function ListWorkflows($sortBy=null,$pageSize=null,$index=null,$direction=null,$search=null)
    {
        if($sortBy===null)
            $sortBy=$this->GetRequired('SortBy');

        if($pageSize===null)
            $pageSize=$this->GetRequired('PageSize');

        if($index===null)
            $index=$this->GetRequired('Index');

        if($direction===null)
            $direction=$this->GetRequired('Direction');

        if($search==null)
            $search=$this->GetOptional('Search','');

        if($direction!='asc')
            $direction='desc';


        $db=new DBManager();
        $searchFilter='';
        if($search!='')
        {
            $searchFilter=' where (name like "%%'.$db->EscapeLike($search).'%%")';
        }


        $automationTable=$this->Loader->WORKFLOWTABLE;
        $result=$db->GetResults("select id Id,name Name 
                                    from {$automationTable} template 
                                    ".$searchFilter."
                                    order by name ".$direction."
                                    limit %d,%d",$index*$pageSize,$pageSize);

        $count=$db->GetVar("select count(*) Count
                                    from {$automationTable} template
                                    ".$searchFilter);



        return $this->SendSuccessMessage(['Result'=>$result,'Count'=>$count]);


    }
}