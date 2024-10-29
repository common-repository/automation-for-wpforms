<?php

namespace RNAUTO\Processors\TriggerProcessors;

use RNAUTO\Core\DB\AutomationRepository;
use RNAUTO\DTO\EmailActionOptionsDTO;
use RNAUTO\Processors\TriggerProcessors\Core\TriggerProcessorBase;

class BasicTriggerProcessor extends TriggerProcessorBase
{
    /** @var EmailActionOptionsDTO */
    public $Options;
    public $Actions=null;

}