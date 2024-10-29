<?php


namespace RNAUTO\Settings\Forms\Fields;


class UserFieldSettings extends FieldSettingsBase
{

    public function __construct()
    {
        parent::__construct();
    }


    public function GetType()
    {
        return 'User';
    }
}