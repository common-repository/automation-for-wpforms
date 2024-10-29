<?php

namespace RNAUTO\Adapters\WPForms;

use RNAUTO\DTO\EditEntryItemDTO;
use RNAUTO\Utilities\Sanitizer;

class WPFormsEntry extends Entry
{
    public $UpdatedEntry;
    public $UpdatedFields=[];
    /**
     * @param $retriever WPFormEntryRetriever
     * @param $field EditEntryItemDTO
     * @param $value
     * @return void
     */
    public function UpdateField($retriever,$field, $value)
    {
        $field=$retriever->GetFieldById($field->FieldId);
        if($field==null)
            return;

        if(!isset($this->UpdatedEntry->fields[$field->Field->Id]))
            return;

        $fieldObject=$this->GetFieldObject($field->Field->SubType);
        if($fieldObject==null)
            return;

        $fieldObject->format($field->Field->Id,$value,null,$retriever->Form->Raw);

        $formattedValue=null;
        if(isset(wpforms()->process->fields[$field->Field->Id]))
            $formattedValue=wpforms()->process->fields[$field->Field->Id];

        $this->UpdatedFields[$field->Field->Id]=$formattedValue;
        if($formattedValue!=null)
        {
            $this->UpdatedEntry->fields[$field->Field->Id]=$formattedValue;
        }

    }

    public function SetOriginalEntry($entry)
    {
        parent::SetOriginalEntry($entry);
        $this->UpdatedEntry=$entry;
    }


    private function UpdateTextField(&$originalValue, $value)
    {
        if(!is_string($value))
            return;

        if(!isset($originalValue['value']))
            return;

        $originalValue['value']=$value;


    }

    /**
     * @param $retriever WPFormEntryRetriever
     * @return void
     */
    public function SaveUpdate($retriever)
    {

        if(wpforms()->entry->update($this->EntryId,['fields'=>json_encode($this->UpdatedEntry->fields)],'','edit_entry')!==true)
            return false;
         wpforms()->entry_fields->save($this->UpdatedEntry->fields,['id'=>$this->UpdatedEntry->form_id],$this->EntryId,true);
        apply_filters('automation_edit_completed',$retriever->Form->Raw,[],$this->UpdatedFields,$this->OriginalEntry);
        return true;

    }

    public function GetFieldObject($type){
        $class_name = implode( '', array_map( 'ucfirst', explode( '-', $type ) ) );
        $class_name = '\WPForms\Pro\Forms\Fields\\' . $class_name . '\EntriesEdit';

        // Init object if needed.
        if ( empty( $objects[ $type ] ) ) {
            $objects[ $type ] = class_exists( $class_name ) ? new $class_name() : new EntriesEdit( $type );
        }

        return apply_filters( "wpforms_pro_admin_entries_edit_field_object_{$type}", $objects[ $type ] );
    }

    public function GetUserId(){
        return Sanitizer::SanitizeNumber($this->OriginalEntry->user_id);
    }


    public function GetFormId(){
        return Sanitizer::SanitizeNumber($this->OriginalEntry->form_id);
    }
    public function AddNote($userId,$content,$type='log')
    {
        $entry_meta = wpforms()->get( 'entry_meta' );
        $entry_meta->add(
            [
                'entry_id' => $this->EntryId,
                'form_id'  => $this->GetFormId(),
                'user_id'  => $userId,
                'type'     => $type,
                'data'     => wpautop( $content ),
            ],
            'entry_meta'
        );
    }

    public function UpdateStatus($status)
    {
        \wpforms()->entry->update($this->EntryId,['status'=>$status]);
    }
}