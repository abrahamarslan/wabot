<?php


namespace App\Responders;


use App\Contracts\ResponderContract;

abstract class Responder implements ResponderContract
{
    protected $message;
    protected $option;
    public function __construct(string $message, ?string $option)
    {
        $this->message = $message;
        $this->option = $option;
    }
}
