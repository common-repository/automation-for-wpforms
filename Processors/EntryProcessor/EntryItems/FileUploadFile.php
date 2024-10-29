<?php


namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;

class FileUploadFile{
    public $URL;
    public $Name;
    public $Extension;
    public $Mime;

    /**
     * FileUploadFile constructor.
     */
    public function __construct($url,$name='',$extension='',$mime='')
    {
        $this->URL=$url;
        $this->Name=$name;
        $this->Extension=$extension;
        $this->Mime=$mime;
    }


}

