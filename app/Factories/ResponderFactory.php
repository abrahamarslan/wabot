<?php


namespace App\Factories;


use App\Responders\InvalidKeywordResponder;
use Illuminate\Support\Facades\Log;

class ResponderFactory
{
    /**
     * Responder
     */
    protected $responder;

    /** @var string */
    protected $phoneNumber;

    /** @var string */
    protected $message;

    /** @var string */
    protected $option;
    public function __construct(string $phonenumber, ?string $message, ?string $option)
    {
        $this->phoneNumber = $phonenumber;
        $this->message = $message;
        Log::info('Here is the message');
        //Log::info(print_r($messageResponse, true));
        Log::info($message);
        $this->option = $option;
        $this->responder = $this->resolveResponder($this->message, $this->option);
    }
    /**
     * factory to create a responder.
     */
    public static function create()
    {
        $self =  new static(
            request()->input('From'),
            request()->input('Body'),
            request()->input('Message')
        );

        return $self->responder;
    }

    /**
     * Trim and lower case the message
     * @return string
     */
    protected function normalizeMessage(?string $message): ?string
    {
        return trim(strtolower($message));
    }

    /**
     * Resolve responder
     * @param string|null $message
     * @param string|null $longitude
     * @param string|null $latitude
     */
    public function resolveResponder(?string $message, ?string $option)
    {
        $message =  $this->normalizeMessage($message);

        $responders = $this->getReponders();

        foreach ($responders as $responder) {
            if ($responder::shouldRespond($message, $option)) {
                return new $responder($message, $option);
            }
        }
        return new InvalidKeywordResponder($this->message, $this->option);
    }

    /**
     * Get all available responders
     * @return array
     */
    public function getReponders(): array
    {
        return config('wabot.responders');
    }
}
