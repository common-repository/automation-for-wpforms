<?php
/**
 * Created by PhpStorm.
 * User: Edgar
 * Date: 3/28/2019
 * Time: 4:21 AM
 */

namespace RNAUTO\Settings\Forms;


use RNAUTO\Settings\Forms\Fields\ComposedFieldSettings;
use RNAUTO\Settings\Forms\Fields\DateFieldSettings;
use RNAUTO\Settings\Forms\Fields\DateTimeFieldSettings;
use RNAUTO\Settings\Forms\Fields\EntryFieldSettings;
use RNAUTO\Settings\Forms\Fields\FieldSettingsBase;
use RNAUTO\Settings\Forms\Fields\FileUploadFieldSettings;
use RNAUTO\Settings\Forms\Fields\ListFieldSettings\ListFieldSettings;
use RNAUTO\Settings\Forms\Fields\MultipleOptionsFieldSettings;
use RNAUTO\Settings\Forms\Fields\NumberFieldSettings;
use RNAUTO\Settings\Forms\Fields\RatingFieldSettings;
use RNAUTO\Settings\Forms\Fields\SignatureFieldSettings;
use RNAUTO\Settings\Forms\Fields\SubmissionDateFieldSettings;
use RNAUTO\Settings\Forms\Fields\TextFieldSettings;
use RNAUTO\Settings\Forms\Fields\TimeFieldSettings;
use RNAUTO\Settings\Forms\Fields\UserFieldSettings;

abstract class FieldSettingsFactoryBase
{
    /**
     * @param $options
     * @return FieldSettingsBase
     */
    public function GetFieldByOptions($options)
    {
        /** @var FieldSettingsBase $field */
        $field=null;
        switch ($options->Type)
        {
            case 'Text':
                $field=new TextFieldSettings();
                break;
            case 'Number':
                $field=new NumberFieldSettings();
                break;
            case 'Multiple':
                $field=new MultipleOptionsFieldSettings();
                break;
            case 'FileUpload':
                $field=new FileUploadFieldSettings();
                break;
            case 'Composed':
                $field=new ComposedFieldSettings();
                break;
            case 'DateTime':
                $field=new DateTimeFieldSettings();
                break;
            case 'Date':
                $field=new DateFieldSettings();
                break;
            case 'Time':
                $field=new TimeFieldSettings();
                break;
            case 'List':
                $field=new ListFieldSettings();
                break;
            case 'User':
                $field=new UserFieldSettings();
                break;
            case 'EntryId':
                $field=new EntryFieldSettings();
                break;
            case 'Signature':
                $field=new SignatureFieldSettings();
                break;
            case 'Rating':
                $field=new RatingFieldSettings();
                break;


        }

        if($field!=null)
            $field->InitializeFromOptions($options);
        return $field;
    }
}