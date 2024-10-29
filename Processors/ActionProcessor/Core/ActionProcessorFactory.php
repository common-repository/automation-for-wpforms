<?php

namespace RNAUTO\Processors\ActionProcessor\Core;


use RNAUTO\pr\Processors\ActionProcessor\AddNoteAction;
use RNAUTO\pr\Processors\ActionProcessor\CancelDeleteAction;
use RNAUTO\pr\Processors\ActionProcessor\CancelSubmissionAction;
use RNAUTO\pr\Processors\ActionProcessor\CancelUpdateAction;
use RNAUTO\pr\Processors\ActionProcessor\ChangeStatusAction;
use RNAUTO\DTO\ActionBaseOptionsDTO;
use RNAUTO\pr\Processors\ActionProcessor\EditEntryAction;
use RNAUTO\pr\Processors\ActionProcessor\ReadUnreadAction;
use RNAUTO\pr\Processors\ActionProcessor\StarUnstarAction;
use RNAUTO\Processors\ActionProcessor\SendEmailAction;

class ActionProcessorFactory
{
    /**
     * @param $Id
     * @param $actionOptions ActionBaseOptionsDTO
     * @return ActionProcessorBase
     * @throws \Exception
     */
    public static function GetActionProcessor($Id, $actionOptions,$workflow=null)
    {
        switch ($actionOptions->Type)
        {
            case 'send_email':
                return new SendEmailAction($Id,$actionOptions);
            case 'update_entry':
                return new EditEntryAction($Id,$actionOptions);
            case 'change_status':
                return new ChangeStatusAction($Id,$actionOptions);
            case 'read_unread':
                return new ReadUnreadAction($Id,$actionOptions);
            case 'star_unstar':
                return new starUnstarAction($Id,$actionOptions);
            case 'add_note':
                return new AddNoteAction($Id,$actionOptions);
            case 'cancel_submission':
                return new CancelSubmissionAction($Id,$actionOptions);
            case 'cancel_update':
                return new CancelUpdateAction($Id,$actionOptions);
            case 'cancel_delete':
                return new CancelDeleteAction($Id,$actionOptions);

        }

        throw new \Exception('Unknown action processor '.$actionOptions->Type);
    }

}