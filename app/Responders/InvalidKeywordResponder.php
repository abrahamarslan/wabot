<?php


namespace App\Responders;


use App\Constants\Conversations;

class InvalidKeywordResponder extends Responder
{
    public static function shouldRespond($message, $option)
    {
        return true;
    }

    public function respond()
    {
        return Conversations::INVALID_KEYWORD;
    }
}
