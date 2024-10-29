<?php

namespace RNAUTO\Processors\HTMLGenerator\HTMLParsers;


use RNAUTO\DTO\ConditionOptionsBaseDTO;
use RNAUTO\pr\Processors\ConditionProcessor\ConditionProcessor;
use RNAUTO\Processors\HTMLGenerator\HTMLParsers\Core\HTMLParserWithChildren;

class ConditionParser extends HTMLParserWithChildren
{
    /** @var ConditionOptionsBaseDTO */
    public $Condition;

    public function ParseContent()
    {
        $condition=json_decode($this->GetStringAttributeValue('condition'));
        if($condition==false)
            return null;

        if(RNAUTO()->Loader->IsPR())
        {
            $this->Condition = (new ConditionOptionsBaseDTO())->Merge($condition);
            $condition = new ConditionProcessor();
            if ($condition->ShouldProcess(RNAUTO()->Loader,$this->Retriever, $this->Condition))
                return parent::ParseContent();
        }
        return null;
    }


    public function Render()
    {
        return $this->RenderChildren();

    }

    protected function GetTemplateName()
    {
        // TODO: Implement GetTemplateName() method.
    }
}