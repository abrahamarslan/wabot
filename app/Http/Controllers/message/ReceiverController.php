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
                    \MessageHelper::insertReceivedMessage([
                       'campaign_id'        =>  $campaignID,
                       'sequence_id'        =>  $lastSequenceID,
                       'contact_id'        =>  $contact->id,
                       'SmsMessageSid'        =>  $SmsMessageSid,
                       'ProfileName'        =>  $ProfileName,
                       'from_number'        =>  $from_number,
                       'to_number'        =>  $to_number,
                       'isSent'        =>  $isSent,
                       'direction'        => $direction,
                       'type'        =>  $type,
                       'send_date'        =>  $receiveDate,
                       'errorCode'        =>  $errorCode,
                       'body'        =>  $body,
                       'response'        =>  $response,

                    ]);
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
                                    $result = self::sendSequence($campaignID, $nextSequence->id, $contact->id, $hasRunningCampaign->id);
                                    \MessageHelper::dumpOnTable('sequence sending if option = conditional', $result);
                                    $messageResponse->message($result);
                                    return response($messageResponse, 200)->header(
                                        'Content-Type',
                                        'text/xml'
                                    );

                                } else {
                                    // Send the else sequence
                                    $nextID = ($nextConditional->else_sequence == -1 ? \MessageHelper::getNextSequenceID($nextSequenceID) : $nextConditional->else_sequence);
                                    $result = self::sendSequence($campaignID, $nextID, $contact->id, $hasRunningCampaign->id);
                                    $messageResponse->message($result);
                                    \MessageHelper::dumpOnTable('sequence sending if else', $result);

                                    return response($messageResponse, 200)->header(
                                        'Content-Type',
                                        'text/xml'
                                    );
                                }
                            }
                        } else {
                            //Just send the next sequence
                            $result = self::sendSequence($campaignID, $nextSequence->id, $contact->id, $hasRunningCampaign->id);
                            \MessageHelper::dumpOnTable('sending sequence', $result);
                            $messageResponse->message($result);
                            return response($messageResponse, 200)->header(
                                'Content-Type',
                                'text/xml'
                            );
                        }
                    } else {
                        //There is nothing else to send.
                        //End campaign
                        \MessageHelper::dumpOnTable('Ending campaign', null);
                        \MessageHelper::completeCampaignForContact($campaignID, $contact->id);
                        $messageResponse->message('Bye!');
                        return response($messageResponse, 200)->header(
                            'Content-Type',
                            'text/xml'
                        );
                        return true;
                    }
                } else {
                    \MessageHelper::dumpOnTable('No campaign', null);
                    // Check if it has queued campaigns
                    $messageResponse->message('Some error occurred - 1050');
                    return response($messageResponse, 200)->header(
                        'Content-Type',
                        'text/xml'
                    );
                }
            }
        //$messageResponse->message('Are you interested in this job?');
        //$from = $request->input('From');
        //$body = $request->input('Body');
        } catch (\Exception $e) {
            \MessageHelper::dumpOnTable('Some error in Receiver Controller', null);
            $messageResponse->message('Error');
            return response($messageResponse, 200)->header(
                'Content-Type',
                'text/xml'
            );
        }
    }



    public function sendSequence($campaignID, $sequenceID, $contactID, $runningID) {
        try {
            $campaign = Campaign::findOrFail($campaignID);
            $sequence = Sequence::findOrFail($sequenceID);
            $contact = Contact::findOrFail($contactID);
            if($body = \MessageHelper::composeMessage($sequence->id)) {
                //$sendMessage = self::sendWhatsAppMessage($body, 'whatsapp:+'.$contact->country_code.$contact->contact);
                $update = \MessageHelper::updateRunning($runningID, $sequence->id);
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
                    null
                );
                return $body;
            }
            return false;
        } catch (\Exception $e) {
            activity()
                ->log(json_encode($e));
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
