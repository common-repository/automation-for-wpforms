<?php

namespace RNAUTO\Processors\ActionProcessor;


use RNAUTO\Adapters\WPForms\WPFormEntryRetriever;
use RNAUTO\Core\Managers\LogManager\LogManager;
use RNAUTO\DTO\EmailActionOptionsDTO;
use RNAUTO\Processors\ActionProcessor\Core\ActionProcessorBase;
use RNAUTO\Processors\HTMLGenerator\HTMLGenerator;
use RNAUTO\Processors\SingleLineGenerator\SingleLineGenerator;
use stdClass;

class SendEmailAction extends ActionProcessorBase
{
    /** @var EmailActionOptionsDTO */
    public $Options;
    public function Execute($formBuilder)
    {
        $generator=new HTMLGenerator($formBuilder,$this->Options->Email,null);
        $html=$generator->GetHTML();
        $toEmailAddress=$this->ProcessEmails($formBuilder,$this->Options->To);
        $bcc=$this->ProcessEmails($formBuilder,$this->Options->BCC);
        $cc=$this->ProcessEmails($formBuilder,$this->Options->CC);
        $replyTo=$this->ProcessEmails($formBuilder,$this->Options->ReplyTo);
        $headers=[
            'From: '.$this->GetFromName(),
            'Content-Type: text/html; charset=UTF-8'
        ];



        if($cc!='')
            $headers[]='CC:'.$cc;

        if($bcc!='')
            $headers[]='BCC:'.$bcc;

        if($replyTo!='')
            $headers[]='Reply-To:'.$replyTo;

        if($toEmailAddress=='')
        {
            $toEmailAddress=get_bloginfo('admin_email');
        }

        $singleLine=new SingleLineGenerator($formBuilder);


        $emailData=new stdClass();
        $emailData->to=$toEmailAddress;
        $emailData->Subject=$singleLine->GetText($this->Options->Subject);
        $emailData->Content=$html;
        $emailData->Headers=$headers;
        $emailData->Attachments=[];
        $success= wp_mail($emailData->to,$emailData->Subject,$emailData->Content,$emailData->Headers,$emailData->Attachments);
        if($success)
            LogManager::LogDebug('Wordpress was able to request the email to be send');
        else
            LogManager::LogDebug('Wordpress was able to send the email request successfully');

        return $this->GenerateActionResult();
    }

    private function GetFromName()
    {

        $fromName=$this->Options->FromName;
        if($fromName=='')
        {
            $fromName=get_bloginfo('name');
        }

        $rule = array("\r" => '',
            "\n" => '',
            "\t" => '',
            '"'  => "'",
            '<'  => '[',
            '>'  => ']',
        );

        $fromName= trim(strtr($fromName, $rule));
        $FromEmail=$this->Options->FromEmailAddress;
        if($FromEmail=='')
            $FromEmail = apply_filters('wp_mail_from', get_bloginfo('admin_email'));


        return $fromName." <$FromEmail>";


    }

    /**
     * @param $formBuilder WPFormEntryRetriever
     * @param $emailAddresses
     * @return string
     */
    private function ProcessEmails($formBuilder,$emailAddresses)
    {
        $emails=[];
        foreach($emailAddresses as $currentEmail)
        {
            if($currentEmail->Type=='Field')
            {
                $emailToAdd=$this->GetEmailFromField($formBuilder,$currentEmail->Value);
                if(is_array($emailToAdd))
                {
                    foreach($emailToAdd as $email)
                        $emails[]=$email;
                }else
                    if($emailToAdd!='')
                        $emails[]=$emailToAdd;
            }else{
                $emails[]=$currentEmail->Value;
            }
        }
        return \implode(',',$emails);
    }

    /**
     * @param $formBuilder WPFormEntryRetriever
     * @param $Value
     * @return array|string
     */
    private function GetEmailFromField($formBuilder,$Value)
    {
        $field=$formBuilder->GetFieldById($Value);
        if($field==null)
            return '';

        if($field->GetType()=='Multiple')
        {
            $selectedOptions=$field->GetSelectedOptions();
            $emailsToUse=[];
            foreach($selectedOptions as $currentSelectedOption)
            {
                if (filter_var($currentSelectedOption->RegularPrice, FILTER_VALIDATE_EMAIL)) {
                    $emailsToUse[]=$currentSelectedOption->RegularPrice;
                }
            }
            return $emailsToUse;

        }else
            $Value=$field->GetText();

        if (!filter_var($Value, FILTER_VALIDATE_EMAIL)) {
            return '';
        }

        return $Value;

    }

}