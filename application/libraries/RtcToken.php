<?php

class RtcToken
{
    public function __construct()
    {
        require_once APPPATH."/third_party/AgoraDynamicKey/php/src/RtcTokenBuilder.php";
        require_once APPPATH."/third_party/AgoraDynamicKey/php/src/RtmTokenBuilder.php";
    }
}
