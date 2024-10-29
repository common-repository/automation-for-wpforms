<?php


namespace RNAUTO\Settings\Forms\Fields;


class TimeFieldSettings extends FieldSettingsBase
{
    public $TimeFormat;
    


    public function __construct()
    {
        parent::__construct();
        $this->RendererType='Text';
    }

    public function SetTimeFormat($timeFormat)
    {
        $this->TimeFormat=$timeFormat;
        return $this;
    }

    public function InitializeFromOptions($options)
    {
        $this->TimeFormat=$this->GetStringValue($options,'TimeFormat');
        parent::InitializeFromOptions($options); // TODO: Change the autogenerated stub
    }


    public function GetType()
    {
        return 'Time';
    }

}