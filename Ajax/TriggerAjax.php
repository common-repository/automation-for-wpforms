<?php

namespace RNAUTO\Ajax;

use RNAUTO\Processors\LinkProcessor\LinkProcessor;

class TriggerAjax extends AjaxBase
{

    function GetDefaultNonce()
    {
        // TODO: Implement GetDefaultNonce() method.
    }

    protected function RegisterHooks()
    {
        add_action('wp_ajax_nopriv_RNAUTO_process_link',[$this,'ProcessLink']);
        add_action('wp_ajax_RNAUTO_process_link',[$this,'ProcessLink']);

        $this->RegisterPrivate('process_link','ProcessLink','',false);
    }

    public function ProcessLink()
    {
        if(!isset($_GET['t']))
            return "Invalid link";
        $data=json_decode(base64_decode($_GET['t']));

        if(!isset($data->AutomationId)||!isset($data->EntryId))
            return 'Invalid link';

        $linkProcessor=new LinkProcessor();
        $result=$linkProcessor->ProcessLink($_GET['t']);
        echo $result->Output;
        die();
    }

    private function PrintSuccessMessage($content)
    {
        ?>
        <html>
            <body style="font-family: Verdana">
                <div style="width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;flex-direction: column">
                    <img style="width:256px " src="<?php echo $this->Loader->URL?>images/success.svg"/>
                    <?php echo $content?>
                </div>
            </body>
        </html>
        <?php
    }

    private function PrintErrorMessage($content)
    {
        ?>
        <html>
        <body style="font-family: Verdana">
        <div style="width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;flex-direction: column">
            <img style="width:256px " src="<?php echo $this->Loader->URL?>images/error.svg"/>
            <?php echo $content?>
        </div>
        </body>
        </html>
        <?php
    }
}