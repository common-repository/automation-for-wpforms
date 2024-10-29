<?php

namespace RNAUTO\Processors\EntryProcessor;

use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Core\Loader;

abstract class EntryProcessorBase
{
    /** @var Loader */
    public $Loader;

    /**
     * @param $Loader
     */
    public function __construct($loader)
    {
        $this->Loader = $loader;
    }

    public abstract function UpdateEntry($entryId,$dataToUpdate);

    public abstract function SerializeEntry($entry,$formSettings);
    public abstract function GetFormId($entryId);

    /**
     * @param $entry
     * @param $formData
     * @param $oldEntry
     * @return WPFormEntryRetriever
     */
    public abstract function CreateRetriever($entry,$formData,$oldEntry);
    public abstract function CreateRetrieverByEntryId($entryId);


}