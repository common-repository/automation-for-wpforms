<?php


namespace RNAUTO\Core;


abstract class PageBase
{
    /** @var Loader */
    public $Loader;
    public function __construct($loader)
    {
        $this->Loader=$loader;
    }

    public abstract function Render();


}