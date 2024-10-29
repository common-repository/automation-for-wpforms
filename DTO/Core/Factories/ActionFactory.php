<?php

namespace RNAUTO\DTO\Core\Factories;

use RNAUTO\DTO\AddNoteActionOptionsDTO;
use RNAUTO\DTO\CancelDeleteActionOptionsDTO;
use RNAUTO\DTO\CancelSubmissionActionOptionsDTO;
use RNAUTO\DTO\CancelUpdateActionOptionsDTO;
use RNAUTO\DTO\ChangeStatusActionOptionsDTO;
use RNAUTO\DTO\EmailActionOptionsDTO;
use RNAUTO\DTO\ReadUnreadActionOptionsDTO;
use RNAUTO\DTO\StarUnstarActionOptionsDTO;
use RNAUTO\DTO\UpdateEntryActionOptionsDTO;

class ActionFactory
{
    public static function GetActionArray($options)
    {
        if($options==null)
            return $options;
        $newArray=[];
        foreach($options as $currentAction)
        {
            $newArray[]=self::GetAction($currentAction);
        }
        return $newArray;
    }

    public static function GetAction($option)
    {
        switch ($option->Type)
        {
            case 'send_email':
                return (new EmailActionOptionsDTO())->Merge($option);
            case 'update_entry':
                return (new UpdateEntryActionOptionsDTO())->Merge($option);
            case 'change_status':
                return (new ChangeStatusActionOptionsDTO())->Merge($option);
            case 'read_unread':
                return (new ReadUnreadActionOptionsDTO())->Merge($option);
            case 'star_unstar':
                return (new StarUnstarActionOptionsDTO())->Merge($option);
            case 'add_note':
                return (new AddNoteActionOptionsDTO())->Merge($option);
            case 'cancel_submission':
                return (new CancelSubmissionActionOptionsDTO())->Merge($option);
            case 'cancel_update':
                return (new CancelUpdateActionOptionsDTO())->Merge($option);
            case 'cancel_delete':
                return (new CancelDeleteActionOptionsDTO())->Merge($option);

        }

        throw new \Exception('Undefined action '.$option->Type);
    }
}