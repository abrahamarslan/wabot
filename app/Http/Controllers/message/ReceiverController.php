<?php

namespace App\Http\Controllers\message;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Conditional;
use App\Models\Contact;
use App\Models\Sequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;
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
        try {
            $lastSequenceID = -1;
            $nextSequenceID = -1;
            $campaignID = -1;
            $lastConditional = null;
            $nextConditional = null;
            $lastSequence = null;
            $nextSequence = null;
            $from = $request->input('From');
            $body = $request->input('Body');
            $SmsMessageSid = $request->get('SmsMessageSid');
            $ProfileName = $request->get('ProfileName');
            $from_number = $request->get('WaId');
            $to_number = $request->get('To');
            $direction = $request->get('SmsStatus');
            $isSent = 0;
            $type = 'received';
            $receiveDate = date('Y-m-d H:i:s');
            $response = $request->all();
            $errorCode = null;
            $contact = \MessageHelper::getContact($from_number);
            if($contact) {
                $hasRunningCampaign = \MessageHelper::doesContactHaveRunningCampaign($contact->id);
                if($hasRunningCampaign) {
                    $campaignID = $hasRunningCampaign->campaign_id;
                    $lastSequenceID = $hasRunningCampaign->last_sequence_id;
                    $nextSequenceID = $hasRunningCampaign->next_sequence_id;
                    $lastSequence = \MessageHelper::getSequence($lastSequenceID);
                    $nextSequence = \MessageHelper::getSequence($nextSequenceID);
                    // Check if there is any next sequence to send
                    if($nextSequence){
                        //Get the conditionals of the next sequence
                        $lastConditional = Conditional::where('sequence_id', $lastSequence->id)->first();
                        $nextConditional = Conditional::where('sequence_id', $nextSequence->id)->first();
                        //If there is conditional then send according to that conditional
                        if($nextConditional and $nextConditional->hasCondition and $nextConditional->if_sequence == $lastSequenceID) {
                            //Get options of last sequence
                            if($lastSequence and $lastSequence->hasOptions) {
                                // Get options of the last sequence
                                $options = \MessageHelper::hasOptions($lastSequence);
                                //Check if the sequence option selected is same as conditional
                                if($options[$nextConditional->is_sequence_option] == $body or $nextConditional->is_sequence_option == $body) {
                                    // Send this sequence
                                    self::sendSequence($campaignID, $nextSequence->id, $contact->id, $hasRunningCampaign->id);
                                } else {
                                    // Send the else sequence
                                    self::sendSequence($campaignID, $nextConditional->else_sequence, $contact->id, $hasRunningCampaign->id);
                                }
                            }
                        } else {
                            //Just send the next sequence
                            self::sendSequence($campaignID, $nextSequence->id, $contact->id, $hasRunningCampaign->id);
                        }
                    } else {
                        //There is nothing else to send.
                        //End campaign
                        \MessageHelper::completeCampaignForContact($campaignID, $contact->id);
                        return true;
                    }
                } else {
                    // Check if it has queued campaigns

                }
            }
        $messageResponse->message('Are you interested in this job?');
        //$from = $request->input('From');
        //$body = $request->input('Body');
        return response($messageResponse, 200)->header(
            'Content-Type',
            'text/xml'
        );
        } catch (\Exception $e) {

        }
    }



    public function sendSequence($campaignID, $sequenceID, $contactID, $runningID) {
        try {
            $campaign = Campaign::findOrFail($campaignID);
            $sequence = Sequence::findOrFail($sequenceID);
            $contact = Contact::findOrFail($contactID);
            if($body = \MessageHelper::composeMessage($sequence->id)) {
                $sendMessage = self::sendWhatsAppMessage($body, '+'.$contact->country_code.$contact->contact);
                $update = \MessageHelper::updateRunning($sequence->id, $runningID);
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
