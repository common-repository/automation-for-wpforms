<?php

namespace RNAUTO\Core\DB;

use RNAUTO\Core\DB\Core\RepositoryBase;

class AutomationLinkRepository extends RepositoryBase
{
    public function CreateAutomationLink($automationId,$entryId,$referenceId,$options,$expirationDate)
    {
        $this->DBManager->Insert($this->Loader->AUTOMATIONLINK,[
            'automation_id'=>$automationId,
            'entry_id'=>$entryId,
            'reference_id'=>$referenceId,
            'options'=>$options,
            'expiration_date'=>$expirationDate
        ]);

    }


}