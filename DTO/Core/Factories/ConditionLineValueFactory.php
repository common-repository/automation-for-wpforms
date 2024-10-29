<?php


namespace RNAUTO\DTO\Core\Factories;


use RNAUTO\DTO\ConditionLineOptionsDTO;
use RNAUTO\DTO\FieldTypeEnumDTO;

class ConditionLineValueFactory
{
    /**
     * @param $condition ConditionLineOptionsDTO
     * @param $value
     */
    public static function GetValue($condition,$value)
    {
        if($condition->SubType==FieldTypeEnumDTO::$Multiple)
        {
            if($value==''||!is_array($value))
                return [];
        }

        return $value;
    }

}