<?php


namespace RNAUTO\Settings\Forms\Fields;


use RNAUTO\Utilities\Sanitizer;

class SignatureFieldSettings extends FieldSettingsBase
{
    public function __construct()
    {
        parent::__construct();
        $this->RendererType='Signature';
        $this->IsPR=true;
    }

    public function GetType()
    {
        return 'Signature';
    }

    public function GetURL($value){
        return Sanitizer::GetStringValueFromPath($value,['Value']);

    }

}