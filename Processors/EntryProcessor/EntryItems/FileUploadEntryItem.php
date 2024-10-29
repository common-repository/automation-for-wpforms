<?php


namespace RNAUTO\Processors\EntryProcessor\EntryItems;



use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;
use RNAUTO\Utilities\ArrayUtils;
use RNAUTO\Processors\EntryProcessor\EntryItems\FileUploadFile;
use Twig\Markup;

class FileUploadEntryItem extends EntryItemBase
{
    /** @var FileUploadFile[] */
    public $Files;

    public function __construct()
    {
        parent::__construct();
        $this->Files=[];
    }

    public function AddFile($url='',$name='',$extension='',$mime='')
    {
        $this->Files[]=new FileUploadFile($url,$name,$extension,$mime);
    }

    public function CreateAndAddFile()
    {
        $file=new FileUploadFile('');
        $this->Files[]=$file;
        return $file;
    }
    public function GetText($pathId='')
    {
        $fileNames=ArrayUtils::Map($this->Files,function ($item){return $item->URL;});
        return implode("\n",$fileNames);
    }


    public function GetHtml($pathId='')
    {
        $fileNames=ArrayUtils::Map($this->Files,function ($item){return '<a href="'.$item->URL.'">'.esc_html($item->Name).'</a>';});
        return new Markup(implode("<br/>",$fileNames),"UTF-8");
    }

    public function GetType()
    {
        return 'fileupload';
    }

    public function IsEmpty()
    {
        return count($this->Files)==0;
    }



}

