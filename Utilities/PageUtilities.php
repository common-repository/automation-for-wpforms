<?php

namespace RNAUTO\Utilities;

class PageUtilities
{
    public static function GetProcessLinkURL()
    {
        $pageId=get_option('rnauto_process_link_page_id',null);
        if($pageId===null)
        {
            $post = array(
                'post_title'   => "Automation Execution",
                'post_content' => "[rnauto_process_link]",
                'post_status'  => 'publish',
                'post_type'    => 'page'
            );

            $pageId = wp_insert_post( $post );

            update_option('rnauto_process_link_page_id',$pageId);
        }

        return $pageId;
    }


    public static function ProcessWorkflowLink()
    {
        $pageId=get_option('rnauto_process_workflow_page_id',null);
        if($pageId===null)
        {
            $post = array(
                'post_title'   => "Workflow Execution",
                'post_content' => "[rnauto_process_workflow]",
                'post_status'  => 'publish',
                'post_type'    => 'page'
            );

            $pageId = wp_insert_post( $post );

            update_option('rnauto_process_workflow_page_id',$pageId);
        }

        return $pageId;
    }
}