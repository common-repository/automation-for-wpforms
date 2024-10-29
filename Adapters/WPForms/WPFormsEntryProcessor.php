<?php

namespace RNAUTO\Adapters\WPForms;

use RNAUTO\Processors\EntryProcessor\EntryItems\ComposedEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Processors\EntryProcessor\EntryItems\CurrencyEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\CurrencyMultipleEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\DateEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\DateTimeEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\FileUploadEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\HTMLEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\LikertScaleEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\MultipleSelectionEntryItem\MultipleSelectionEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\NumberEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\RatingEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\SignatureEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\SimpleTextEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryItems\TimeEntryItem;
use RNAUTO\Processors\EntryProcessor\EntryProcessorBase;
use RNAUTO\Utilities\Sanitizer;

class WPFormsEntryProcessor extends EntryProcessorBase
{

    public function UpdateEntry($entryId,$dataToUpdate)
    {
        \wpforms()->get( 'entry' )->update(
            $entryId,$dataToUpdate
        );
    }

    public function SerializeEntry($originalEntry,$formSettings)
    {
        /** @var EntryItemBase $entryItems */
        $entryItems=array();
        $originalEntry=(object)(array)$originalEntry;

        $entry=new WPFormsEntry();
        if(is_array($originalEntry->fields))
            $originalEntry->fields=$originalEntry->fields;
        else
            $originalEntry->fields=\json_decode($originalEntry->fields,true);
        $entry->SetOriginalEntry($originalEntry);
        $entry->SetEntryId($originalEntry->entry_id);

        if(isset($originalEntry->user_id))
            $entry->SetUserId($originalEntry->user_id);

        foreach($originalEntry->fields as $key=>$value)
        {
            $currentField = null;
            foreach ($formSettings->Fields as $field)
            {
                if ($field->Id == $key)
                {
                    $currentField = $field;
                    break;
                }
            }

            if ($currentField == null)
                continue;

            $found = false;
            switch ($currentField->Type)
            {
                case 'Currency':
                    $entry->AddField((new CurrencyEntryItem())->Initialize($currentField)->SetValue($value['value'])->SetAmount($value['amount'])->SetAmountRaw($value['amount_raw']));
                    $found = true;
                    break;
                case 'HTML':
                    $entry->AddField((new HTMLEntryItem())->Initialize($currentField)->SetHTML($value['value']));
                    $found = true;
                    break;
                case 'Text':
                    $entry->AddField((new SimpleTextEntryItem())->Initialize($currentField)->SetValue($value['value']));
                    $found = true;
                    break;

                case 'Rating':
                    $entry->AddField((new RatingEntryItem())->Initialize($currentField)->SetValue($value));
                    $found = true;
                    break;
                case 'Number':
                    $entry->AddField( (new NumberEntryItem())->Initialize($currentField)->SetValue((Sanitizer::SanitizeNumber($value['value']))));
                    $found = true;
                    break;
                case 'Composed':
                    $entry->AddField( (new ComposedEntryItem())->Initialize($currentField)->SetValue( $value['value']==''?[]:$value)->SetFormattedValue($value['value']));
                    $found = true;
                    break;
                case 'Date':
                    $entry->AddField( (new DateEntryItem())->Initialize($currentField)->SetUnix($value['unix'])->SetValue($value['value']));
                    $found = true;
                    break;
                case 'Time':
                    $entry->AddField( (new TimeEntryItem())->Initialize($currentField)->SetUnix(strtotime("01/01/1970 " . $value['value']))->SetValue($value['value']));
                    $found = true;
                    break;
                case 'DateTime':
                    $entry->AddField( (new DateTimeEntryItem())->Initialize($currentField)->SetUnix($value['unix'])->SetValue($value['value']));
                    $found = true;
                    break;
                case 'FileUpload':
                    $fileItem = (new FileUploadEntryItem());
                    $fileItem->Initialize($currentField);

                    if (!isset($value['value_raw']) || $value['value_raw'] == '')
                    {
                        $found = true;
                        break;
                    }
                    foreach ($value['value_raw'] as $currentValue)
                    {
                        if (!isset($currentValue['value']) || $currentValue['value'] == '')
                            continue;

                        $file = $fileItem->CreateAndAddFile();
                        $file->URL = $currentValue['value'];

                        if (isset($currentValue['ext']))
                            $file->Extension = $currentValue['ext'];

                        if (isset($currentValue['name']))
                            $file->Name = $currentValue['name'];

                        if (isset($currentValue['type']))
                            $file->Mime = $currentValue['type'];

                    }


                    $entry->AddField( $fileItem);
                    $found = true;
                    break;
                case 'Signature':
                    $entry->AddField((new SignatureEntryItem())->Initialize($currentField)->SetValue($value['value']));
                    $found = true;
                    break;
                case 'CurrencyMultiple':
                    $currencyMultipleItems = (new CurrencyMultipleEntryItem())->Initialize($currentField);
                    if (!isset($value['value']))
                        break;

                    $items = preg_split("/\r\n|\n|\r/", $value['value']);
                    foreach ($items as $currentItem)
                    {
                        if($currentItem=='')
                            continue;
                        $sections = explode(';', $currentItem);
                        $currencyMultipleItems->AddItem($currentItem, 0);
                    }

                    $currencyMultipleItems->SetAmountRaw($value['amount_raw']);
                    $currencyMultipleItems->SetAmount($value['amount']);


                    $entry->AddField($currencyMultipleItems);
                    $found = true;
                    break;
                case 'LikertScale':
                    $likert = (new LikertScaleEntryItem())->Initialize($currentField);

                    foreach ($value['value_raw'] as $rowIndex => $currentRow)
                    {
                        if (!is_array($currentRow))
                            $currentRow = [$currentRow];
                        foreach ($currentRow as $columnIndex)
                        {
                            if (!isset($currentField->Rows[$rowIndex]) || !!isset($currentField->Columns[$columnIndex]))
                            {
                                $likert->AddValue($currentField->Rows[$rowIndex], $currentField->Columns[$columnIndex]);
                            }

                        }
                    }
                    $entry->AddField($likert);
                    $found = true;
                    break;
                case 'Multiple':
                    if($value['value']!='')
                        $value = explode("\n", $value['value']);
                    else
                        $value=[];

                    if (!is_array($value))
                        $value = [$value];

                    $currentField = (new MultipleSelectionEntryItem())->Initialize($currentField);
                    foreach ($value as $currentValue)
                    {
                        $currentField->AddItem($currentValue);
                    }

                    $found = true;
                    $entry->AddField($currentField);

            }


        }
        return $entry;
    }

    public function GetFormId($entryId)
    {
        $entry=wpforms()->entry->get($entryId);
        if($entry==null)
            return null;

        return $entry->form_id;
    }

    public function CreateRetriever($entry,$formData,$oldEntry=null)
    {
        $form=$this->Loader->FormProcessor->SerializeForm($formData);
        return new WPFormEntryRetriever($this->Loader,$form,$entry,$oldEntry);
    }

    public function CreateRetrieverByEntryId($entryId)
    {
        $entry=wpforms()->entry->get($entryId);
        if($entryId==null)
            return null;
        $form=wpforms()->form->get($entry->form_id);
        $form=\wpforms_decode($form->post_content);
        return $this->Loader->EntryProcessor->CreateRetriever($entry,$form);

    }

}