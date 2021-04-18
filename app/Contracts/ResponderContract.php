<?php


namespace App\Contracts;


interface ResponderContract
{
    /**
     * check whether to respond to a user message
     * @param string|null $message
     * @param string|null $option
     * @return bool
     */
    public static function shouldRespond(?string $message, ?string $option);

    /**
     * respond to a user by returning a response
     * @return string
     */
    public function respond();
}
