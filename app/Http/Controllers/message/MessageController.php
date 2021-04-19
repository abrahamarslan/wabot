<?php

namespace App\Http\Controllers\message;

use App\Factories\ResponderFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\MessagingResponse;

class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(MessagingResponse $messageResponse)
    {
        $responder = ResponderFactory::create();
        $messageResponse->message($responder->respond());

        return response($messageResponse, 200)->header(
            'Content-Type',
            'text/xml'
        );
    }
}
