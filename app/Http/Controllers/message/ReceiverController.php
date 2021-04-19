<?php

namespace App\Http\Controllers\message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Twilio\TwiML\MessagingResponse;

class ReceiverController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, MessagingResponse $messageResponse)
    {
        $from = $request->input('From');
        $body = $request->input('Body');
        DB::table('activity_log')
            ->insert([
                'description' => 'WA Bot Response ',
                'properties' => json_encode([
                    'response' => $messageResponse,
                    'from' => $from,
                    'body' => $body
                ])
            ]);
        $messageResponse->message('Are you interested in this job?');
        //$from = $request->input('From');
        //$body = $request->input('Body');
        return response($messageResponse, 200)->header(
            'Content-Type',
            'text/xml'
        );
    }
}
