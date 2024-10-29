<?php

namespace RNAUTO\DTO\Core\Factories;

use RNAUTO\DTO\ActionNodeOptionsDTO;
use RNAUTO\DTO\ApproveNodeOptionsDTO;
use RNAUTO\DTO\RootNodeOptionsDTO;

class DiagramNodeFactory
{
    public static function GetDiagramNode($options)
    {
        switch ($options->Type)
        {
            case 'Root':
                return (new RootNodeOptionsDTO())->Merge($options);
            case 'Action':
                return (new ActionNodeOptionsDTO())->Merge($options);
            case 'approve':
                return (new ApproveNodeOptionsDTO())->Merge($options);
            default:
                throw new \Exception("Unknown exception ".$options->Type);
        }
    }

    public static function GetDiagramNodeList($nodes)
    {
        if($nodes==null)
            return [];
        $result=[];
        foreach($nodes as $currentNode)
        {
            $result[]=self::GetDiagramNode($currentNode);
        }
        return $result;
    }
}