<?php


namespace App\Responders;


class MessageResponder extends Responder
{
    public static function shouldRespond($message, $option)
    {
        return $message;
    }
    public function respond()
    {
        return 'Responding from MessageResponder';
    }
}
