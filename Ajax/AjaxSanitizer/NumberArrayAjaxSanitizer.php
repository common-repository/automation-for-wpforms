<?php

namespace RNAUTO\Ajax\AjaxSanitizer;

use RNAUTO\Utilities\Sanitizer;

class NumberArrayAjaxSanitizer extends ArrayAjaxSanitizerBase
{

    protected function SanitizeItem($item)
    {
        return Sanitizer::SanitizeNumber($item,null);
    }
}