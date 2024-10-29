<?php

namespace RNAUTO\Core;


abstract class PluginBase
{
    public $Version=1;
    public $NAME;
    public $DIR;
    public $URL;
    public $Prefix;
    private $FILE_VERSION;
    private $menuSlugs=[];
    private $dbVersion=0;
    private $menus=array();
    public $RootPath;
    public $Config;



    public function __construct($prefix,$dbVersion,$fileVersion,$rootFilePath,$config=null)
    {
        $this->Config=$config;
        $this->RootPath=$rootFilePath;
        $this->dbVersion=$dbVersion;
        $this->FILE_VERSION=$fileVersion;
        if($prefix=='')
            return;
        $this->NAME=\basename(dirname(dirname(__FILE__)));
        $this->DIR=dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR;
        $this->URL=\plugin_dir_url($this->DIR).$this->NAME.'/';
        $this->Prefix=$prefix;
        $this->CreateHooks();
        $this->CreateInternalHooks();

    }



    public function GetConfig($configName,$defaultValue='')
    {
        if(!isset($this->Config[$configName]))
            return $defaultValue;

        return $this->Config[$configName];
    }



    public function ParseDependencyName($name)
    {
        return $this->Prefix.'_'.$name;
    }


    public function AddScript($handler,$src,$dep=array())
    {
        foreach($dep as &$dependencyName)
        {
            $dependencyName=\str_replace('@',$this->Prefix.'_',$dependencyName);
        }
        wp_enqueue_script($this->Prefix.'_'.$handler,$this->URL.$src,$dep,$this->FILE_VERSION);
        return $this->Prefix.'_'.$handler;
    }


    public function LocalizeScript($varName, $handler,$nonceName,$data)
    {
        if($nonceName!=null)
        {
            $data['_nonce']=\wp_create_nonce($this->Prefix.'_'.$nonceName);
        }

        $data['_prefix']=$this->Prefix;
        wp_localize_script($this->Prefix.'_'.$handler,$varName,$data);
    }

    public function AddStyle($handler,$src,$dep=array())
    {
        wp_enqueue_style($this->Prefix.'_'.$handler,$this->URL.$src,$dep,$this->FILE_VERSION);
    }

    public abstract function CreateHooks();
    public function GetMenus(){
        return null;
    }


    private function CreateInternalHooks()
    {
        add_action('admin_menu',array($this,'_CreateMenu'));
        add_action('admin_init',array($this,'MaybeCreateTables'));
        register_activation_hook($this->RootPath,array($this,'activated'));
    }

    public function activated(){
        $this->MaybeCreateTables();
        $this->OnPluginIsActivated();
    }

    public function MaybeCreateTables(){

        $optionName='rednao_'.$this->Prefix.'_db_version';
        $dbversion=get_option($optionName,0);
        if($dbversion<$this->dbVersion)
        {
            $this->OnCreateTable();
            update_option($optionName,$this->dbVersion);
        }
    }

    public function OnPluginIsActivated(){


    }

    public function OnCreateTable(){

    }

    public function _CreateMenu(){
        if(count($this->menus)==0)
            return;


        $MainMenu=$this->menus[0];
        \add_menu_page($MainMenu['Title'],$MainMenu['Title'],$MainMenu['Capability'],$MainMenu['Slug'],function()use($MainMenu){
            $this->LoadMenu($MainMenu['Path']);
        },$MainMenu['Icon']);

        for($i=1;$i<count($this->menus);$i++)
        {

            $path=$this->menus[$i]['Path'];
            \add_submenu_page($MainMenu['Slug'],$this->menus[$i]['Title'],$this->menus[$i]['Title'],$this->menus[$i]['Capability'],$this->menus[$i]['Slug'], function()use($path){
                $this->LoadMenu($path);
            });
        }

    }



    private function LoadMenu($path){
        global $rninstance;
        $rninstance=$this;

        /** @var PageBase $class */
        $class= new $path($this);
        $class->Render();
    }



    public function AddMenu($title,$slug,$capability,$icon,$path)
    {
        if(count($this->menus)==0)
            $this->menuSlugs['toplevel_page_'.$slug]='1';
        else
            $this->menuSlugs[$this->menus[0]['Slug'].'/'.$slug]='1';
        $this->menus[]=array('Title'=>$title,"Slug"=>$slug,"Capability"=>$capability,"Icon"=>$icon,"Path"=>$path);
    }



    public function CreateNonceForAjax($ajaxNonce)
    {
        return \wp_create_nonce($this->Prefix.'_'.$ajaxNonce);
    }


}