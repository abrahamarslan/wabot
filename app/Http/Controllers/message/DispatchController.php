<?php

namespace App\Http\Controllers\message;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Sequence;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
class DispatchController extends Controller
{
    protected $data = array();
    public function index(Campaign $campaign) {
        try {
            self::startCampaign($campaign->id);
            //$result = self::sendWhatsAppMessage('This is my first message, brah!', 'whatsapp:+917877045455');
            //dd($result);
        } catch (\Exception $e) {
            dd($e);
            abort(500);
        }
    }

    public function startCampaign($campaignID) {
        try {
            $campaign = Campaign::findOrFail($campaignID);
            $sequences = $campaign->sequences()->get();
            foreach ($sequences as $sequence) {
                // Get all contacts
                $contacts = $campaign->contacts()->get();
                if($contacts && !empty($contacts)){
                    foreach ($contacts as $contact) {
                        $result = $this->sendSequence($campaign->id, $sequence->id, $contact->id);
                        return $result;
                    }
                }
            }

            //$result = self::sendWhatsAppMessage('This is my first message, brah!', 'whatsapp:+917877045455');
            //dd($result);
        } catch (\Exception $e) {
            dd($e);
            abort(500);
        }
    }

    public function sendSequence($campaignID, $sequenceID, $contactID) {
        try {
            $campaign = Campaign::findOrFail($campaignID);
            $sequence = Sequence::findOrFail($sequenceID);
            $contact = Contact::findOrFail($contactID);
            // Check if the current contact already has a campaign running on it
            if($sequence->order == 1 and \MessageHelper::doesContactHaveRunningCampaign($contact->id)) {
                // Queue the campaign for this contact
                if(\MessageHelper::queueCampaign($campaign->id, $sequence->id, $contact->id)) {
                    return true;
                }
            } else if ($sequence->order == 1) {
                if($body = \MessageHelper::composeMessage($sequence->id)) {
                    $sendMessage = self::sendWhatsAppMessage($body, '+'.$contact->country_code.$contact->contact);
                    $update = \MessageHelper::insertRunning($campaign->id, $sequence->id, $contact->id);
                    $message = \MessageHelper::insertMessage(
                        $campaign->id,
                        $sequence->id,
                        $contact->id,
                        config('global.twilio.sandbox_number'),
                        '+'.$contact->country_code.$contact->contact,
                        1,
                        'send',
                        'out',
                        $body,
                        $sendMessage->messagingServiceSid
                    );
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            dd($e);
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
