<?php


namespace RNAUTO\Core\DB;


use RNAUTO\Core\DB\Core\OptionsManager;
use RNAUTO\Core\DB\Core\RepositoryBase;
use RNAUTO\Core\Loader;
use RNAUTO\DTO\LogOptionsDTO;

class SettingsRepository extends RepositoryBase
{
    /** @var Loader */
    public $Loader;
    /** @var OptionsManager */
    public $OptionsManager;

    public function __construct($loader)
    {
        $this->OptionsManager=new OptionsManager();
        $this->Loader=$loader;
    }


    /**
     * @return object|LogOptionsDTO
     */
    public function GetLog(){
        $log=$this->OptionsManager->GetOption('RNAUTOLog','');

        if($log=='')
            return (object)array(
                'Enable'=>false,
                "LogType"=>0
            );
        return $log;
    }

    public function SaveLog($log){
        $this->OptionsManager->SaveOptions('RNAUTOLog',$log);
    }



}

class FormStatus{
    public $Label;
    public $Type;


    public function __construct($type,$label)
    {
        $this->Label=$label;
        $this->Type=$type;
    }


}

class RecaptchaSettings{
    public $Type;
    public $SiteKey;
    public $SecretKey;
    public $MinimumScore;
}