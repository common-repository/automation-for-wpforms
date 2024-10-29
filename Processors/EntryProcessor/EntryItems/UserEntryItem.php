<?php


namespace RNAUTO\Processors\EntryProcessor\EntryItems;


use RNAUTO\Processors\EntryProcessor\EntryItems\Core\EntryItemBase;

class UserEntryItem extends EntryItemBase
{
    public $UserId=0;


    public function GetText($pathId='')
    {
        $user=\get_user_by('ID',$this->UserId);
        if($user==false)
            return '';
        return $user->user_nicename;

    }

    public function SetUserId($value)
    {
        $this->UserId=$value;
        return $this;
    }

    public function GetHtml($style = 'standard')
    {
        // TODO: Implement GetHtml() method.
    }

    public function GetType()
    {
        return 'user';
    }

    public function IsEmpty()
    {
        return $this->UserId==0;
    }


}