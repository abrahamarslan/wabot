<?php

namespace App\Responders;

use App\Constants\Conversations;
use App\Constants\Keywords;

class GreetResponder extends Responder
{
    public static function shouldRespond($message, $option)
    {
        return $message === Keywords::GREET;
    }

    public function respond()
    {
        return Conversations::GREET;
    }
}
