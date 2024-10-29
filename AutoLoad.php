<?php

spl_autoload_register('RNAUTOLoad');
function RNAUTOLoad($className)
{
    if(strpos($className,'RNAUTO\\')!==false)
    {
        $NAME=basename(\dirname(__FILE__));
        $DIR=dirname(__FILE__);
        $path=substr($className,6);
        $path=str_replace('\\','/', $path);
        require_once $DIR.$path.'.php';
    }
}