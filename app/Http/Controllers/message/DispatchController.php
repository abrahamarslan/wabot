<?php

namespace App\Http\Controllers\message;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
class DispatchController extends Controller
{
    protected $data = array();
    public function index(Campaign $campaign) {
        try {
            $result = self::sendWhatsAppMessage('This is my first message, brah!', 'whatsapp:+917877045455');
            dd($result);
        } catch (\Exception $e) {
            dd($e);
            $this->messageBag->add('exception_message', $e->getMessage());
            activity()
                ->withProperties([
                    'content_id' => 0, // Exception
                    'contentType' => 'Exception',
                    'action' => 'index',
                    'description' => 'DefaultController',
                    'details' => 'Error in creating view: ' . $e->getMessage(),
                    'data' => json_encode($e)
                ])
                ->log($e->getMessage());
            abort(500);
        }
    }

    public function sendWhatsAppMessage(string $message, string $recipient)
    {
        $twilio_whatsapp_number = config('global.twilio.sandbox_number');
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");

        $client = new Client($sid, $token);
        return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
    }
}
