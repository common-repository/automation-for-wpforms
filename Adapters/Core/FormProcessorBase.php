<?php

namespace RNAUTO\Adapters\Core;

abstract class FormProcessorBase
{
    public abstract function SyncForms();
    public abstract function ListForms();
    public abstract function SerializeForm($form);
}