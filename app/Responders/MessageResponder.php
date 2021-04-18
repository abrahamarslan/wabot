<?php


namespace App\Responders;


class MessageResponder extends Responder
{
    public static function shouldRespond($message, $option)
    {
        return $option;
    }
    public function respond()
    {
        return 'Responding from MessageResponder';
    }
}
