<?php

namespace RNAUTO\Processors\TriggerProcessors\Core;

use RNAUTO\DTO\TriggerBaseOptionsDTO;
use RNAUTO\Processors\TriggerProcessors\BasicTriggerProcessor;
use RNAUTO\Processors\TriggerProcessors\FormSubmittedTriggerProcessor;

class TriggerProcessorFactory
{
    /**
     * @param $Id
     * @param $triggerOptions TriggerBaseOptionsDTO
     * @return TriggerProcessorBase
     */
    public static function GetTriggerProcessor($loader,$Id, $triggerOptions)
    {
        switch ($triggerOptions->Type)
        {
            case 'form_submitted':
            case 'entry_updated':
            case 'entry_deleted':
            case 'before_submit':
            case 'before_update':
            case 'before_delete':
            case 'none':
                return new BasicTriggerProcessor($loader,$Id,$triggerOptions);
        }

        throw new \Exception('Unknown trigger '.$triggerOptions->Type);
    }


}