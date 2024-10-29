<?php

namespace RNAUTO\DTO\Core\Factories;

use RNAUTO\DTO\TriggerBaseOptionsDTO;

class TriggerFactory
{
    public static function GetTrigger($options)
    {
        if($options==null)
            return $options;
        switch ($options->Type)
        {
            case 'form_submitted':
            case 'entry_updated':
            case 'entry_deleted':
            case 'before_submit':
            case 'before_update':
            case 'before_delete':
            case 'none':
                return (new TriggerBaseOptionsDTO())->Merge($options);
        }

        throw new \Exception('Unknown trigger '.$options->Type);
    }
}