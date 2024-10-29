<?php


namespace RNAUTO\Core\Managers\FileManager;



use Exception;
use Imagick;
use ImagickPixel;
use RNAUTO\Core\Integration\FileIntegration;
use RNAUTO\Core\Loader;

class FileManager
{
    /** @var Loader */
    public $Loader;

    private $_rootPath='';
    private $fileIntegration;

    public function __construct($loader)
    {
        $this->Loader = $loader;
        $this->fileIntegration=new FileIntegration($loader);

    }


    public function GetSafeFileName($path,$name)
    {
        $name=sanitize_file_name($name);
        $ext = pathinfo($name, \PATHINFO_EXTENSION);
        $name = pathinfo($name, \PATHINFO_FILENAME);
        if($ext!='')
            $ext='.'.$ext;
        $newName=$name.$ext;
        if(\file_exists($path.$newName))
        {
            $count=1;

            do
            {
                $newName=$name.'_'.$count.$ext;
                $count++;
            }while((\file_exists($path.$newName)));
        }

        return $newName;

    }

    public function GetLoggerPath(){
        $tempFolder=$this->GetRootFolderPath().'log/';
        $this->MaybeCreateFolder($tempFolder,true);
        return $tempFolder;
    }

    public function GetRootFolderPath()
    {
        if($this->_rootPath=='')
        {
            $this->_rootPath=\str_replace('\\','/', $this->fileIntegration->GetUploadDir().'/'.$this->Loader->Prefix.'/');
            $this->MaybeCreateFolder($this->_rootPath,true);
        }
        return $this->_rootPath;
    }


    private function GetTempFolderRootPath()
    {
        $tempFolder=$this->GetRootFolderPath().'temp/';
        $this->MaybeCreateFolder($tempFolder,true);
        return $tempFolder;
    }

    public function MaybeCreateFolder($directory,$secure=false)
    {
        if(!is_dir($directory))
            if(!mkdir($directory,0777,true))
                throw new Exception('Could not create folder '.$this->_rootPath);
            else{
                if($secure)
                {
                    @file_put_contents( $directory . '.htaccess', 'deny from all' );
                    @touch( $directory . 'index.php' );
                }
            }


    }


    public function GetTempPath()
    {
        $tempFolder=$this->GetRootFolderPath().'temp/';
        $this->MaybeCreateFolder($tempFolder,true);
        return $tempFolder;
    }

}
