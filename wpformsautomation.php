<?php

/**
 * Plugin Name: Automation for WPForms
 * Plugin URI: https://pagebuilder.rednao.com/getit/
 * Description: Execute automatic actions with your WPForm entries
 * Author: RedNao
 * Author URI: http://rednao.com
 * Version: 1.24
 * Text Domain: aio-automation
 * Domain Path: /languages/
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 * Slug: automation-for-allinoneforms
 */

require_once dirname(__FILE__).'/AutoLoad.php';

new \RNAUTO\Adapters\WPForms\WPFormsSubLoader('RNAUTO',27,2,__FILE__,[
    'ItemId'=>16,
    'Author'=>'Edgar Rojas',
    'UpdateURL'=>'https://pagebuilder.rednao.com',
    'FileGroup'=>'PageBuilderForWPForms'
]);

if(!function_exists("RNAUTO"))
{

    function RNAUTO()
    {
        return \RNAUTO\Core\Loader::$Api;
    }
}