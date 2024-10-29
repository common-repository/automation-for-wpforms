<?php

namespace RNAUTO\Ajax;

use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\Core\DB\Core\DBManager;
use RNAUTO\Core\DB\WorkflowRepository;
use RNAUTO\Core\Exception\FriendlyException;
use RNAUTO\DTO\AutomationBuilderOptionsDTO;
use RNAUTO\DTO\WorkFlowBuilderOptionsDTO;

class BuilderAjax extends AjaxBase
{

    function GetDefaultNonce()
    {
        return 'builder';
    }

    protected function RegisterHooks()
    {
        $this->RegisterPrivate('save','Save');
        $this->RegisterPrivate('list_users','QueryUsers','administrator',true);
        $this->RegisterPrivate('load_users_by_id','LoadUsersById','administrator');
        $this->RegisterPrivate('save_workflow','SaveWorkflow','administrator');

    }

    public function SaveWorkflow(){
        /** @var WorkFlowBuilderOptionsDTO $options */
        $options=$this->GetRequired('Options');

        $workflowBuilder=(new WorkFlowBuilderOptionsDTO())->Merge($options);
        $repository=new WorkflowRepository($this->Loader);

        $repository->Save($workflowBuilder);
        $this->SendSuccessMessage(["Id"=>$workflowBuilder->Id]);
    }

    public function LoadUsersById(){
        $ids=$this->GetRequired('Ids');

        $escapedIds=[];
        $users=[];
        global $wpdb;
        foreach($ids as $currentId)
        {
            $escapedIds[]=intval($currentId);
        }

        $dbmanager=new DBManager();

        if(count($escapedIds)>0)
        {
            $result=$dbmanager->GetResults("
                select ID,firstname.meta_value user_firstname,lastname.meta_value last_name,user_email user_email
                from ".$wpdb->users." usert
                left join ".$wpdb->usermeta." firstname on usert.ID = firstname.user_id and firstname.meta_key='first_name'
                left join ".$wpdb->usermeta." lastname on usert.ID = lastname.user_id and lastname.meta_key='last_name'
                where usert.ID in(" . implode($escapedIds) . ")
            ");

            foreach($result as $currentUser)
            {
                $users[]=[
                    'Label'=>$currentUser->user_firstname.' '.$currentUser->last_name.' ('.$currentUser->user_email.')',
                    'Value'=>$currentUser->ID
                ];
            }
        }
        $this->SendSuccessMessage($users);
    }
    public function Save(){
        /** @var AutomationBuilderOptionsDTO $options */
        $options=$this->GetRequired('Options');

        $automationBuilder=(new AutomationBuilderOptionsDTO())->Merge($options);
        $repository=new AutomationRepository($this->Loader);

        $repository->Save($automationBuilder);
        $this->SendSuccessMessage(["Id"=>$automationBuilder->Id]);
    }

    public function QueryUsers(){
        $query=$this->GetRequired('query');
        $wp_user_query = new \WP_User_Query(
            array(
                'search' => "*{$query}*",
                'search_columns' => array(
                    'user_login',
                    'user_nicename',
                    'user_email',
                ),

            ) );
        $users = $wp_user_query->get_results();

//search usermeta
        $wp_user_query2 = new \WP_User_Query(
            array(
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'first_name',
                        'value' => $query,
                        'compare' => 'LIKE'
                    ),
                    array(
                        'key' => 'last_name',
                        'value' => $query,
                        'compare' => 'LIKE'
                    )
                )
            )
        );

        $users2 = $wp_user_query2->get_results();

        $totalusers_dup = array_merge($users,$users2);

        /** @var \WP_User[] $totalusers */
        $totalusers = array_unique($totalusers_dup, SORT_REGULAR);

        $info=[];
        foreach($totalusers as $currentUser)
        {
            $info[]=[
                'Label'=>$currentUser->user_firstname.' '.$currentUser->last_name.' ('.$currentUser->user_email.')',
                'Value'=>$currentUser->ID
            ];
        }

        $this->SendSuccessMessage($info);
    }

}