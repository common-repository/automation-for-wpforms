<?php


namespace RNAUTO\Core\Integration;




use RNAUTO\Core\Loader;

class IntegrationURL
{
    public static function PageURL($page)
    {
        return \admin_url('admin.php').'?page='.$page;
    }

    public static function AjaxURL()
    {
        return admin_url( 'admin-ajax.php' );
    }

    /**
     * @param $loader Loader
     */



}